<?php

/* ==========================================================================
   Comments
   ========================================================================== */

/**
 * Template for comments and pingbacks.
 *
 * @since Sainsbury 3.0
 */
function sainsbury_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback'  :
		case 'trackback' :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<p><?php _e( 'Pingback:', 'sainsbury' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'sainsbury'), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s says:', 'sainsbury' ), sprintf( '%s', get_comment_author_link() ) ); ?>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<?php _e( 'Your comment is awaiting moderation.', 'sainsbury' ); ?>
			<br />
		<?php endif; ?>

		<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'sainsbury' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'sainsbury' ), ' ' );
			?>

		<?php comment_text(); ?>

			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	<?php
			break;
	endswitch;
}

/**
 * Closes comments and pingbacks with </article> instead of </li>.
 *
 * @since Sainsbury 3.0
 */
function sainsbury_comment_close() {
	echo '</article>';
}

/*
 * Remove Wordpress comment functionality
 */
function sainsbury_fields($fields) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<p><label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '*' : '' ) .
		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="Name" /></p>',
		'email'  => '<p><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '*' : '' ) .
		'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p><label for="url">' . __( 'Website' ) . '</label>' .
		'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);
	return $fields;
}
add_filter('comment_form_default_fields','sainsbury_fields');

/**
  * Completely disable comments within Wordpress.
  *
  * This removes all traces of Wordpress's comments functionality, and uses modified code
  * from http://www.dfactory.eu/wordpress-how-to/turn-off-disable-comments/ to do so.
  *
  * This function should be called directly from your theme's `initTheme` method in
  * functions.php, as it is simply a wrapper for several other functions that are
  * attached to filters and actions.
  *
  * @function disable_comments
  * @return void
  */

function disable_comments() {
	// Disable support for comments and trackbacks in post types
	function disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}
	add_action('admin_init', 'disable_comments_post_types_support');

	// Close comments on the front-end
	function disable_comments_status() {
		return false;
	}
	add_filter('comments_open', 'disable_comments_status', 20, 2);
	add_filter('pings_open', 'disable_comments_status', 20, 2);

	// Hide existing comments
	function disable_comments_hide_existing_comments($comments) {
		$comments = array();
		return $comments;
	}
	add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

	// Remove comments page in menu
	function disable_comments_admin_menus() {
		remove_menu_page('edit-comments.php');
		remove_submenu_page('options-general.php','options-discussion.php');
	}
	add_action('admin_menu', 'disable_comments_admin_menus');

	// Redirect any user trying to access comments page
	function disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url()); exit;
		}
	}
	add_action('admin_init', 'disable_comments_admin_menu_redirect');

	// Remove comments metabox from dashboard
	function disable_comments_dashboard() {
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	}
	add_action('admin_init', 'disable_comments_dashboard');

	// Remove comments links from admin bar
	/*function disable_comments_admin_bar() {
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	}
	add_action('init', 'disable_comments_admin_bar');*/
	
	function sainsbury_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	}
	add_action( 'wp_before_admin_bar_render', 'sainsbury_admin_bar_render' );
	
	// Remove comment RSS
	add_filter( 'feed_links_show_comments_feed', '__return_false' ); 
}