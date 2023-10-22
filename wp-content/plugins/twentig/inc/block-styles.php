<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 */
function twentig_register_block_styles() {
	
	/* Media & Text */
	register_block_style(
		'core/media-text',
		array(
			'name'  => 'tw-shadow',
			'label' => esc_html__( 'Shadow', 'twentig' ),
		)
	);

	register_block_style(
		'core/media-text',
		array(
			'name'  => 'tw-overlap',
			'label' => esc_html_x( 'Overlap', 'noun', 'twentig' ),
		)
	);

	register_block_style(
		'core/media-text',
		array(
			'name'  => 'tw-hard-shadow',
			'label' => esc_html__( 'Hard shadow', 'twentig' ),
		)
	);
	
	/* Cover */

	register_block_style(
		'core/cover',
		array(
			'name'  => 'rounded',
			'label' => esc_html__( 'Rounded', 'twentig' ),
		)
	);

	register_block_style(
		'core/cover',
		array(
			'name'  => 'tw-rounded-corners',
			'label' => esc_html__( 'Rounded corners', 'twentig' ),
		)
	);

	register_block_style(
		'core/cover',
		array(
			'name'  => 'tw-border-inner',
			'label' => esc_html__( 'Inner border', 'twentig' ),
		)
	);
	
	register_block_style(
		'core/cover',
		array(
			'name'  => 'tw-shadow',
			'label' => esc_html__( 'Shadow', 'twentig' ),
		)
	);
	
	register_block_style(
		'core/cover',
		array(
			'name'  => 'tw-hard-shadow',
			'label' => esc_html__( 'Hard shadow', 'twentig' ),
		)
	);

	/* Image */
	register_block_style(
		'core/image',
		array(
			'name'  => 'tw-rounded-corners',
			'label' => esc_html__( 'Rounded corners', 'twentig' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'tw-shadow',
			'label' => esc_html__( 'Shadow', 'twentig' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'tw-hard-shadow',
			'label' => esc_html__( 'Hard shadow', 'twentig' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'tw-frame',
			'label' => esc_html__( 'White Frame', 'twentig' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'tw-border',
			'label' => esc_html__( 'Subtle Border', 'twentig' ),
		)
	);

	/* Post Featured Image */

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'rounded',
			'label' => esc_html__( 'Rounded', 'twentig' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'tw-rounded-corners',
			'label' => esc_html__( 'Rounded corners', 'twentig' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'tw-shadow',
			'label' => esc_html__( 'Shadow', 'twentig' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'tw-hard-shadow',
			'label' => esc_html__( 'Hard shadow', 'twentig' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'tw-frame',
			'label' => esc_html__( 'White frame', 'twentig' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'tw-border',
			'label' => esc_html__( 'Subtle Border', 'twentig' ),
		)
	);

	/* Gallery */
	
	register_block_style(
		'core/gallery',
		array(
			'name'  => 'tw-img-rounded',
			'label' => esc_html__( 'Rounded corners', 'twentig' ),
		)
	);

	register_block_style(
		'core/gallery',
		array(
			'name'  => 'tw-img-frame',
			'label' => esc_html__( 'White frame', 'twentig' ),
		)
	);

	/* List */
	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-dash',
			'label' => esc_html__( 'Dash', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-checkmark',
			'label' => esc_html__( 'Checkmark', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-arrow',
			'label' => esc_html__( 'Arrow', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-border',
			'label' => esc_html__( 'Border', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-border-inner',
			'label' => esc_html__( 'Inner border', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-table',
			'label' => esc_html__( 'Table', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-no-bullet',
			'label' => esc_html_x( 'No bullet', 'list style', 'twentig' ),
		)
	);

	register_block_style(
		'core/list',
		array(
			'name'  => 'tw-inline',
			'label' => esc_html_x( 'Inline', 'list style', 'twentig' ),
		)
	);

	/* Table */
	register_block_style(
		'core/table',
		array(
			'name'  => 'tw-border-h',
			'label' => esc_html__( 'Horizontal border', 'twentig' ),
		)
	);

	register_block_style(
		'core/table',
		array(
			'name'  => 'tw-border-h-inner',
			'label' => esc_html__( 'Horizontal inner border', 'twentig' ),
		)
	);

	/* Latest Posts */
	register_block_style(
		'core/latest-posts',
		array(
			'name'  => 'tw-posts-card',
			'label' => esc_html__( 'Card', 'twentig' ),
		)
	);

	register_block_style(
		'core/latest-posts',
		array(
			'name'  => 'tw-posts-border',
			'label' => esc_html__( 'Border', 'twentig' ),
		)
	);

	/* Quote */
	register_block_style(
		'core/quote',
		array(
			'name'  => 'tw-icon',
			'label' => esc_html__( 'Icon', 'twentig' ),
		)
	);

	/* Pullquote */
	register_block_style(
		'core/pullquote',
		array(
			'name'  => 'plain',
			'label' => esc_html_x( 'Plain', 'block style', 'twentig' ),
		)
	);

	register_block_style(
		'core/pullquote',
		array(
			'name'  => 'tw-icon',
			'label' => esc_html_x( 'Icon', 'block style', 'twentig' ),
		)
	);
	
	/* Block Theme */
	if ( wp_is_block_theme() ) {
		unregister_block_style( 'core/gallery', 'tw-img-frame' );

		/* Post Navigation Link */
		register_block_style(
			'core/post-navigation-link',
			array(
				'name'  => 'tw-nav-stack',
				'label' => __( 'Stack', 'twentig' ),
			)
		);

		register_block_style(
			'core/post-navigation-link',
			array(
				'name'  => 'tw-nav-arrow',
				'label' => __( 'Arrow', 'twentig' ),
			)
		);

		/* Post Terms */

		register_block_style(
			'core/tag-cloud',
			array(
				'name'  => 'tw-outline-pill',
				'label' => __( 'Pill', 'twentig' ),				
			)
		);
	
		/* Post Terms */

		register_block_style(
			'core/post-terms',
			array(
				'name'  => 'tw-outline',
				'label' => __( 'Outline', 'twentig' ),
			)
		);

		register_block_style(
			'core/post-terms',
			array(
				'name'  => 'tw-outline-pill',
				'label' => __( 'Pill', 'twentig' ),
			)
		);

		register_block_style(
			'core/post-terms',
			array(
				'name'  => 'tw-hashtag',
				'label' => __( 'Hashtag', 'twentig' ),
			)
		);
		
		register_block_style(
			'core/post-terms',
			array(
				'name'  => 'tw-plain',
				'label' => __( 'Plain', 'twentig' ),
			)
		);
		
		/* Navigation Link */
		register_block_style(
			'core/navigation-link',
			array(
				'name'  => 'tw-button-fill',
				'label' => __( 'Fill button', 'twentig' ),
			)
		);

		register_block_style(
			'core/navigation-link',
			array(
				'name'  => 'tw-button-outline',
				'label' => __( 'Outline button', 'twentig' ),
			)
		);

		/* Pagination */
		register_block_style(
			'core/query-pagination-numbers',
			array(
				'name'  => 'tw-circle',
				'label' => __( 'Circle', 'twentig' ),
			)
		);

		register_block_style(
			'core/query-pagination-numbers',
			array(
				'name'  => 'tw-square',
				'label' => __( 'Square', 'twentig' ),
			)
		);

		register_block_style(
			'core/query-pagination-numbers',
			array(
				'name'  => 'tw-plain',
				'label' => __( 'Plain', 'twentig' ),
			)
		);

		register_block_style(
			'core/query-pagination-previous',
			array(
				'name'  => 'tw-btn-pill',
				'label' => __( 'Pill', 'twentig' ),
			)
		);

		register_block_style(
			'core/query-pagination-previous',
			array(
				'name'  => 'tw-btn-square',
				'label' => __( 'Square', 'twentig' ),
			)
		);

		register_block_style(
			'core/query-pagination-next',
			array(
				'name'  => 'tw-btn-pill',
				'label' => __( 'Pill', 'twentig' ),
			)
		);

		register_block_style(
			'core/query-pagination-next',
			array(
				'name'  => 'tw-btn-square',
				'label' => __( 'Square', 'twentig' ),
			)
		);

		/* Search */

		register_block_style(
			'core/search',
			array(
				'name'  => 'tw-underline',
				'label' => __( 'Underline', 'twentig' ),
			)
		);

		/* Separator */

		register_block_style(
			'core/separator',
			array(
				'name'  => 'tw-asterisks',
				'label' => __( 'Asterisks', 'twentig' ),
			)
		);

		register_block_style(
			'core/separator',
			array(
				'name'  => 'tw-dotted',
				'label' => __( 'Dotted', 'twentig' ),		
			)
		);

		register_block_style(
			'core/separator',
			array(
				'name'  => 'tw-dashed',
				'label' => __( 'Dashed', 'twentig' ),		
			)
		);

		/* Column */
		
		register_block_style(
			'core/column',
			array(
				'name'  => 'tw-col-shadow',
				'label' => __( 'Shadow', 'twentig' ),
			)
		);

		register_block_style(
			'core/column',
			array(
				'name'  => 'tw-col-hard-shadow',
				'label' => __( 'Hard shadow', 'twentig' ),
			)
		);

		register_block_style(
			'core/column',
			array(
				'name'  => 'tw-col-border-top',
				'label' => __( 'Top border', 'twentig' ),
			)
		);
		
	}
}
add_action( 'init', 'twentig_register_block_styles' );
