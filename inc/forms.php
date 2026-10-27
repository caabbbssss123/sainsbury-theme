<?php

/* ==========================================================================
   Gravity Forms Functions
   ========================================================================== */

update_option( 'rg_gforms_disable_css', '__return_true' );
update_option( 'rg_gforms_enable_html5', '__return_true' );

add_filter( 'gform_disable_css', '__return_true' );
add_filter( 'gform_disable_form_legacy_css', '__return_true' );
add_filter( 'gform_disable_form_theme_css', '__return_true' );

add_filter( 'gform_tabindex', '__return_false' );
add_filter( 'gform_confirmation_anchor', '__return_false' );

add_filter( 'gform_form_args', 'sainsbury_enable_form_ajax' );
function sainsbury_enable_form_ajax( $args ) {
	$args['submission_method'] = 'ajax';

	return $args;
}

add_filter( 'gform_plugin_settings_fields', function ( $fields ) {
    
    unset( $fields['license_key'] );
    unset( $fields['license_key_details'] );
    unset( $fields['css'] );
    unset( $fields['default_theme'] );
    unset( $fields['no_conflict_mode'] );
    unset( $fields['html5'] );
  
    return $fields;
});

add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
function spinner_url( $image_src, $form ) {
    return THEME_DIR . '/assets/img/svg/gf-spinner.svg';
}

/*
 * Clear Gravity Forms theme
 */
function sainsbury_form_theme( $form ) {

    $form['theme'] = 'custom';
    $form['validationPlacement'] = 'below';

    return $form;
}
add_filter( 'gform_pre_render', 'sainsbury_form_theme' );

/*
 * Change required field indicator to asterisk
 */
add_filter( 'gform_get_form_filter', function ( $form_string, $form ) {
    $form_string = str_replace( '<span class="gfield_required gfield_required_text">(Required)</span>', '<span class="gfield_required gfield_required_asterisk">*</span>', $form_string );
    return $form_string;
}, 10, 2 );

/**
 * Filters the next, previous and submit buttons.
 * Matches the theme arrow button: .btn.btn-tertiary.btn-arrow with label and icon markup.
 *
 * @param string $button Contains the button tag to be filtered.
 * @param object $form Contains all the properties of the current form.
 *
 * @return string The filtered button.
 */
add_filter( 'gform_next_button', 'input_to_button', 10, 2 );
add_filter( 'gform_previous_button', 'input_to_button', 10, 2 );
add_filter( 'gform_submit_button', 'input_to_button', 10, 2 );
function input_to_button( $button, $form ) {
    if ( GFCommon::is_form_editor() || GFCommon::is_entry_detail() ) {
        return $button;
    }

    $dom = new DOMDocument();
    $dom->loadHTML( $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);

    if ( $input ) {
        $new_button = $dom->createElement( 'button' );
        $new_button->appendChild( $dom->createTextNode( $input->getAttribute( 'value' ) ) );
        $input->removeAttribute( 'value' );
        foreach( $input->attributes as $attribute ) {
            $new_button->setAttribute( $attribute->name, $attribute->value );
        }
        $input->parentNode->replaceChild( $new_button, $input );
        $button = $dom->saveHtml( $new_button );
    }

    if ( ! preg_match( '/<button\b([^>]*)>(.*)<\/button>/is', $button, $matches ) ) {
        return $button;
    }

    $attrs = $matches[1];
    $inner = trim( $matches[2] );
    $classes = array( 'btn', 'btn-tertiary', 'btn-arrow' );

    if ( preg_match( '/\bclass=([\'"])(.*?)\1/i', $attrs, $class_match ) ) {
        $class_value = $class_match[2];
        foreach ( $classes as $class ) {
            if ( ! preg_match( '/(^|\s)' . preg_quote( $class, '/' ) . '(\s|$)/', $class_value ) ) {
                $class_value .= ' ' . $class;
            }
        }
        $attrs = preg_replace( '/\bclass=([\'"])(.*?)\1/i', 'class="' . esc_attr( trim( $class_value ) ) . '"', $attrs, 1 );
    } else {
        $attrs .= ' class="btn btn-tertiary btn-arrow"';
    }

    if ( stripos( $inner, 'btn-text' ) === false && stripos( $inner, '<img' ) === false ) {
        ob_start();
        get_template_part( 'partials/components/component-button-icon' );
        $icon = ob_get_clean();
        $inner = '<span class="btn-text">' . $inner . '</span>' . $icon;
    }

    return '<button' . $attrs . '>' . $inner . '</button>';
}

// Turn off autocomplete for date fields
add_filter( 'gform_field_content', 'gform_form_input_autocomplete', 11, 5 ); 
function gform_form_input_autocomplete( $input, $field, $value, $lead_id, $form_id ) {
	if ( is_admin() ) return $input;
	if ( $field->type == 'date' ) {
		$input = preg_replace( '/<(input|textarea)/', '<${1} autocomplete="off" ', $input ); 
	}
	return $input;
}

// Gravity Forms Custom Addresses (Australia)
add_filter('gform_address_types', 'australian_address', 10, 2);

function australian_address( $address_types, $form_id ) {
    $address_types['australia'] = array(
    'label'       =>   'Australia', //labels the dropdown
    'country'     =>   'Australia', //sets Australia as default country
    'zip_label'   =>   'Postcode', //what it says
    'state_label' =>   'State', //as above
    'states' => array( 
        '', 
        'Australian Capital Territory',
        'New South Wales',
        'Northern Territory',
        'Queensland',
        'South Australia',
        'Tasmania', 
		'Victoria',
        'Western Australia'
        )
    );
    return $address_types;
}