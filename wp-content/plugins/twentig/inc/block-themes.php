<?php
/**
 * Additional functionalities for block themes.
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require TWENTIG_PATH . 'inc/custom-fonts.php';

/**
 * Enqueue styles for block themes: spacing, layout, fonts.
 */
function twentig_block_theme_enqueue_scripts() {

	$min            = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$latest_version = is_wp_version_compatible( '6.1' ) ? true : false; 

	if ( twentig_theme_supports_spacing() ) {
		$css_version = $latest_version ? 'tw-spacing' : 'tw-spacing-6.0';
		wp_enqueue_style(
			'twentig-global-spacing',
			TWENTIG_ASSETS_URI . "/blocks/{$css_version}{$min}.css",
			array(),
			TWENTIG_VERSION
		);
	}
	
	/* Fix columns core spacing */
	if ( $latest_version ) {

		$cols_horizontal_gap = twentig_theme_supports_spacing() ? '32px' : 'var(--wp--style--block-gap)';
		$cols_spacing        = wp_get_global_styles(
			array( 'spacing', 'blockGap' ),
			array( 'block_name' => 'core/columns' )
		);

		if ( $cols_spacing ) {
			if ( is_array( $cols_spacing ) && isset( $cols_spacing['left'] ) ) {
				$cols_horizontal_gap = $cols_spacing['left'];
			} elseif ( is_string( $cols_spacing ) ) {
				$cols_horizontal_gap = $cols_spacing;
			}
		}

		$columns_css = "body .wp-block-columns.tw-cols-h-gap {column-gap:{$cols_horizontal_gap};}";
		wp_add_inline_style( 'global-styles', $columns_css );
	}

	/* Fonts */
	global $template_html;

	$merged_json        = WP_Theme_JSON_Resolver::get_merged_data()->get_raw_data();
	$theme_fonts        = $merged_json['settings']['typography']['fontFamilies']['theme'];
	$fonts              = twentig_get_additional_fonts();
	$global_styles      = wp_get_global_styles();
	$stylesheet         = json_encode( $global_styles );
	$enqueue_fonts      = [];
	$font_vars          = '';
	$font_classes       = '';	
	$content_to_check   = $stylesheet . $template_html;

	foreach( $theme_fonts as $index => $font ) {
		if ( isset( $font['provider'] ) && $font['provider'] === 'google' ) {
			unset( $theme_fonts[ $index ] );
		}
	}

	wp_add_inline_style( 'global-styles', twentig_get_custom_font_css_variables() );

	foreach( $fonts as $font ) {	
		$family_slug = sanitize_title( $font['slug'] );
		$family      = $font['fontFamily'];
		if ( in_array( $family_slug, array_column( $theme_fonts, 'slug' ) ) ) {
			continue;
		}
		
		if ( false !== strpos( $content_to_check, json_encode( $family ) ) || 
			false !== strpos( $content_to_check, 'var(--wp--preset--font-family--' . $family_slug . ')' ) ||
			false !== strpos( $content_to_check, 'has-' . $family_slug . '-font-family' ) ||
			false !== strpos( $content_to_check, 'var:preset|font-family|' . $family_slug ) ) {
				$enqueue_fonts[] = $font['src'];
				$font_vars      .= "--wp--preset--font-family--{$family_slug}:{$family};";
				$font_classes   .= ".has-{$family_slug}-font-family{font-family:var(--wp--preset--font-family--{$family_slug})!important;}";	
		}
	}

	if ( ! empty( $enqueue_fonts ) ) {
	
		$typography = get_option( 'twentig_typography' );
		$local      = isset( $typography['local'] ) ? $typography['local'] : true;
		$remote_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_unique( array_values( $enqueue_fonts ) ) ) . '&display=swap';

		if ( $local ) {
			require_once TWENTIG_PATH . 'inc/wptt-webfont-loader.php';
			
			// Enqueue the stylesheet.
			wp_register_style( 'twentig-webfonts', '' );
			wp_enqueue_style( 'twentig-webfonts' );

			// Add the styles to the stylesheet.
			wp_add_inline_style( 'twentig-webfonts', twentig_minify_css( wptt_get_webfont_styles( $remote_url ) ) );

		} else {
			wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
				'twentig-google-fonts',
				esc_url_raw( $remote_url ),
				array(),
				null
			);
		}

		if ( ! $latest_version ) {
			wp_add_inline_style( 'global-styles', 'body{' . $font_vars . '}' . $font_classes );
		}
	}

	/* Group shape */
	if ( false !== strpos( $template_html, 'tw-bottom-shape' ) || false !== strpos( $template_html, 'tw-top-shape' ) ) {
		$styles_file = TWENTIG_PATH . "dist/blocks/group/shape.min.css";
		$styles = file_get_contents( $styles_file );
		wp_add_inline_style( "wp-block-group", $styles );
	}

	/* Buttons inside navigation */
	wp_add_inline_style( 'wp-block-navigation-link', twentig_generate_navigation_styles( $global_styles ) );

}
add_action( 'wp_enqueue_scripts', 'twentig_block_theme_enqueue_scripts', 11 );

/**
 * Enqueue styles inside the editor.
 */
function twentig_block_theme_editor_styles() {

	$latest_version = is_wp_version_compatible( '6.1' ) ? true : false; 

	if ( current_theme_supports( 'tw-spacing' ) && get_option( 'twentig_global_spacing', twentig_default_global_spacing() ) ) {
		if ( $latest_version ) {
			add_editor_style( TWENTIG_ASSETS_URI . '/blocks/tw-spacing-editor.css' );
		} else {
			add_editor_style( TWENTIG_ASSETS_URI . '/blocks/tw-spacing-editor-6.0.css' );
		}
	}

	$fse_blocks = [
		'post-template',
		'search',
		'tag-cloud',
		'post-terms',
		'post-navigation-link',
		'query-pagination',
		'separator'
	];

	foreach ( $fse_blocks as $block_name ) {
		$style_path = TWENTIG_PATH . "dist/blocks/$block_name/style.min.css";
		if ( file_exists( $style_path ) ) {
			add_editor_style( TWENTIG_ASSETS_URI . "/blocks/{$block_name}/style.min.css" );
		}
	}

	$fonts         = twentig_get_additional_fonts();
	$css           = '';
	$css_vars      = '';
	$enqueue_fonts = [];

	$css .= twentig_get_custom_font_css_variables();	

	foreach( $fonts as $font ) {
		$family          = $font['fontFamily'];
		$family_slug     = sanitize_title( $font['slug'] );		
		$css_vars       .= "--wp--preset--font-family--{$family_slug}:{$family};";
		$css            .= ".has-{$family_slug}-font-family{font-family:var(--wp--preset--font-family--{$family_slug})!important;}";
		$enqueue_fonts[] = $font['src'];
	}

	if ( ! empty( $enqueue_fonts ) ) {		
		$remote_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_unique( array_values( $enqueue_fonts ) ) ) . '&display=swap';
		$css .= twentig_get_cached_remote_font_styles( $remote_url );
	}
	wp_add_inline_style( 'wp-block-library', $css );

	if ( ! $latest_version ) {
		wp_add_inline_style( 'wp-block-library', '.editor-styles-wrapper {' . $css_vars . '}' . $css );
	}

	wp_add_inline_style( 
		'wp-block-library',
		'.block-editor-block-preview__content-iframe .is-root-container > .wp-block-group {
			padding-block: 80px;
		}
		.block-editor-block-preview__content-iframe .is-root-container .wp-block-columns,
		.block-editor-block-preview__content-iframe .is-root-container .wp-block-columns + *,
		.block-editor-block-preview__content-iframe .is-root-container .alignwide:where(figure,.wp-block-cover,.wp-block-group,.wp-block-media-text,.wp-block-embed),
		.block-editor-block-preview__content-iframe .is-root-container .alignwide:where(figure,.wp-block-cover,.wp-block-group,.wp-block-media-text,.wp-block-embed) + *,
		.block-editor-block-preview__content-iframe .is-root-container > :where(h2,h3,h4),
		.block-editor-block-preview__content-iframe .is-root-container .wp-block-group.alignfull > :where(h2,h3,h4) {
			margin-top: var(--wp--custom--spacing--tw-margin-medium);
		}		
		'	
	);

	if ( $latest_version ) {

		/* Fix columns core spacing */
		$cols_horizontal_gap = twentig_theme_supports_spacing() ? '32px' : 'var(--wp--style--block-gap)';
		$cols_spacing        = wp_get_global_styles(
			array( 'spacing', 'blockGap' ),
			array( 'block_name' => 'core/columns' )
		);

		if ( $cols_spacing ) {
			if ( is_array( $cols_spacing ) && isset( $cols_spacing['left'] ) ) {
				$cols_horizontal_gap = $cols_spacing['left'];
			} elseif ( is_string( $cols_spacing ) ) {
				$cols_horizontal_gap = $cols_spacing;
			}
		}

		$columns_css = "body .editor-styles-wrapper .wp-block-columns.tw-cols-h-gap{column-gap:{$cols_horizontal_gap};}";
		wp_add_inline_style( 'wp-block-library', $columns_css );
	}
	
	wp_add_inline_style( 'wp-block-library', twentig_generate_navigation_styles() );
}
add_action( 'admin_init', 'twentig_block_theme_editor_styles' );

/**
 * Returns CSS for navigation buttons.
 */
function twentig_generate_navigation_styles( $global_styles = null ) {

	if ( is_null( $global_styles ) ) {
		$global_styles = wp_get_global_styles();
	}

	/* Button element */
	$element_styles = twentig_array_get( $global_styles, array( 'elements', 'button' ), [] );
	$element_colors = twentig_array_get( $element_styles, array( 'color' ), [] );
	$element_radius = twentig_array_get( $element_styles, array( 'border', 'radius' ), [] );

	/* Button block */
	$block_styles   = twentig_array_get( $global_styles, array( 'blocks', 'core/button' ), [] );
	$block_colors   = twentig_array_get( $block_styles, array( 'color' ), [] );
	$block_radius   = twentig_array_get( $block_styles, array( 'border', 'radius' ), [] );

	/* Colors */
	$button_colors    = array_merge( $element_colors, $block_colors );	
	$color_properties = array(
		'background'       => array( 'gradient' ),
		'background-color' => array( 'background' ),
		'color'            => array( 'text' ),
	);

	$css_colors = '';
	foreach ( $color_properties as $css_property => $value_path ) {
		$value = twentig_array_get( $button_colors, $value_path, '' );
		if ( '' !== $value && ! is_array( $value ) ) {
			$prefix     = 'var:';
			$prefix_len = strlen( $prefix );
			if ( 0 === strncmp( $value, $prefix, $prefix_len ) ) {
				$unwrapped_name = str_replace(
					'|',
					'--',
					substr( $value, $prefix_len )
				);
				$value          = "var(--wp--$unwrapped_name)";
			}
			$css_colors .= $css_property . ':' . $value . ' !important;';
		}
	}

	/* Border radius */
	$button_radius = $block_radius ? $block_radius : $element_radius;
	$radius_value  = 0;
	if ( is_string( $button_radius ) ) {
		$radius_value = $button_radius;
	}  elseif ( is_array( $button_radius ) && isset( $button_radius['topLeft'] ) ) {
		$radius_value = $button_radius['topLeft'];
	}

	/* CSS */
	$button_css = '
		.wp-block-navigation .wp-block-navigation-link:is(.is-style-tw-button-outline,.is-style-tw-button-fill) a {
			padding: 0.625rem max(1rem,0.75em) !important;
			text-decoration: none !important;
			opacity: 1;
			border: 2px solid currentColor;			
			border-radius: ' . esc_attr( $radius_value ) . ';
		}
		.wp-block-navigation-link.is-style-tw-button-outline a {
			color: currentColor !important;
		}
		.wp-block-navigation .wp-block-navigation-link.is-style-tw-button-fill a {
			border-color: transparent;' .
			$css_colors . 
		'}';

	return twentig_minify_css( $button_css );
}

/**
 * Hooks into the data provided by the theme to add new font options.
 */
function twentig_filter_theme_json_theme( $theme_json ) {
	
	$theme_data  = $theme_json->get_data();
	$theme_fonts = [];
		
	if ( 
		isset( $theme_data['settings'] ) &&
		isset( $theme_data['settings']['typography'] ) &&
		isset( $theme_data['settings']['typography']['fontFamilies'] ) &&
		isset( $theme_data['settings']['typography']['fontFamilies']['theme'] )
	) {
		$theme_fonts = $theme_data['settings']['typography']['fontFamilies']['theme'];
	}

	$new_data = array(
		'version'  => 2,
		'settings' => array(
			'typography' => array(
				'fontFamilies' => twentig_merge_fonts_to_theme_fonts( $theme_fonts )
			)
		),
	);

	return $theme_json->update_with( $new_data );
}
add_filter( 'wp_theme_json_data_theme', 'twentig_filter_theme_json_theme' );

/**
 * Registers additional global editor settings.
 */
function twentig_register_site_editor_settings() {
	
	register_setting(
		'twentig_typography',
		'twentig_typography',
		array(
			'type'         => 'object',
			'show_in_rest' => array(
				'schema' => array(
					'type' => 'object',
					'properties' => array(
						'font1'        => array(
							'type' => 'string',
						),
						'font1_styles' => array(
							'type'  => 'array',
							'items' => array(
								'type' => 'string',
							)
						),
						'font2'        => array(
							'type' => 'string',
						),
						'font2_styles' => array(
							'type'  => 'array',
							'items' => array(
								'type' => 'string',
							)
						),
						'local'        => array(
							'type'    => 'boolean',
							'default' => true
						),
					)
				)
			),
			'default' => array( 'local' => true )
		)
	);

	register_setting(
		'twentig_global_spacing',
		'twentig_global_spacing',
		array(
			'type'              => 'boolean',
			'show_in_rest'      => true,
			'default'           => twentig_default_global_spacing(),
			'sanitize_callback' => 'rest_sanitize_boolean',
		)
	);
}
add_action( 'init', 'twentig_register_site_editor_settings' );

/**
 * Adds support for Twentig spacing for all block themes.
 */
function twentig_block_theme_support() {
	add_theme_support( 'tw-spacing' );
}
add_action( 'after_setup_theme', 'twentig_block_theme_support' );

/**
 * Get default value for the Twentig global spacing setting.
 */
function twentig_default_global_spacing() {
	$theme = get_template();
	if ( 'twentytwentytwo' === $theme || 'twentytwentythree' === $theme ) {
		return true;
	}
	return false;
}

/**
 * Migrates Twentig layout settings to core settings.
 */
function twentig_migrate_global_layout_styles() {

	if ( ! is_wp_version_compatible( '6.1' ) ) {
		return;
	}

	$content_width = get_option( 'twentig_content_size' );
	$wide_width    = get_option( 'twentig_wide_size' );

	if ( $content_width || $wide_width ) {
		$user_data = WP_Theme_JSON_Resolver::get_user_data()->get_raw_data();

		$user_content_width = twentig_array_get( $user_data, array( 'settings', 'layout', 'contentSize' ), null );
		$user_wide_width    = twentig_array_get( $user_data, array( 'settings', 'layout', 'wideSize' ), null );

		$new_settings = array();
		if ( array_key_exists( 'settings', $user_data ) ) {
			$new_settings = $user_data['settings'];
		}

		$update_settings = false;

		if ( $content_width && ! $user_content_width ) {
			if ( empty( $new_settings['layout'] ) ) {
				$new_settings['layout'] = array();
			}		
			$new_settings['layout']['contentSize'] = $content_width;
			$update_settings = true;
		}

		if ( $wide_width && ! $user_wide_width ) {
			if ( empty( $new_settings['layout'] ) ) {
				$new_settings['layout'] = array();
			}		
			$new_settings['layout']['wideSize'] = $wide_width;
			$update_settings = true;
		}

		if ( $update_settings ) {
			$user_cpt_id              = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
			$global_styles_controller = new WP_REST_Global_Styles_Controller();
			
			$update_request = new WP_REST_Request( 'PUT', '/wp/v2/global-styles/' );
			$update_request->set_param( 'id', $user_cpt_id );
			$update_request->set_param( 'settings', $new_settings );
			$global_styles_controller->update_item( $update_request );
			
			delete_transient( 'global_styles' );
			delete_transient( 'global_styles_' . get_stylesheet() );
		}
	}
	
	delete_option( 'twentig_content_size' );
	delete_option( 'twentig_wide_size' );
}
add_action( 'init', 'twentig_migrate_global_layout_styles', 99 );

/**
 * Remove line breaks and superfluous whitespace.
 *
 * @param string $css String containing CSS.
 */
function twentig_minify_css( $css ) {
	if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {

		// Remove breaks.
		$css = preg_replace( '/[\r\n\t ]+/', ' ', $css );

		// Remove whitespace around specific characters.
		$css = preg_replace( '/\s+([{};,!>\)])/', '$1', $css );
		$css = preg_replace( '/([{};,:>\(])\s+/', '$1', $css );

		// Remove semicolon followed by closing bracket.
		$css = str_replace( ';}', '}', $css );
	}
	return $css;
}
