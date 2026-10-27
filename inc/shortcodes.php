<?php

/* ==========================================================================
   Shortcodes
   https://codex.wordpress.org/Shortcode_API
   ========================================================================== */

/*
 * Current year
 * [year]
 */
function year_shortcode() {
	return wp_date( 'Y' );
}
add_shortcode( 'year', 'year_shortcode' );

/*
 * Text Underline
 * [text_underline text="" element="span"]
 */
function text_underline_shortcode( $atts ) {
	$a = shortcode_atts( array(
        'text' => '',
		'element' => 'span'
    ), $atts );
	
	$shortcode_output = '<' . $a['element'] . ' class="text-underline">' . $a['text'] . '</' . $a['element'] . '>';
	
	return $shortcode_output;
}
add_shortcode( 'text_underline', 'text_underline_shortcode' );

/*
 * Blockquote
 * [blockquote quote="" author=""]
 */
function blockquote_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'quote' => '',
		'author' => ''
    ), $atts );
	
	$shortcode_output = '<blockquote>';
	$shortcode_output .= '<p class="h4">&ldquo;' . $a['quote'] . '&rdquo;</p>';
	if ($a['author']) {
		$shortcode_output .= '<cite>&mdash;&ensp;' . $a['author'] . '</cite>';
	}
	$shortcode_output .= '</blockquote>';
	
	return $shortcode_output;
}
add_shortcode( 'blockquote', 'blockquote_shortcode' );

/*
 * AJAX Popup
 * Creates a button that triggers an AJAX popup
 * [ajax_popup_button button_title="Click here" button_target=""]
 */
function ajax_popup_button_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'button_title' => 'Click here',
		'button_colour' => 'highlight',
        'button_target' => ''
    ), $atts );
	
	$shortcode_output = '<a href="' . $a['button_target'] . '" class="btn btn--' . $a['button_colour'] . ' size-body js-ajax-trigger" data-trigger="popup">' . $a['button_title'] . '</a>';
	
	return $shortcode_output;
}
add_shortcode( 'ajax_popup_button', 'ajax_popup_button_shortcode' );

/*
 * Content Popup
 * Creates a button that triggers a popup
 * [content_popup_button button_title="Click here" button_colour="highlight"][/content_popup_button]
 */
function content_popup_button_shortcode( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'button_title' => 'Click here',
		'button_colour' => 'highlight',
        'unique_id' => uniqid()
    ), $atts );
	
	$shortcode_output = '<a href="#" class="btn btn--' . $a['button_colour'] . ' size-body js-popup-trigger" data-trigger="popup_' . sanitize_title($a['unique_id']) . '">' . $a['button_title'] . '</a>';
	
	/*
	 * Output part of this function in the footer
	 */
	$footer_output = '<section data-target="popup_' . sanitize_title($a['unique_id']) . '" class="popup grid-x js-popup content-area">
		<div class="grid-container medium-align-self-middle">
			<div class="grid-x grid-padding-x align-center">
				<div class="cell large-10 xlarge-8">
					<div class="popup__content boxed-content large-boxed-content-sides-x2 content-area large-content-area-x2 background-white wysiwyg position_relative">
						' . do_shortcode($content) . '
						<a href="#" class="close-btn js-close-trigger">
							<span class="link-icon"><i class="fa-regular fa-xmark"></i></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="popup__close js-close-trigger"></div>
	</section>';
	
	add_action( 'shortcode_output', function() use( $footer_output ) {
        echo $footer_output;
    });
	
	return $shortcode_output;
	
}
add_shortcode( 'content_popup_button', 'content_popup_button_shortcode' );

/*
 * Boxed Content
 * Wrap content in a boxed-content div
 * [boxed_content background_colour="grey"][/boxed_content]
 */
function boxed_content_shortcode( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'background_colour' => 'grey'
    ), $atts );
	
	$shortcode_output = '<div class="boxed-content background-' . $a['background_colour'] . '">' . $content . '</div>';
	
	return $shortcode_output;
}
add_shortcode( 'boxed_content', 'boxed_content_shortcode' );

/*
 * Fix shortcode output
 * https://jdmdigital.co/support/wordpress/empty-p-tags-shortcode-fix/
 */
function sainsbury_fix_shortcodes( $content ) {
	
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);
	
	$content = strtr($content, $array);

	return $content;
	
}
add_filter('the_content', 'sainsbury_fix_shortcodes');