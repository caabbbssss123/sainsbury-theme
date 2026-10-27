<?php // Category Data

global $taxonomy, $background_colour, $post_type, $parent_page, $tile_colour;


$blog_page				= get_field('blog_page', 'option');

switch($taxonomy->taxonomy) {
	case 'category':
		$post_type		= 'post';
		$parent_page	= $blog_page;
		break;
	default:
		$category		= '';
}

$background_colour		= get_field('background_colour', $parent_page);

switch($background_colour) {
	case 'white':
		$tile_colour	= 'grey';
		break;
	default:
		$tile_colour	= 'white';
}