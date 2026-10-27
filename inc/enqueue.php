<?php

/* ==========================================================================
   Enqueue CSS and JS
   ========================================================================== */

// ENQUEUE STYLES  
function enqueue_styles() {  

	/** REGISTER foundation **/  
	wp_register_style( 'foundation', THEME_DIR . '/assets/css/foundation.xy.css', array(), '1', 'all' );  
	wp_enqueue_style( 'foundation' );

	/** REGISTER Fonts **/  
	wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap', array(), null, 'all' );  
	wp_enqueue_style( 'google-fonts' );
	
	/** REGISTER swiper **/  
	wp_register_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '1', 'all' );  
	wp_enqueue_style( 'swiper' );	

	/** REGISTER app **/  
	wp_register_style( 'app', THEME_DIR . '/assets/css/app.css', array(), '1', 'all' );  
	// wp_enqueue_style( 'app' );
	
	/** REGISTER colour-variations **/  
	wp_register_style( 'colour-variations', THEME_DIR . '/assets/css/colour-variations.css', array(), '1', 'all' );  
	wp_enqueue_style( 'colour-variations' );

	/** REGISTER theme **/  
	wp_register_style( 'theme', THEME_DIR . '/assets/css/theme.css', array( 'google-fonts' ), '1', 'all' );  
	wp_enqueue_style( 'theme' );

}  
add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

function sainsbury_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'sainsbury_resource_hints', 10, 2 );

/**
 * Google Maps is only needed where a .location-map element is rendered.
 */
function sainsbury_page_needs_google_maps() {
	$post = get_queried_object();

	if ( ! ( $post instanceof WP_Post ) ) {
		return false;
	}

	return false !== strpos( $post->post_content, 'location-map' );
}

/**
 * Font Awesome is only needed where an icon class, lightbox, or legacy template prints it.
 */
function sainsbury_page_needs_font_awesome() {
	if ( is_singular( 'post' ) || is_home() || is_archive() || is_search() ) {
		return true;
	}

	$post = get_queried_object();

	if ( ! ( $post instanceof WP_Post ) ) {
		return false;
	}

	$content = $post->post_content;

	if ( has_shortcode( $content, 'content_popup_button' ) ) {
		return true;
	}

	if ( preg_match( '/\bfa-[a-z0-9-]+/', $content ) ) {
		return true;
	}

	if ( false !== strpos( $content, 'data-fancybox' ) ) {
		return true;
	}

	return (bool) preg_match( '/href=["\'][^"\']+\.(?:gif|jpe?g|png|bmp)(?:\?[^"\']*)?["\']/i', $content );
}

// ENQUEUE SCRIPTS  
function enqueue_scripts() {  

	/*
	 * REGISTER Modernizr
	 * This is only neccessary if we need to account for older browsers
	 */  
	//wp_register_script( 'modernizr', THEME_DIR . '/assets/js/vendor/modernizr-3.6.0.min.js', array(), '3.6.0', false );  
	//wp_enqueue_script( 'modernizr' );

	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script( 'jquery', THEME_DIR . '/assets/js/vendor/jquery-3.6.1.min.js', array(), '3.6.1', true );
		wp_enqueue_script('jquery');
	}

	/** REGISTER Migrate **/  
	wp_register_script( 'migrate', THEME_DIR . '/assets/js/vendor/jquery-migrate-3.0.1.min.js', array('jquery'), '3.0.1', true );  
	wp_enqueue_script( 'migrate' );

	/** REGISTER hoverIntent **/  
	wp_register_script( 'hoverintent', THEME_DIR . '/assets/js/vendor/jquery.hoverIntent.min.js', array('jquery'), '1.10.2', true );  
	wp_enqueue_script( 'hoverintent' );

	/*
	 * REGISTER Icon Font
	 * https://fontawesome.com/icons
	 */  
	wp_register_script( 'icons', 'https://kit.fontawesome.com/29b58b9908.js', array(), '1', true );
	if ( sainsbury_page_needs_font_awesome() ) {
		wp_enqueue_script( 'icons' );
	}

	/** REGISTER what-input **/  
	//wp_register_script( 'what-input', THEME_DIR . '/assets/js/vendor/what-input.js', array('jquery'), '1', true );  
	//wp_enqueue_script( 'what-input' );
	
	/** REGISTER Google Maps API **/
	wp_register_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key='.GOOGLE_MAPS_API_KEY.'&callback=googleMapsLoaded', array(), '1', true );
	if ( sainsbury_page_needs_google_maps() ) {
		wp_enqueue_script( 'google-maps' );
		wp_add_inline_script( 'google-maps', 'function googleMapsLoaded() { console.log("Google Maps loaded successfully.") }', 'before' );
	}

	/** REGISTER swiper **/  
	wp_register_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), '1', true );  
	wp_enqueue_script( 'swiper' );
	
	/** REGISTER plugins **/  
	wp_register_script( 'plugins', THEME_DIR . '/assets/js/plugins.js', array('jquery'), '1', true );  
	wp_enqueue_script( 'plugins' );

	/** REGISTER app **/  
	wp_register_script( 'app', THEME_DIR . '/assets/js/app.js', array('jquery'), '1', true );  
	wp_enqueue_script( 'app' );

	/** REGISTER theme **/  
	wp_register_script( 'theme', THEME_DIR . '/assets/js/theme.js', array('jquery', 'hoverintent', 'swiper'), '1', true );  
	wp_enqueue_script( 'theme' );
	
	$translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
	//after wp_enqueue_script
	wp_localize_script( 'app', 'themeurl', $translation_array );

}   
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

function sainsbury_block_editor_scripts() {
	if ( ! is_admin() ) {
		return;
	}

	wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap', array(), null, 'all' );
	wp_enqueue_style( 'google-fonts' );

	wp_register_script( 'icons', 'https://kit.fontawesome.com/29b58b9908.js', array(), '1', true );
	wp_enqueue_script( 'icons' );

	wp_register_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array( 'jquery' ), '1', true );
	wp_enqueue_script( 'swiper' );

	wp_register_script( 'app', THEME_DIR . '/assets/js/app.js', array( 'jquery' ), '1', true );
	wp_enqueue_script( 'app' );
}
add_action( 'enqueue_block_assets', 'sainsbury_block_editor_scripts' );