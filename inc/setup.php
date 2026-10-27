<?php

/* ==========================================================================
   Site Set Up
   ========================================================================== */

/*
 * Theme colours
 */
$theme_colours	= array(
	array(
		'value' 				=> 'white',
		'label' 				=> 'White',
		'background_colour'		=> true,
		'box_background_colour'	=> true,
		'wysiwyg_style'			=> false,
		'shortcode_background'	=> false,
		'shortcode_button'		=> false
	),
	array(
		'value' 				=> 'grey',
		'label' 				=> 'Grey',
		'background_colour'		=> true,
		'box_background_colour'	=> true,
		'wysiwyg_style'			=> false,
		'shortcode_background'	=> true,
		'shortcode_button'		=> false
	),
	array(
		'value' 				=> 'black',
		'label' 				=> 'Black',
		'background_colour'		=> true,
		'box_background_colour'	=> true,
		'wysiwyg_style'			=> false,
		'shortcode_background'	=> false,
		'shortcode_button'		=> false
	),
	array(
		'value' 				=> 'primary',
		'label' 				=> 'Primary',
		'background_colour'		=> true,
		'box_background_colour'	=> true,
		'wysiwyg_style'			=> true,
		'shortcode_background'	=> true,
		'shortcode_button'		=> true
	),
	array(
		'value' 				=> 'secondary',
		'label' 				=> 'Secondary',
		'background_colour'		=> true,
		'box_background_colour'	=> false,
		'wysiwyg_style'			=> true,
		'shortcode_background'	=> true,
		'shortcode_button'		=> true
	),
	array(
		'value' 				=> 'tertiary',
		'label' 				=> 'Tertiary',
		'background_colour'		=> true,
		'box_background_colour'	=> false,
		'wysiwyg_style'			=> true,
		'shortcode_background'	=> true,
		'shortcode_button'		=> true
	),
	array(
		'value'					=> 'highlight',
		'label' 				=> 'Highlight',
		'background_colour'		=> true,
		'box_background_colour'	=> true,
		'wysiwyg_style'			=> true,
		'shortcode_background'	=> true,
		'shortcode_button'		=> true
	)
);

/*
 * Theme text sizes
 */
$theme_text_sizes	= array(
	array(
		'value' 								=> 'h1',
		'label' 								=> 'H1',
		'title_size'							=> false,
		'title_size_default'					=> false,
		'flexible_content_title_size'			=> false,
		'flexible_content_title_size_default'	=> false,
		'wysiwyg_style'							=> true
	),
	array(
		'value' 								=> 'h2',
		'label' 								=> 'H2',
		'title_size'							=> true,
		'title_size_default'					=> true,
		'flexible_content_title_size'			=> false,
		'flexible_content_title_size_default'	=> false,
		'wysiwyg_style'							=> true
	),
	array(
		'value' 								=> 'h3',
		'label' 								=> 'H3',
		'title_size'							=> true,
		'title_size_default'					=> false,
		'flexible_content_title_size'			=> true,
		'flexible_content_title_size_default'	=> true,
		'wysiwyg_style'							=> true
	),
	array(
		'value' 								=> 'h4',
		'label' 								=> 'H4',
		'title_size'							=> true,
		'title_size_default'					=> false,
		'flexible_content_title_size'			=> true,
		'flexible_content_title_size_default'	=> false,
		'wysiwyg_style'							=> true
	),
	array(
		'value' 								=> 'h5',
		'label' 								=> 'H5',
		'title_size'							=> false,
		'title_size_default'					=> false,
		'flexible_content_title_size'			=> true,
		'flexible_content_title_size_default'	=> false,
		'wysiwyg_style'							=> true
	),
	array(
		'value' 								=> 'h6',
		'label' 								=> 'H6',
		'title_size'							=> false,
		'title_size_default'					=> false,
		'flexible_content_title_size'			=> false,
		'flexible_content_title_size_default'	=> false,
		'wysiwyg_style'							=> true
	)
);

/*
 * Theme padding options
 */
$theme_padding_options	= array(
	array(
		'value' 		=> 'content-area',
		'label' 		=> 'Medium',
		'default'		=> false
	),
	array(
		'value' 		=> 'content-area-x2',
		'label' 		=> 'Large',
		'default'		=> true
	)
);

/*
 * Theme post types
 */
$theme_post_types	= array(
	array(
		'value' 		=> 'post',
		'label' 		=> 'Post',
		'posts_page'	=> true,
		'posts_row'		=> true
	)
);

/*
 * WYSIWYG Customisations
 */
$custom_wysiwyg_styles		= true;
$custom_wysiwyg_shortcodes	= true;

/*
 * Hide editor from specific page templates
 */
function sainsbury_remove_editor() {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);
        switch ($template) {
            case 'templates/page-builder.php':
            // the below removes 'editor' support for 'pages'
            // if you want to remove for posts or custom post types as well
            // add this line for posts:
            // remove_post_type_support('post', 'editor');
            // add this line for custom post types and replace 
            // custom-post-type-name with the name of post type:
            // remove_post_type_support('custom-post-type-name', 'editor');
            // remove_post_type_support('page', 'editor');
            break;
            default :
            // Don't remove any other template.
            break;
        }
    }
}
add_action('init', 'sainsbury_remove_editor');

function sainsbury_disable_gutenberg($current_status, $post_type)
{
    // Use your post type key instead of 'product'
    if ($post_type !== 'page') return false;
    return $current_status;
}
add_filter('use_block_editor_for_post_type', 'sainsbury_disable_gutenberg', 10, 2);