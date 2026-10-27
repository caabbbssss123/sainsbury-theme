<?php

define('THEME_DIR', get_template_directory_uri());
if ( ! defined( 'GOOGLE_MAPS_API_KEY' ) ) {
	define( 'GOOGLE_MAPS_API_KEY', '' );
}

/*
 * Theme setup
 */
require 'inc/setup.php';

/*
 * Wordpress setup
 */
require 'inc/wordpress.php';

/*
 * Enqueue CSS and JS
 */
require 'inc/enqueue.php';

/*
 * Users
 */
require 'inc/users.php';

/*
 * Comments
 * Comments are disabled by default
 * Remove disable_comments() from inc/wordpress.php to enable
 * and add:
 * if ( is_singular() && get_option( 'thread_comments' ) )
 *	wp_enqueue_script( 'comment-reply' );
 * to inc/enqueue.php
 */
require 'inc/comments.php';

/*
 * ACF functions
 */
require 'inc/acf.php';

/*
 * ACF functions
 */
require 'inc/acf-blocks.php';

/*
 * Menus
 */
require 'inc/menus.php';

/*
 * Media
 */
require 'inc/media.php';

/*
 * Post Types
 */
require 'inc/posttypes.php';

/*
 * Gravity Forms
 */
require 'inc/forms.php';

/*
 * WYSIWYG
 */
require 'inc/editor.php';

/*
 * WYSIWYG
 */
require 'inc/wysiwyg.php';

/*
 * Shortcodes
 */
require 'inc/shortcodes.php';

/*
 * Pagination
 */
require 'inc/pagination.php';

/*
 * Custom functions
 */
require 'inc/custom.php';

/*
 * Mobile detect
 */
require 'inc/Mobile_Detect.php';