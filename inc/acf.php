<?php

/* ==========================================================================
   ACF Functions
   ========================================================================== */

add_filter( 'acf/settings/enable_post_types', '__return_false' );
add_filter( 'acf/settings/enable_options_pages_ui', '__return_false' );

/*
 * Set up Option pages
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'		=> 'Site Options',
		'menu_title'		=> 'Site Options',
		'menu_slug' 		=> 'site-options',
		'capability'		=> 'edit_posts',
		'redirect'			=> false
	));
	
	// acf_add_options_sub_page(array(
	// 	'page_title' 		=> 'Contact Details',
	// 	'menu_title'		=> 'Contact Details',
	// 	'parent_slug'		=> 'site-options',
	// ));
}

/*
 * Register Google Maps API
 */
function my_acf_init() {
	acf_update_setting('google_api_key', GOOGLE_MAPS_API_KEY); // change this on launch
}
add_action('acf/init', 'my_acf_init');

/*
 * Add title to flexible content rows
 * Used to modify the $title HTML displayed at the top of each flexible content layout.
 * https://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/
 */
add_filter('acf/fields/flexible_content/layout_title', 'my_acf_fields_flexible_content_layout_title', 10, 4);
function my_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {

    // load text sub field
    if( $text = get_sub_field('row_title') ) {
		$title  = $title . ' - ';
        $title .= '<b>' . esc_html($text) . '</b>';
    }
    return $title;
}

/*
 * Background Colour field
 * Load defined theme colours in background_colour select field
 */
function acf_load_background_colours( $field ) {
	
	global $theme_colours;
	
	$theme_colour_choices = [];
	
	foreach ( $theme_colours as $theme_colour ) :
	
		if ($theme_colour['background_colour'] == true)
			$theme_colour_choices[$theme_colour['value']] = $theme_colour['label'];
	
	endforeach;
    
    $field['choices'] = $theme_colour_choices;

    return $field;
    
}
add_filter('acf/load_field/name=background_colour', 'acf_load_background_colours');

/*
 * Box Background Colour field
 * Load defined theme colours in box_background_colour select field
 */
function acf_load_box_background_colours( $field ) {
	
	global $theme_colours;
	
	$theme_colour_choices = [];
	
	foreach ( $theme_colours as $theme_colour ) :
	
		if ($theme_colour['box_background_colour'] == true)
			$theme_colour_choices[$theme_colour['value']] = $theme_colour['label'];
	
	endforeach;
    
    $field['choices'] = $theme_colour_choices;

    return $field;
    
}
add_filter('acf/load_field/name=box_background_colour', 'acf_load_box_background_colours');

/*
 * Title Size field
 * Load defined text sizes in title_size select field
 */
function acf_load_title_size( $field ) {
	
	global $theme_text_sizes;
	
	$text_sizes_choices = [];
	
	foreach ( $theme_text_sizes as $theme_text_size ) :
	
		if ($theme_text_size['title_size'] == true)
			$text_sizes_choices[$theme_text_size['value']] = $theme_text_size['label'];
	
		if ($theme_text_size['title_size_default'] == true)
			$field['default_value'] = $theme_text_size['value'];
	
	endforeach;
    
    $field['choices'] = $text_sizes_choices;

    return $field;
    
}
add_filter('acf/load_field/name=title_size', 'acf_load_title_size');

/*
 * Flexible Content Title Size field
 * Load defined text sizes in flexible_content_title_size select field
 */
function acf_load_flexible_content_title_size( $field ) {
	
	global $theme_text_sizes;
	
	$text_sizes_choices = [];
	
	foreach ( $theme_text_sizes as $theme_text_size ) :
	
		if ($theme_text_size['flexible_content_title_size'] == true)
			$text_sizes_choices[$theme_text_size['value']] = $theme_text_size['label'];
	
		if ($theme_text_size['flexible_content_title_size_default'] == true)
			$field['default_value'] = $theme_text_size['value'];
	
	endforeach;
    
    $field['choices'] = $text_sizes_choices;

    return $field;
    
}
add_filter('acf/load_field/name=flexible_content_title_size', 'acf_load_flexible_content_title_size');

/*
 * Row Padding field
 * Load defined options in row_padding select field
 */
function acf_load_row_padding_options( $field ) {
	
	global $theme_padding_options;
	
	$padding_choices = [];
	
	foreach ( $theme_padding_options as $theme_padding_option ) :
	
		$padding_choices[$theme_padding_option['value']] = $theme_padding_option['label'];
	
		if ($theme_padding_option['default'] == true)
			$field['default_value'] = $theme_padding_option['value'];
	
	endforeach;
    
    $field['choices'] = $padding_choices;

    return $field;
    
}
add_filter('acf/load_field/name=row_padding', 'acf_load_row_padding_options');

/*
 * Post Type field - posts-page.php template
 * Load defined post types in post_type select field
 */
function acf_load_post_types_template( $field ) {
	
	global $theme_post_types;
	
	$post_type_choices = [];
	
	foreach ( $theme_post_types as $theme_post_type ) :
	
		if ($theme_post_type['posts_page'] == true)
			$post_type_choices[$theme_post_type['value']] = $theme_post_type['label'];
	
	endforeach;
    
    $field['choices'] = $post_type_choices;

    return $field;
    
}
add_filter('acf/load_field/key=field_6147e9eaa17cf', 'acf_load_post_types_template');

/*
 * Post Type field - posts_row in page_rows field
 * Load defined post types in post_type select field
 */
function acf_load_post_types_row( $field ) {
	
	global $theme_post_types;
	
	$post_type_choices = [];
	
	foreach ( $theme_post_types as $theme_post_type ) :
	
		if ($theme_post_type['posts_row'] == true)
			$post_type_choices[$theme_post_type['value']] = $theme_post_type['label'];
	
	endforeach;
    
    $field['choices'] = $post_type_choices;

    return $field;
    
}
add_filter('acf/load_field/key=field_62c61f37cc420', 'acf_load_post_types_row');