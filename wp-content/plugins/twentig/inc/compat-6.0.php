<?php
/**
 * Back compatibility with WordPress 6.0 and below.
 *
 * @package twentig
 */

/**
 * Enqueue layout styles for block themes.
 */
function twentig_compat_block_theme_enqueue_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Match styles from wp_get_layout_style().
	$block_gap             = wp_get_global_settings( array( 'spacing', 'blockGap' ) );
	$has_block_gap_support = isset( $block_gap ) ? null !== $block_gap : false;

	$layout_styles = '
	.layout-default > :where(:not(.alignleft):not(.alignright)) { max-width: var(--layout--content-size); margin-left: auto !important; margin-right: auto !important; }		
	.layout-default > .alignwide { max-width: var(--layout--wide-size); }
	.layout-default .alignfull { max-width: none; }
	.layout-default .alignleft { float: left; margin-inline-start: 0; margin-inline-end: 2em; }
	.layout-default .alignright { float: right; margin-inline-start: 2em; margin-inline-end: 0; }
	.layout-default .aligncenter { margin-left: auto !important; margin-right: auto !important; }';

	if ( $has_block_gap_support ) {
		$layout_styles .= '
		:where(.layout-default):not(.has-gap) > * { margin-block-start: 0; margin-block-end: 0; }
		:where(.layout-default):not(.has-gap) > * + * {	margin-block-start: var( --wp--style--block-gap ); margin-block-end: 0; }';
	}
	
	$default_layout = wp_get_global_settings( array( 'layout' ) );	
	$content_width  = get_option( 'twentig_content_size' );
	$wide_width     = get_option( 'twentig_wide_size' );
	$content_width  = $content_width ? $content_width : $default_layout['contentSize'];		
	$wide_width     = $wide_width ? $wide_width : $default_layout['wideSize'];
			
	$layout_styles .= 'body {';		
	if ( $content_width ) {
		$layout_styles .= '--layout--content-size:' . esc_html( $content_width ) . ';';
	}
	if ( $wide_width ) {
		$layout_styles .= '--layout--wide-size:' . esc_html( $wide_width ) . ';';
	}
	$layout_styles .= '}';
		
	wp_add_inline_style( 'global-styles', twentig_minify_css( $layout_styles ) );

	$query_title_css = '
	.tw-prefix-hidden .archive-title-prefix {
		clip: rect(1px,1px,1px,1px);
		word-wrap: normal!important;
		border: 0;
		-webkit-clip-path: inset(50%);
		clip-path: inset(50%);
		height: 1px;
		margin: -1px;
		overflow: hidden;
		padding: 0;
		position: absolute;
		width: 1px;
	}';

	wp_add_inline_style( "wp-block-query-title", twentig_minify_css( $query_title_css ) );

}
add_action( 'wp_enqueue_scripts', 'twentig_compat_block_theme_enqueue_scripts', 11 );

/**
 * Renders the layout config to the block wrapper.
 * Overrides wp_render_layout_support_flag() core function to make the default layout work as a preset.
 *
 * @param  string $block_content Rendered block content.
 * @param  array  $block         Block object.
 * @return string                Filtered block content.
 */
function twentig_render_layout_support_flag( $block_content, $block ) {
	$block_type     = WP_Block_Type_Registry::get_instance()->get_registered( $block['blockName'] );
	$support_layout = block_has_support( $block_type, array( '__experimentalLayout' ), false );

	if ( ! $support_layout ) {
		return $block_content;
	}

	$block_gap             = wp_get_global_settings( array( 'spacing', 'blockGap' ) );
	$default_layout        = wp_get_global_settings( array( 'layout' ) );
	$has_block_gap_support = isset( $block_gap ) ? null !== $block_gap : false;
	$default_block_layout  = twentig_array_get( $block_type->supports, array( '__experimentalLayout', 'default' ), array() );
	$used_layout           = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : $default_block_layout;

	$class_names     = array();
	$container_class = wp_unique_id( 'wp-container-' );
	$class_names[]   = $container_class;

	if ( ! empty( $used_layout['type'] ) && 'flex' === $used_layout['type'] ) {
		$class_names[] = 'is-layout-flex';
	}

	if ( ! empty( $block['attrs']['layout']['orientation'] ) ) {
		$class_names[] = 'is-' . sanitize_title( $block['attrs']['layout']['orientation'] );
	}

	if ( ! empty( $block['attrs']['layout']['justifyContent'] ) ) {
		$class_names[] = 'is-content-justification-' . sanitize_title( $block['attrs']['layout']['justifyContent'] );
	}

	if ( ! empty( $block['attrs']['layout']['flexWrap'] ) && 'nowrap' === $block['attrs']['layout']['flexWrap'] ) {
		$class_names[] = 'is-nowrap';
	}

	$gap_value = twentig_array_get( $block, array( 'attrs', 'style', 'spacing', 'blockGap' ) );

	if ( is_array( $gap_value ) ) {
		foreach ( $gap_value as $key => $value ) {
			$gap_value[ $key ] = $value && preg_match( '%[\\\(&=}]|/\*%', $value ) ? null : $value;
		}
	} else {
		$gap_value = $gap_value && preg_match( '%[\\\(&=}]|/\*%', $gap_value ) ? null : $gap_value;
	}

	$fallback_gap_value = twentig_array_get( $block_type->supports, array( 'spacing', 'blockGap', '__experimentalDefault' ), '0.5em' );

	if ( isset( $used_layout['inherit'] ) && $used_layout['inherit'] ) {
		if ( ! $default_layout ) {
			return $block_content;
		}

		$used_layout = array( 
			'contentSize' => '',
			'wideSize'    => ''
		);

		$class_names[] = 'layout-default';

		$block_content = preg_replace(
			'/' . preg_quote( 'class="', '/' ) . '/',
			'class="' . esc_attr( implode( ' ', $class_names ) ) . ' ',
			$block_content,
			1
		);

		if ( ! $gap_value ) {
			return $block_content;
		}
	}
	
	$style = '';

	if ( function_exists( 'wp_should_skip_block_supports_serialization') ) {
		$should_skip_gap_serialization = wp_should_skip_block_supports_serialization( $block_type, 'spacing', 'blockGap' );
		$style                         = wp_get_layout_style( ".$container_class", $used_layout, $has_block_gap_support, $gap_value, $should_skip_gap_serialization, $fallback_gap_value );
	} else {
		$style = wp_get_layout_style( ".$container_class", $used_layout, $has_block_gap_support, $gap_value );	
	}

	if ( $gap_value && in_array( $block['blockName'], [ 'core/group', 'core/columns', 'core/column' ], true ) ) {
		$class_names[] = 'has-gap';
	}

	$content = preg_replace(
		'/' . preg_quote( 'class="', '/' ) . '/',
		'class="' . esc_attr( implode( ' ', $class_names ) ) . ' ',
		$block_content,
		1
	);

	add_action(
		'wp_head',
		static function () use ( $style ) {
			echo "<style>$style</style>";
		}
	);
		
	return $content;
}
remove_filter( 'render_block', 'wp_render_layout_support_flag' );
add_filter( 'render_block', 'twentig_render_layout_support_flag', 10, 2 );

/**
 * Updates post editor settings to add fonts and width settings.
 *
 * @param array  $settings Default editor settings.
 *
 * @return array Filtered editor settings.
 */
function twentig_filter_global_styles_settings( $settings ) {	

	if ( isset( $settings['__experimentalFeatures'] ) ) {
		$default_layout = wp_get_global_settings( array( 'layout' ) );
		$content_width  = get_option( 'twentig_content_size' );
		$content_width  = $content_width ? $content_width : $default_layout['contentSize'];
		$wide_width     = get_option( 'twentig_wide_size' );
		$wide_width     = $wide_width ? $wide_width : $default_layout['wideSize'];

		$settings['__experimentalFeatures']['layout']['contentSize'] = $content_width;
		$settings['__experimentalFeatures']['layout']['wideSize'] = $wide_width;
	
		// Make sure the path to __experimentalFeatures.typography.fontFamilies.theme exists before updating fonts.
		if ( empty( $settings['__experimentalFeatures']['typography'] ) ) {
			$settings['__experimentalFeatures']['typography'] = array();
		}
		if ( empty( $settings['__experimentalFeatures']['typography']['fontFamilies'] ) ) {
			$settings['__experimentalFeatures']['typography']['fontFamilies'] = array();
		}
		if ( empty( $settings['__experimentalFeatures']['typography']['fontFamilies']['theme'] ) ) {
			$settings['__experimentalFeatures']['typography']['fontFamilies']['theme'] = array();
		}

		$fonts = $settings['__experimentalFeatures']['typography']['fontFamilies']['theme'];			
		$settings['__experimentalFeatures']['typography']['fontFamilies']['theme'] = twentig_merge_fonts_to_theme_fonts( $fonts );
	}

	return $settings;
}
add_filter( 'block_editor_settings_all', 'twentig_filter_global_styles_settings' );

/**
 * Updates the Global Styles controller route.
 *
 * @see WP_REST_Global_Styles_Controller.
 */
function twentig_register_global_styles_rest_route() {
	
	$controller = new WP_REST_Global_Styles_Controller();
	register_rest_route(
		'wp/v2',
		sprintf(
			'/%s/themes/(?P<stylesheet>%s)',
			'global-styles',
			'[^\/:<>\*\?"\|]+(?:\/[^\/:<>\*\?"\|]+)?'
		),
		array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => 'twentig_get_theme_item_global_styles',
				'permission_callback' => array( $controller, 'get_theme_item_permissions_check'),
				'args'                => array(
					'stylesheet' => array(
						'description'       => 'The theme identifier',
						'type'              => 'string',
						'sanitize_callback' => array( $controller, '_sanitize_global_styles_callback' ),
					),
				),
			),
		),
		true
	);
}
add_action( 'rest_api_init', 'twentig_register_global_styles_rest_route', 100 );

/**
 * Returns the given theme global styles config.
 * 
 * @param WP_REST_Request $request The request instance.
 * @return WP_REST_Response|WP_Error
*/
function twentig_get_theme_item_global_styles( $request ) {

	$controller = new WP_REST_Global_Styles_Controller();
	$response = $controller->get_theme_item( $request );

	if ( $response->data['settings'] ) {
		
		$settings       = $response->data['settings'];
		$default_layout = wp_get_global_settings( array( 'layout' ) );	
		$content_width  = get_option( 'twentig_content_size' );
		$content_width  = $content_width ? $content_width : $default_layout['contentSize'];
		$wide_width     = get_option( 'twentig_wide_size' );
		$wide_width     = $wide_width ? $wide_width : $default_layout['wideSize'];

		$settings['layout']['contentSize'] = $content_width;
		$settings['layout']['wideSize'] = $wide_width;

		// Make sure the path to settings.typography.fontFamilies.theme exists before updating fonts.
		if ( empty( $settings['typography'] ) ) {
			$settings['typography'] = array();
		}
		if ( empty( $settings['typography']['fontFamilies'] ) ) {
			$settings['typography']['fontFamilies'] = array();
		}
		if ( empty( $settings['typography']['fontFamilies']['theme'] ) ) {
			$settings['typography']['fontFamilies']['theme'] = array();
		}

		$fonts = $settings['typography']['fontFamilies']['theme'];		
		$settings['typography']['fontFamilies']['theme'] = twentig_merge_fonts_to_theme_fonts( $fonts );

		$response->data['settings'] = $settings;
	}
	return $response;
}

/**
 * Registers additional global editor settings.
 */
function twentig_compat_register_site_editor_settings() {
	
	$default_layout = wp_get_global_settings( array( 'layout' ) );	

	register_setting(
		'twentig_content_size',
		'twentig_content_size',
		array(
			'type'              => 'string',
			'show_in_rest'      => true,
			'default'           => isset( $default_layout['contentSize'] ) ? $default_layout['contentSize'] : '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	register_setting(
		'twentig_wide_size',
		'twentig_wide_size',
		array(
			'type'              => 'string',
			'show_in_rest'      => true,
			'default'           => isset( $default_layout['wideSize'] ) ? $default_layout['wideSize'] : '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

}
add_action( 'init', 'twentig_compat_register_site_editor_settings' );

/**
 * Wraps the archive title prefix with a span.
 *
 * @param string $prefix Archive title prefix.
 */
function twentig_set_archive_title_block_prefix( $prefix ) {
	if ( wp_is_block_theme() ) {
		return '<span class="archive-title-prefix">' . $prefix . '</span>';
	}
	return $prefix;
}
add_filter( 'get_the_archive_title_prefix', 'twentig_set_archive_title_block_prefix' );
