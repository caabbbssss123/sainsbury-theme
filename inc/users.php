<?php

/* ==========================================================================
   Users
   ========================================================================== */

/**
  * Hide admin bar for all users except for admin
  */
if ( ! current_user_can( 'manage_options' ) ) {
	show_admin_bar( false );
}

/**
  * Remove the margin on the HTML element when admin bar is visible
  */
function remove_admin_bar_margin() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_bar_margin');

/**
  * User Last Login Date/Time
  *
  * Display a column with users' last login date/time in the user table 
  * from https://rudrastyh.com/wordpress/sortable-users-last-login-column.html
  */
add_action( 'wp_login', 'sainsbury_collect_login_timestamp', 20, 2 );

function sainsbury_collect_login_timestamp( $user_login, $user ) {
 
	update_user_meta( $user->ID, 'last_login', time() );
 
}

add_filter( 'manage_users_columns', 'sainsbury_add_last_login_column' );
add_filter( 'manage_users_custom_column', 'sainsbury_last_login_column', 10, 3 );
 
function sainsbury_add_last_login_column( $columns ) {
 
	$columns['last_login'] = 'Last Login'; // column ID / column Title
	return $columns;
 
}
 
function sainsbury_last_login_column( $output, $column_id, $user_id ){
 
	if( $column_id == 'last_login' ) {
 
		$last_login = get_user_meta( $user_id, 'last_login', true );
		$date_format = 'j M, Y - g:i a';
 
		$output = $last_login ? date( $date_format, $last_login ) : '-';
 
	}
 
	return $output;
 
}

add_filter( 'manage_users_sortable_columns', 'sainsbury_sortable_columns' );
add_action( 'pre_get_users', 'sainsbury_sort_last_login_column' );
 
function sainsbury_sortable_columns( $columns ) {
 
	return wp_parse_args( array(
	 	'last_login' => 'last_login'
	), $columns );
 
}
 
function sainsbury_sort_last_login_column( $query ) {
 
	if( !is_admin() ) {
		return $query;
	}

	if(!function_exists('get_current_screen')) {
		return $query;
	}
 
	$screen = get_current_screen();
 
	if( isset( $screen->id ) && $screen->id !== 'users' ) {
		return $query;
	}
 
	if( isset( $_GET[ 'orderby' ] ) && $_GET[ 'orderby' ] == 'last_login' ) {
 
		$query->query_vars['meta_key'] = 'last_login';
		$query->query_vars['orderby'] = 'meta_value';
 
	}
 
	return $query;
 
}