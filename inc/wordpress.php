<?php

/* ==========================================================================
   Wordpress Set Up
   ========================================================================== */

/*--- REMOVE GENERATOR META TAG ---*/  
remove_action('wp_head', 'wp_generator');  

/** Tell WordPress to run sainsbury_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'sainsbury_setup' );

if ( ! function_exists( 'sainsbury_setup' ) ):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Sainsbury 3.0
	 */
	function sainsbury_setup() {

		add_theme_support( 'title-tag' );
		
		// Add HTML5 theme support
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

		function remove_footer_admin () { 
			?> Copyright &copy; <?php echo date('Y');?> - <a href="<?php echo home_url('/'); ?>" target="_blank" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>. All rights reserved. <?php  
		}
		add_filter('admin_footer_text', 'remove_footer_admin');

		// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
		//add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

		// Add post-thumbnails to post types
		//add_theme_support( 'post-thumbnails', array( 'post' ) );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'sainsbury', get_template_directory() . '/assets/js/lang' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		disable_comments();

	}
endif;

/**
 * Custom LOGO
 *
 * Add client logo to the wp-admin login page
 *
 
function sainsbury_login_styles() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
			background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/svg/site-logo.svg) no-repeat 0 0;
			background-size: contain;
			height: ;
			width: ;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'sainsbury_login_styles' );
*/

/**
 * Hide "Sticky Post" checkbox and unset all sticky posts
 */
function sainsbury_hide_sticky_option() {
    global $post_type, $pagenow;
    if( 'post.php' != $pagenow && 'post-new.php' != $pagenow && 'edit.php' != $pagenow )
        return;
    ?>
    <style type="text/css">
		#sticky-span { display:none!important }
		.quick-edit-row .inline-edit-col-right input[name=sticky],
		.quick-edit-row .inline-edit-col-right input[name=sticky] + span { display:none!important; }
	</style>
    <?php
}
add_action( 'admin_print_styles', 'sainsbury_hide_sticky_option' );

update_option( 'sticky_posts', array() );

/**
 * Output custom password form for password protected posts
 */
function sainsbury_password_form() {
	
    global $post;
	
    $label	= 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
	$output	= '
	<p>' . __( "This content is password protected. To view it please enter your password below:" ) . '</p>
	<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
		<div class="gform_body gform-body">
			<div class="gform_fields">
				<div class="gfield">
					<label class="gfield_label" for="' . $label . '">' . __( "Password:" ) . '</label>
					<input name="post_password" id="' . $label . '" type="password">
				</div>
			</div>
		</div>
		<div class="gform_footer top_label">
			<button type="submit" class="gform_button button">' . esc_attr__( "Submit" ) . '</button>
		</div>
	</form>
	';
	
    return $output;
}
add_filter( 'the_password_form', 'sainsbury_password_form' );

/**
 * Remove 'Protected:' from password protected post titles
 */
function sainsbury_remove_protected_text() {
	return __('%s');
}
add_filter( 'protected_title_format', 'sainsbury_remove_protected_text' );
add_filter( 'private_title_format', 'sainsbury_remove_protected_text' );