<?php

/* ==========================================================================
   Wordpress Media
   ========================================================================== */

/**
 * Set our image sizes
 */

// Remove built in image sizes
function sainsbury_remove_extra_image_sizes() {
    foreach ( get_intermediate_image_sizes() as $size ) {
        if ( in_array( $size, array( '1536x1536', '2048x2048' ) ) ) {
            remove_image_size( $size );
        }
    }
}
add_action('init', 'sainsbury_remove_extra_image_sizes');

add_filter( 'intermediate_image_sizes', function( $sizes ) {
    return array_filter( $sizes, function( $val ) {
        return 'medium_large' !== $val; // Filter out 'medium_large'
    });
});

// Set the large image threshold
function sainsbury_big_image_size_threshold( $threshold ) {
	return 3600; // new threshold
}
add_filter('big_image_size_threshold', 'sainsbury_big_image_size_threshold', 999, 1);

// Set standard sizes
update_option( 'thumbnail_size_w', 800 );
update_option( 'thumbnail_size_h', 800 );
update_option( 'thumbnail_crop', 1 );

update_option( 'medium_size_w', 1200 );
update_option( 'medium_size_h', 800 );
update_option( 'medium_crop', 1 );

update_option( 'large_size_w', 1800 );
update_option( 'large_size_h', 1200 );
update_option( 'large_crop', 1 );

// Add custom sizes
add_image_size( 'xlarge', 3600, 2400, false );
add_image_size( 'portrait', 800, 1200, true );

// Set a max width and height for fancybox zoomed images
add_image_size( 'fancybox', 1600, 1600, false );

// Admin preview image
add_image_size( 'admin_preview', 400, 400, false );

/**
 * Enable Media Library infinite scrolling
 */
//add_filter( 'media_library_infinite_scrolling', '__return_true' );

/**
 * Remove Create audio playlist and Create video playlist buttons
 * This does not work at the moment so we hide the buttons with CSS
 */
add_filter( 'media_library_show_audio_playlist', function() { return false; });
add_filter( 'media_library_show_video_playlist', function() { return false; });
add_filter( 'media_library_show_audio_playlist', '__return_false' );
add_filter( 'media_library_show_video_playlist', '__return_false' );

/**
 * Add CSS to control Media Modal options
 * Hide:
 * Playlist buttons,
 * Gallery item link to options, 
 * Link to attachment page option
 * Gallery column options - limit to max 3
 */
function sainsbury_remove_playlist_buttons() {
  echo '<style>
  	#menu-item-playlist,
	#menu-item-video-playlist,
	.setting select.link-to option[value="post"],
    .setting select[data-setting="link"] option[value="post"],
	.gallery-settings .columns option:nth-child(n+4) { 
	  display: none !important;
	}
  </style>';
}
add_action('admin_head', 'sainsbury_remove_playlist_buttons');

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * @since Sainsbury 3.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Control the image sizes available through Add Media
 */
function sainsbury_custom_image_sizes_add_settings($sizes) {
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);
	unset( $sizes['full'] );
	
	$mynewimgsizes = array(
		"full" => __( "Full" ),
		"medium" => __( "Landscape" ),
		"portrait" => __( "Portrait" ),
		"thumbnail" => __( "Square" )
	);
	
	$newimgsizes = array_merge($sizes, $mynewimgsizes);
	
	return $newimgsizes;
}
add_filter('image_size_names_choose', 'sainsbury_custom_image_sizes_add_settings');

/**
/* Attachment Default Settings
*/
function sainsbury_attachment_defaults() {
  update_option('image_default_align', 'none' );
  update_option('image_default_link_type', 'none' );
  update_option('image_default_size', 'medium' );
}
add_action('after_setup_theme', 'sainsbury_attachment_defaults');

/**
/* Gallery Default Settings
*/
function sainsbury_gallery_defaults( $settings ) {
    $settings['galleryDefaults']['columns'] = 2;
	$settings['galleryDefaults']['link'] = 'none';
    return $settings;
}
add_filter( 'media_view_settings', 'sainsbury_gallery_defaults' );

/**
 * @since Sainsbury 3.0
 * @deprecated in Sainsbury 3.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function sainsbury_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'sainsbury_remove_gallery_css' );

/* ==========================================================================
   Post Galleries
   This is taken from NCW
   ========================================================================== */

add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'medium',
		'link'       => 'none',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

	$link = tag_escape($link);
    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
	$columns_small = intval($columns) - 2;
	$columns_medium = intval($columns) - 1;
	
	switch($size) {
		case 'portrait':
			$set_size	= 'set-size--portrait';
			break;
		case 'square':
			$set_size	= 'set-size--square';
			break;
		default:
			$set_size	= 'set-size--landscape';
	}

    $selector = "gallery-{$instance}";

    $output = apply_filters('gallery_style', "
        <div id='$selector' class='gallery galleryid-{$id} grid-x grid-x--xsmall grid-padding-x grid-padding-y small-up-$columns_small medium-up-$columns_medium large-up-$columns'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
		$attachment_id = $attachment->ID;
		$img = wp_get_attachment_image_src($id, $size);
		$img_xlarge = wp_get_attachment_image_src($id, 'fancybox');
		$alt_text = get_post_meta($id, '_wp_attachment_image_alt', true);

        $output .= "<div class='cell'>";
		$output .= "<div id='attachment_{$attachment_id}' class='gallery-item'>";
		if ($link == 'file') {
			$output .= "<figure>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "<a href='{$img_xlarge[0]}' class='tile-link position_relative' data-fancybox='{$selector}' data-caption=" . wptexturize($attachment->post_excerpt) . ">";
			} else {
				$output .= "<a href='{$img_xlarge[0]}' class='tile-link position_relative' data-fancybox='{$selector}'>";
			}
			$output .= "<span class='tile-link__image-container {$set_size}'>";
			$output .= "<span class='set-size__image' style='background-image:url({$img[0]})'>";
			$output .= "<img src='{$img[0]}' alt='{$alt_text}' />";
			$output .= "</span>";
			$output .= "</span>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<span class='figcaption'>
					" . wptexturize($attachment->post_excerpt) . "
					</span>";
			}	
			$output .= "</a>";
			$output .= "</figure>";
		} else {
			$output .= "<figure>";
			$output .= "<div class='set-size {$set_size}'>";
			$output .= "<div class='set-size__image' style='background-image:url({$img[0]})'>";
			$output .= "<img src='{$img[0]}' alt='{$alt_text}' />";
			$output .= "</div>";
			$output .= "</div>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<figcaption>
					" . wptexturize($attachment->post_excerpt) . "
					</figcaption>";
			}	
			$output .= "</figure>";
		}
		$output .= "</div>";
        $output .= "</div>";
    }

    $output .= "
        </div>\n";

    return $output;
}