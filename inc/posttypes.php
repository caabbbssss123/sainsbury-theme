<?php

/* ==========================================================================
   Register Post Types
   ========================================================================== */
 
/** POST_NAME post type **/
//add_action('init', 'POST_NAME_register');
 
function POST_NAME_register() {
 
	$post_name_plural	= '';
	$post_name_singular	= '';
	$post_type			= '';
 
	$labels = array(
		'name' => _x($post_name_plural, 'post type general name'),
		'singular_name' => _x($post_name_singular, 'post type singular name'),
		'add_new' => _x('Add New ' . $post_name_singular, $post_type),
		'add_new_item' => __('Add New ' . $post_name_singular),
		'edit_item' => __('Edit ' . $post_name_singular),
		'new_item' => __('New ' . $post_name_singular),
		'view_item' => __('View ' . $post_name_singular),
		'search_items' => __('Search ' . $post_name_plural),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true, // Can this post type be accessed by a URL?
		'publicly_queryable' => true,
		'show_in_nav_menus' => false, // Can this post type be added to navigation menus?
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 40,
		'menu_icon' => 'dashicons-', // https://developer.wordpress.org/resource/dashicons/
		'rewrite' => array( 'slug' => 'URL_SLUG' ), // Change URL_SLUG to appropraite URL slug
		'capability_type' => 'post',
		'hierarchical' => false,  // Can this post type have child posts?
		'supports' => array('title', 'editor')
	  ); 
 
	register_post_type( $post_type , $args );
}

//hook into the init action and call create_book_taxonomies when it fires
//add_action( 'init', 'create_POST_NAME_taxonomies', 0 );

function create_POST_NAME_taxonomies() {
	
  	$post_name		= '';
	$post_taxonomy	= '';
	$post_type		= '';
	
  	$labels = array(
		'name' => _x( $post_name . ' Categories', 'taxonomy general name' ),
		'singular_name' => _x( $post_name . ' Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Categories' ),
		'all_items' => __( 'All Categories' ),
		'edit_item' => __( 'Edit Category' ), 
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add Category' ),
		'new_item_name' => __( 'New Category' ),
		'menu_name' => __( $post_name . ' Categories' ),
  	); 	

	register_taxonomy(
		$post_taxonomy,
		array($post_type), 
		array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true, // Whether to generate and allow a UI for managing terms in this taxonomy in the admin
			//'meta_box_cb' => false, // Provide a callback function for the meta box display. If false, no meta box is shown - useful when using ACF to limit adding terms to posts 
			//'show_in_quick_edit' => false, // Whether to show the taxonomy in the quick/bulk edit panel.
			'query_var' => true,
			'publicly_queryable' => true, // Can this taxonomy be accessed by a URL?
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite' => array( 'slug' => 'URL_SLUG' ), // Change URL_SLUG to appropraite name (this is the category url slug)
		)
	);
}

/* ==========================================================================
   Add taxonomy filter
   ========================================================================== */

add_action( 'restrict_manage_posts', 'sainsbury_restrict_manage_posts' );

function sainsbury_restrict_manage_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
	
    if ($typenow == 'POST_TYPE') {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array('POST_TAXONOMY');

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show All $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
}