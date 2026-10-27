<?php

// add_filter( 'register_block_type_args', 'sainsbury_remove_default_blocks', 10, 2 );
function sainsbury_remove_default_blocks( array $args, string $block_type ) {

	if (is_admin()) {
		return [];
	}

	return $args;
}


add_filter( 'block_categories_all', 'sainsbury_block_category', 10, 2);
function sainsbury_block_category( $categories, $post ) {
	
	$categories[] = [ 'slug' => 'sainsbury', 'title' => 'Sainsbury' ];
	return $categories;

}


// Gutenberg ACF blocks
add_action('acf/init', 'sainsbury_acf_init_block_types');

function sainsbury_acf_init_block_types() {

	if( !function_exists('acf_register_block_type') ) {
		return;
	}

	$theme_color = '#05203D';

	acf_register_block_type(
		array(
			'name'              => 'hero-banner',
			'title'             => __('Hero Banner'),
			'description'       => __('Hero Banner ACF Block with Heading, Copy, CTA and Image'),
			'render_template'   => 'partials/acf-blocks/hero-banner.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'embed-generic',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Hero', 'Banner' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'two-column-content-banner',
			'title'             => __('Two Column Content Banner'),
			'description'       => __('A two column content banner with eyebrow text, heading and body copy'),
			'render_template'   => 'partials/acf-blocks/two-column-content-banner.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'embed-generic',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Two', 'Column', 'Content' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'two-column-media-and-text',
			'title'             => __('Two Column Media and Text'),
			'description'       => __('A two column block with heading, body copy and CTA beside an image'),
			'render_template'   => 'partials/acf-blocks/two-column-media-and-text.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'align-pull-left',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Two', 'Column', 'Media', 'Text', 'Image' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'two-column-media-and-text-slider',
			'title'             => __('Two Column Media and Text Slider'),
			'description'       => __('A two column slider with eyebrow heading, heading and body copy beside an image'),
			'render_template'   => 'partials/acf-blocks/two-column-media-and-text-slider.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'slides',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Two', 'Column', 'Media', 'Text', 'Slider', 'Image' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'two-column-boxed-content',
			'title'             => __('Two Column Boxed Content'),
			'description'       => __('A boxed two column block with heading, body copy and CTA in each column'),
			'render_template'   => 'partials/acf-blocks/two-column-boxed-content.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'columns',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Two', 'Column', 'Boxed', 'Content' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'image-banner',
			'title'             => __('Image Banner'),
			'description'       => __('A full viewport image banner'),
			'render_template'   => 'partials/acf-blocks/image-banner.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'format-image',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Image', 'Banner' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'icon-grid',
			'title'             => __('Icon Grid'),
			'description'       => __('A heading with a grid of icons and text'),
			'render_template'   => 'partials/acf-blocks/icon-grid.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'grid-view',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Icon', 'Grid' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);

	acf_register_block_type(
		array(
			'name'              => 'card-grid',
			'title'             => __('Card Grid'),
			'description'       => __('A heading with a grid of cards'),
			'render_template'   => 'partials/acf-blocks/card-grid.php',
			'category'          => 'sainsbury',
			'icon'              => [
				'src' 						=> 'grid-view',
				'background' 			=> $theme_color,
				'foreground' 			=> '#fff',
			],
			'keywords'          => array( 'Card', 'Grid' ),
			'align'	 						=> 'full',
			'enqueue_assets'    => function() {}
		)
	);
}
