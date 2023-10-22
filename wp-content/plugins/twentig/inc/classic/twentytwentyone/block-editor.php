<?php
/**
 * Block editor
 *
 * @package twentig
 */

/**
 * Enqueue custom CSS generated by the Customizer settings inside the block editor.
 */
function twentig_twentyone_editor_styles() {
	
	add_editor_style( twentig_twentyone_fonts_url() );
	add_editor_style( TWENTIG_ASSETS_URI . '/css/twentytwentyone/editor.css' );

	$css                     = '';
	$site_width              = get_theme_mod( 'twentig_site_width' );
	$wide_width              = get_theme_mod( 'twentig_wide_width' );
	$default_width           = get_theme_mod( 'twentig_default_width' );
	$body_font               = get_theme_mod( 'twentig_body_font' );
	$body_font_size          = get_theme_mod( 'twentig_body_font_size', 20 );
	$body_line_height        = get_theme_mod( 'twentig_body_line_height', 1.7 );
	$heading_font            = get_theme_mod( 'twentig_heading_font' );
	$heading_font_weight     = get_theme_mod( 'twentig_heading_font_weight', '400' );
	$heading_letter_spacing  = get_theme_mod( 'twentig_heading_letter_spacing', 0 );
	$tertiary_font           = get_theme_mod( 'twentig_secondary_elements_font', 'body' );
	$h1_font_size            = get_theme_mod( 'twentig_h1_font_size', 96 );
	$post_h1_font_size       = get_theme_mod( 'twentig_post_h1_font_size' );
	$button_shape            = get_theme_mod( 'twentig_button_shape', 'square' );
	$button_size             = get_theme_mod( 'twentig_button_size' );
	$button_text_transform   = get_theme_mod( 'twentig_button_text_transform' );
	$button_text_color       = get_theme_mod( 'twentig_button_text_color' );
	$button_background       = get_theme_mod( 'twentig_button_background_color' );
	$button_hover_background = get_theme_mod( 'twentig_button_hover_background_color' );
	$border_thickness        = get_theme_mod( 'twentig_border_thickness' );
	$page_title_width        = get_theme_mod( 'twentig_page_title_width', 'wide' );
	$page_title_center       = get_theme_mod( 'twentig_page_title_text_align', false );
	$page_title_border       = get_theme_mod( 'twentig_page_title_border', true );
	$post_title_width        = get_theme_mod( 'twentig_post_title_width', 'wide' );
	$post_title_center       = get_theme_mod( 'twentig_post_title_text_align', false );
	$post_title_border       = get_theme_mod( 'twentig_post_title_border', true );

	$css_var = ':root .editor-styles-wrapper{';

	$background_color = get_theme_mod( 'background_color', 'D1E4DD' );
	if ( 'd1e4dd' !== strtolower( $background_color ) ) {
		$readable_color = 127 < Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $background_color ) ? '#000' : '#fff';
		$css_var .= '--global--color-background: #' . $background_color . ';';
		$css_var .= '--global--color-primary: ' . $readable_color . ';';
		$css_var .= '--global--color-secondary: ' . $readable_color . ';';
		$css_var .= '--button--color-background: ' . $readable_color . ';';
		$css_var .= '--button--color-text-hover: ' . $readable_color . ';';
	}

	if ( $site_width ) {
		$page_background = get_theme_mod( 'twentig_inner_background_color' );

		if ( $page_background ) {
			$body_background = get_theme_mod( 'background_color', 'D1E4DD' );
			$page_luminance  = Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $page_background );
			$body_luminance  = Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $body_background );

			$css_var .= '--global--color-background: ' . $page_background . ';';

			if ( 127 < $page_luminance && 127 >= $body_luminance ) {
				$css_var .= '
					--global--color-primary: #000;
					--global--color-secondary: #000;
					--button--color-background: #000;
					--button--color-text-hover: #000;
				';
			} elseif ( 127 >= $page_luminance && 127 < $body_luminance ) {
				$css_var .= '
					--global--color-primary: #fff;
					--global--color-secondary: #fff;
					--button--color-background: #fff;
					--button--color-text-hover: #fff;
				';
			}
		}
	}

	if ( $wide_width ) {
		$css_var .= '--max--alignwide-width:' . twentig_twentyone_generate_value( $wide_width );
	}

	if ( $default_width ) {
		$css_var .= '--max--aligndefault-width:' . twentig_twentyone_generate_value( $default_width );
	}

	if ( $body_font ) {
		$css_var .= '--font-base:' . $body_font . ';';
	}

	if ( $body_font_size ) {
		$css_var .= '--global--font-size-base:' . twentig_twentyone_generate_value( $body_font_size, 'rem' );
	}

	if ( $body_line_height && 1.7 !== $body_line_height ) {
		$css_var .= '--global--line-height-body:' . $body_line_height . ';';
	}

	if ( $heading_font ) {
		$css_var .= '--font-headings:' . $heading_font . ';';
		if ( $heading_font_weight ) {
			$css_var .= '--heading--font-weight:' . $heading_font_weight . ';';
			$css_var .= '--heading--font-weight-page-title:' . $heading_font_weight . ';';
			$css_var .= '--heading--font-weight-strong:' . $heading_font_weight . ';';
		}
	} elseif ( '400' !== $heading_font_weight ) {
		$css_var .= '--heading--font-weight:' . $heading_font_weight . ';';
		$css_var .= '--heading--font-weight-page-title:' . $heading_font_weight . ';';
		$css_var .= '--heading--font-weight-strong:' . $heading_font_weight . ';';
	}

	if ( ! empty( $heading_letter_spacing ) ) {
		$value    = twentig_twentyone_generate_value( $heading_letter_spacing, 'em' );
		$css_var .= '--global--letter-spacing:' . $value;
		$css_var .= '--heading--letter-spacing-h5:' . $value;
		$css_var .= '--heading--letter-spacing-h6:' . $value;
	}

	if ( $h1_font_size && 96 !== $h1_font_size ) {
		$css_var .= '--global--font-size-xxl:' . twentig_twentyone_generate_value( $h1_font_size, 'rem' );
	}

	if ( 'heading' === $tertiary_font ) {
		$css_var .= '--global--font-tertiary: var(--font-headings);';
	}

	if ( 'rounded' === $button_shape ) {
		$css_var .= '--button--border-radius: 6px;';
	} elseif ( 'pill' === $button_shape ) {
		$css_var .= '--button--border-radius: 50px;';
	}

	if ( 'small' === $button_size ) {
		$css_var .= '
		--button--padding-vertical: 8px;
		--button--padding-horizontal: 16px;
		--button--font-size: var(--global--font-size-sm);
		';
	} elseif ( 'medium' === $button_size ) {
		$css_var .= '
		--button--padding-vertical: 12px;
		--button--padding-horizontal: 24px;
		--button--font-size: var(--global--font-size-sm);
		';
	}

	if ( 'uppercase' === $button_text_transform ) {
		$css_var .= '--button--font-size: var(--global--font-size-xs);';
	}

	if ( 'thin' === $border_thickness ) {
		$css_var .= '
			--button--border-width: 1px;
			--form--border-width: 1px;';
	}

	$css_var .= twentig_twentyone_generate_color_variables();
	$css_var .= '}';

	$css .= $css_var;

	if ( twentig_twentyone_is_light_theme() ) {
		$css .= '.editor-styles-wrapper :not(.has-text-color).has-white-background-color.has-white-background-color[class] { color: var(--global--color-primary); }';
	}

	if ( $button_background ) {
		$css .= '
		.editor-styles-wrapper .wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background),
		.editor-styles-wrapper .wp-block-file .wp-block-file__button.wp-block-file__button { 
			background-color:' . $button_background . ' !important;
			border-color:' . $button_background . ';';
		if ( $button_text_color ) {
			$css .= 'color:' . $button_text_color . ' !important;';
		}
		$css .= '}';

		$css .= '.editor-styles-wrapper .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color) { 
			border-color:' . $button_background . ' !important;
			color:' . $button_background . ' !important;
		}';

		if ( $button_hover_background ) {
			$css .= '
			.editor-styles-wrapper .wp-block-buttons .wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):hover,
			.editor-styles-wrapper .wp-block-buttons .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover,
			.editor-styles-wrapper .wp-block-file .wp-block-file__button.wp-block-file__button:hover { 
				background-color:' . $button_hover_background . ' !important;
				border-color:' . $button_hover_background . ' !important;';
			if ( $button_text_color ) {
				$css .= 'color:' . $button_text_color . ' !important;';
			}
			$css .= '}';
		} else {
			$css .= '
			.editor-styles-wrapper .wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):hover,
			.editor-styles-wrapper .wp-block-file .wp-block-file__button.wp-block-file__button:hover {
				background-color: transparent !important;
				border-color:' . $button_background . ' !important;
				color:' . $button_background . ' !important;';
			$css .= '}';

			$css .= '
			.editor-styles-wrapper .wp-block-buttons .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover {
				border-color: transparent;
				background-color:' . $button_background . ' !important;';
			if ( $button_text_color ) {
				$css .= 'color:' . $button_text_color . ' !important;';
			}
			$css .= '}';
		}
	}

	if ( 'uppercase' === $button_text_transform ) {
		$css .= '.editor-styles-wrapper .wp-block-button__link,
		.editor-styles-wrapper .wp-block-file__button,
		.editor-styles-wrapper .wp-block-search__button {
			text-transform: uppercase;
			letter-spacing: 0.05em;
		}';
	}

	if ( 'thin' === $border_thickness ) {
		$css .= '
			.editor-styles-wrapper .wp-block.editor-post-title__block.editor-post-title__block,
			.editor-styles-wrapper .wp-block.wp-block-image.is-style-twentytwentyone-border img, 
			.editor-styles-wrapper .wp-block.wp-block-image.is-style-twentytwentyone-image-frame img, 
			.editor-styles-wrapper .wp-block.wp-block-latest-posts.is-style-twentytwentyone-latest-posts-dividers,
			.editor-styles-wrapper .wp-block.wp-block-latest-posts.is-style-twentytwentyone-latest-posts-borders li,
			.editor-styles-wrapper .wp-block.wp-block-media-text.is-style-twentytwentyone-border,
			.editor-styles-wrapper .wp-block.wp-block-group.is-style-twentytwentyone-border { border-width: 1px;}';
	}

	if ( 'text-width' === $page_title_width ) {
		$css .= 'body:not(.post-type-post) .editor-styles-wrapper .editor-post-title__block { max-width: var(--responsive--aligndefault-width); }';
	}

	if ( $page_title_center ) {
		$css .= 'body:not(.post-type-post) .editor-styles-wrapper .editor-post-title__block .editor-post-title__input { text-align:center; }';
	}

	if ( ! $page_title_border ) {
		$css .= 'body:not(.post-type-post) .editor-styles-wrapper .editor-post-title__block { border-bottom: 0; padding-bottom: 0; margin-bottom: 60px; }';
	}

	if ( 'text-width' === $post_title_width ) {
		$css .= 'body.post-type-post .editor-styles-wrapper .editor-post-title__block { max-width: var(--responsive--aligndefault-width); }';
	}

	if ( $post_title_center ) {
		$css .= 'body.post-type-post .editor-styles-wrapper .editor-post-title__block .editor-post-title__input { text-align:center; }';
	}

	if ( ! $post_title_border ) {
		$css .= 'body.post-type-post .editor-styles-wrapper .wp-block.editor-post-title__block { border-bottom: 0; padding-bottom: 0; margin-bottom: 60px;}';
	}

	if ( $post_h1_font_size ) {
		$css .= 'body.post-type-post .editor-styles-wrapper .editor-post-title__block .editor-post-title__input { font-size:' . twentig_twentyone_generate_value( $post_h1_font_size, 'rem' ) . '}';
	}

	wp_add_inline_style( 'wp-block-library', $css );
}
add_action( 'admin_init', 'twentig_twentyone_editor_styles' );

/**
 * Set up theme defaults and register support for various features.
 */
function twentig_twentyone_theme_support() {

	$font_sizes     = current( (array) get_theme_support( 'editor-font-sizes' ) );
	$body_font_size = get_theme_mod( 'twentig_body_font_size', 20 );
	$body_font_size = $body_font_size ? $body_font_size : 20;
	$h1_font_size   = get_theme_mod( 'twentig_h1_font_size', 96 );
	$h1_font_size   = $h1_font_size ? $h1_font_size : 96;
	$size_xs        = 20 === $body_font_size ? 16 : max( 0.8 * intval( $body_font_size ), 14 );
	$size_sm        = 20 === $body_font_size ? 18 : 0.9 * intval( $body_font_size );

	if ( is_array( $font_sizes ) ) {
		foreach ( $font_sizes as $index => $settings ) {
			if ( 'extra-small' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_xs;
				$font_sizes[ $index ]['name'] = $font_sizes[ $index ]['name'] . ' (H6)';
			} elseif ( 'small' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $size_sm;
				$font_sizes[ $index ]['name'] = $font_sizes[ $index ]['name'] . ' (H5)';
			} elseif ( 'normal' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $body_font_size;
			} elseif ( 'large' === $settings['slug'] ) {
				$font_sizes[ $index ]['name'] = $font_sizes[ $index ]['name'] . ' (H4)';
			} elseif ( 'huge' === $settings['slug'] ) {
				$font_sizes[ $index ]['size'] = $h1_font_size;
				$font_sizes[ $index ]['name'] = $font_sizes[ $index ]['name'] . ' (H1)';
			}
		}

		$medium = array(
			'name' => esc_html_x( 'Medium', 'font size name', 'twentig' ),
			'size' => min( 1.125 * intval( $body_font_size ), 23 ),
			'slug' => 'medium',
		);

		$h3 = array(
			'name' => 'H3',
			'size' => 32,
			'slug' => 'h3',
		);

		$h2 = array(
			'name' => 'H2',
			'size' => 48,
			'slug' => 'h2',
		);
	
		array_splice( $font_sizes, 3, 0, array( $medium ) );
		array_splice( $font_sizes, 5, 0, array( $h3 ) );
		array_splice( $font_sizes, 7, 0, array( $h2 ) );
		add_theme_support( 'editor-font-sizes', $font_sizes );
	}

	// Add subtle background color.
	$color_palette     = current( (array) get_theme_support( 'editor-color-palette' ) );
	$subtle_background = get_theme_mod( 'twentig_subtle_background_color', '#c5ddd4' );

	$color_palette[] = array(
		'name'  => esc_html__( 'Subtle Background', 'twentig' ),
		'slug'  => 'subtle',
		'color' => $subtle_background,
	);

	add_theme_support( 'editor-color-palette', $color_palette );

	// Remove opinionated block styles that are overriden by the theme.
	remove_theme_support( 'wp-block-styles' );

	$site_width      = get_theme_mod( 'twentig_site_width' );
	$page_background = get_theme_mod( 'twentig_inner_background_color' );

	if ( $site_width && $page_background ) {
		if ( 127 > Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $page_background ) ) {
			add_theme_support( 'dark-editor-style' );
		} else {
			remove_theme_support( 'dark-editor-style' );
		}
	}
}
add_action( 'after_setup_theme', 'twentig_twentyone_theme_support', 12 );

/**
 * Set the content width.
 *
 * @param int $content_width Content width.
 */
function twentig_twentyone_set_content_width( $content_width ) {
	$text_width = get_theme_mod( 'twentig_default_width' );
	if ( $text_width ) {
		return $text_width;
	}
	return $content_width;
}
add_filter( 'twenty_twenty_one_content_width', 'twentig_twentyone_set_content_width' );

/**
 * Filters Twentig CSS library classes.
 *
 * @param array $classes Array holding additional classes.
 */
function twentig_twentyone_filter_block_classes( $classes ) {
	unset( $classes['core/media-text']['tw-content-narrow'] );
	unset( $classes['core/list']['has-larger-font-size'] );
	return $classes;
}
add_filter( 'twentig_block_classes', 'twentig_twentyone_filter_block_classes' );

/**
 * Registers block styles.
 */
function twentig_twentyone_register_block_styles() {
	register_block_style(
		'core/quote',
		array(
			'name'  => 'tw-medium',
			'label' => esc_html_x( 'Medium', 'block style', 'twentig' ),
		)
	);
	register_block_style(
		'core/quote',
		array(
			'name'  => 'tw-minimal',
			'label' => esc_html_x( 'Minimal', 'block style', 'twentig' ),
		)
	);

	register_block_style(
		'core/pullquote',
		array(
			'name'  => 'tw-minimal',
			'label' => esc_html_x( 'Minimal', 'block style', 'twentig' ),
		)
	);
	
	unregister_block_style( 'core/quote', 'tw-icon'	);
	unregister_block_style( 'core/pullquote', 'tw-icon' );

	register_block_style(
		'core/separator',
		array(
			'name'  => 'tw-short',
			'label' => esc_html_x( 'Short line', 'block style', 'twentig' ),
		)
	);

	if ( ! twentig_is_option_enabled( 'twentig_core_block_patterns' ) ) {
		unregister_block_pattern( 'twentytwentyone/large-text' );
		unregister_block_pattern( 'twentytwentyone/links-area' );
		unregister_block_pattern( 'twentytwentyone/media-text-article-title' );
		unregister_block_pattern( 'twentytwentyone/overlapping-images' );
		unregister_block_pattern( 'twentytwentyone/two-images-showcase' );
		unregister_block_pattern( 'twentytwentyone/overlapping-images-and-text' );
		unregister_block_pattern( 'twentytwentyone/portfolio-list' );
		unregister_block_pattern( 'twentytwentyone/contact-information' );
	}
}
add_action( 'init', 'twentig_twentyone_register_block_styles' );


/**
 * Filters the block editor settings.
 */
function twentig_twentyone_editor_settings( $settings ) {
	$settings['__experimentalFeatures']['border']['radius'] = true;
	$settings['__experimentalFeatures']['border']['color'] = true;
	$settings['__experimentalFeatures']['border']['style'] = true;
	$settings['__experimentalFeatures']['border']['width'] = true;
	return $settings;
}
add_filter( 'block_editor_settings_all', 'twentig_twentyone_editor_settings');
