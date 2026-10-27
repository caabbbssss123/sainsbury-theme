<?php

/* ==========================================================================
   Text Editor
   ========================================================================== */

global $custom_wysiwyg_styles, $custom_wysiwyg_shortcodes;

// WYSIWYG styles
function custom_editor_styles() {
	// add_editor_style('assets/css/editor-styles.css');
}
add_action( 'admin_init', 'custom_editor_styles' );

// Tinymce config
function sainsbury_tinymce_config( $init ) {
	
    // html elements being stripped
    $init['extended_valid_elements'] = 'div[*]';
    // don't remove line breaks
    $init['remove_linebreaks'] = false;
    // convert newline characters to BR
    $init['convert_newlines_to_brs'] = true;
    // don't remove redundant BR
    $init['remove_redundant_brs'] = false;
	
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;';
	
	// Keep the toolbar open
	$init['wordpress_adv_hidden'] = FALSE;
	
    // pass back to wordpress
    return $init;
	
}
add_filter('tiny_mce_before_init', 'sainsbury_tinymce_config');

/* ==========================================================================
   Add "Shortcodes" drop-down
   ========================================================================== */

if ($custom_wysiwyg_shortcodes == true) {
	// Add dropdown to WYSIWYG
	// hooks your functions into the correct filters
	function custom_mce_buttons_3($buttons){ 
		$buttons[] = 'wdm_mce_dropbutton';
		return $buttons;
	}
	add_filter( 'mce_buttons_3', 'wdm_register_mce_button' );

	// register new button in the editor
	function wdm_register_mce_button( $buttons ) {
		array_push( $buttons, 'wdm_mce_dropbutton' );
		return $buttons;
	}
	
	// Add the theme_colours json variable to the admin head
	function sainsbury_theme_colours_admin_head() {
		global $theme_colours;
		$shortcode_options = json_encode($theme_colours);

		if (is_admin()) {
			?>
			<script type="text/javascript">
			var shortcode_options = <?php echo $shortcode_options; ?>
			</script>
			<?php
		}
	}
	add_action('admin_head', 'sainsbury_theme_colours_admin_head');

	// declare a script for the new button
	// the script will insert the shortcode on the click event
	function wdm_add_tinymce_plugin( $plugin_array ) {
		$plugin_array['wdm_mce_dropbutton'] = get_stylesheet_directory_uri() .'/assets/js/shortcodes.js';
		return $plugin_array;
	}
	add_filter( 'mce_external_plugins', 'wdm_add_tinymce_plugin' );
}

/* ==========================================================================
   Add "Styles" drop-down
   ========================================================================== */

if ($custom_wysiwyg_styles == true) {
	/**
	 * Add styles/classes dropdown to the WYSIWYG
	 */
	add_filter( 'mce_buttons_2', 'sainsbury_mce_editor_buttons' );
	function sainsbury_mce_editor_buttons( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}
	/**
	 * Add styles/classes to the "Styles" drop-down
	 */
	add_filter( 'tiny_mce_before_init', 'sainsbury_mce_before_init' );
	function sainsbury_mce_before_init( $settings ) {
		
		global $theme_colours, $theme_text_sizes;
		
		$style_formats = array(
			'text-size' 	=> array( 
				'title' 	=> 'Text Size',
				'items' 	=> array()
			),
			'text-colour' 	=> array( 
				'title' 	=> 'Text Colours',
				'items' 	=> array()
			),
			'lists'			=> array( 
				'title' 	=> 'Lists',
				'items' 	=> array(
					array(  
						'title' 	=> '2 Columns',
						'selector' 	=> 'ul, ol',
						'classes' 	=> 'list-2-columns'
					),
				)
			),
			'buttons'		=> array( 
				'title' 	=> 'Buttons',
				'items' 	=> array()
			),
			'tables'		=> array( 
				'title' 	=> 'Tables',
				'items' 	=> array()
			)
		);
		
		foreach ( $theme_text_sizes as $theme_text_size ) :
	
			if ($theme_text_size['wysiwyg_style'] == true) {
				
				$style_formats['text-size']['items'][] = array(
					'title' 	=> 'Size: ' . $theme_text_size['label'],
					'inline' 	=> 'span',
					'classes' 	=> 'size-' . $theme_text_size['value']
				);
				
				$style_formats['lists']['items'][] = array(
					'title' 	=> 'Size: ' . $theme_text_size['label'],
					'selector' 	=> 'ul, ol',
					'classes' 	=> 'color-' . $theme_text_size['value']
				);
				
			}

		endforeach;
		
		foreach ( $theme_colours as $theme_colour ) :
	
			if ($theme_colour['wysiwyg_style'] == true) {
				
				$style_formats['text-colour']['items'][] = array(
					'title'		=> 'Colour: ' . $theme_colour['label'],
					'inline' 	=> 'span',
					'classes'	=> 'color-' . $theme_colour['value']
				);
				
				$style_formats['lists']['items'][] = array(
					'title' 	=> 'Colour: ' . $theme_colour['label'],
					'selector'	=> 'ul, ol',
					'classes'	=> 'color-' . $theme_colour['value']
				);
				
				$style_formats['buttons']['items'][] = array(
					'title' 	=> 'Colour: ' . $theme_colour['label'],
					'selector' 	=> 'a',
					'classes' 	=> 'btn btn--' . $theme_colour['value']
				);
				
				$style_formats['buttons']['items'][] = array(
					'title' 	=> 'Colour: ' . $theme_colour['label'] . ' Hollow',
					'selector' 	=> 'a',
					'classes' 	=> 'btn btn--hollow btn--hollow--' . $theme_colour['value']
				);
				
				$style_formats['tables']['items'][] = array(
					'title' 	=> 'Background: ' . $theme_colour['label'],
					'selector' 	=> 'th, td',
					'classes'	=> 'background-' . $theme_colour['value']
				);
				
			}

		endforeach;
		
		$settings['style_formats'] = json_encode( $style_formats );
		return $settings;
	}
	/* Learn TinyMCE style format options at http://www.tinymce.com/wiki.php/Configuration:formats */
}