<?php

/* ==========================================================================
   Custom Functions
   ========================================================================== */

/*
 * Disable REST API
 *
add_filter( 'rest_authentication_errors', 'wp_snippet_disable_rest_api' );

function wp_snippet_disable_rest_api( $access ) {
	return new WP_Error( 'rest_disabled', __('The WordPress REST API has been disabled.'), array( 'status' => rest_authorization_required_code()));
}

/*
 * Disable XMLRPC
 *
add_filter('xmlrpc_enabled', '__return_false');

/**
 * [list_searcheable_acf list all the custom fields we want to include in our search query]
 * @return [array] [list of custom fields]
 */
function list_searcheable_acf(){
  $list_searcheable_acf = array('row_title', 'row_content', 'title', 'content', 'panel_title', 'panel_content');
  return $list_searcheable_acf;
}


/**
 * [advanced_custom_search search that encompasses ACF/advanced custom fields and taxonomies and split expression before request]
 * @param  [query-part/string]      $where    [the initial "where" part of the search query]
 * @param  [object]                 $wp_query []
 * @return [query-part/string]      $where    [the "where" part of the search query as we customized]
 * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
 * credits to Vincent Zurczak for the base query structure/spliting tags section
 */
function advanced_custom_search( $where, $wp_query ) {

    global $wpdb;
 
    if ( empty( $where ))
        return $where;
 
    // get search expression
    $terms = $wp_query->query_vars[ 's' ];
    
    // explode search expression to get search terms
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );
         
    // reset search in order to rebuilt it as we whish
    $where = '';
    
    // get searcheable_acf, a list of advanced custom fields you want to search content in
    $list_searcheable_acf = list_searcheable_acf();

    foreach( $exploded as $tag ) :
        $where .= " 
          AND (
            (wp_posts.post_title LIKE '%$tag%')
            OR (wp_posts.post_content LIKE '%$tag%')
            OR EXISTS (
              SELECT * FROM wp_postmeta
	              WHERE post_id = wp_posts.ID
	                AND (";

        foreach ($list_searcheable_acf as $searcheable_acf) :
          if ($searcheable_acf == $list_searcheable_acf[0]):
            $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
          else :
            $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
          endif;
        endforeach;

	        $where .= ")
            )
            OR EXISTS (
              SELECT * FROM wp_comments
              WHERE comment_post_ID = wp_posts.ID
                AND comment_content LIKE '%$tag%'
            )
            OR EXISTS (
              SELECT * FROM wp_terms
              INNER JOIN wp_term_taxonomy
                ON wp_term_taxonomy.term_id = wp_terms.term_id
              INNER JOIN wp_term_relationships
                ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
              WHERE (
          		taxonomy = 'post_tag'
            		OR taxonomy = 'category'          		
            		OR taxonomy = 'myCustomTax'
          		)
              	AND object_id = wp_posts.ID
              	AND wp_terms.name LIKE '%$tag%'
            )
        )";
    endforeach;
    return $where;
}
 
add_filter( 'posts_search', 'advanced_custom_search', 500, 2 );

/*
 *  Yoast SEO
 */
function sainsbury_add_old_separators($separators){
	$separators['sainsbury-pipe']   = array(
		'option' => '|',
		'label'  => __( 'Vertical bar', 'wordpress-seo' ),
	);
	
    return $separators;
}
add_filter('wpseo_separator_option_list', 'sainsbury_add_old_separators');

/*
 * Add class to wpautop()
 * Usage: echo sainsbury_wpautop($content, 'class')
 */
function sainsbury_wpautop( $pee, $className = null, $br = true ) {
	$pre_tags = array();

	if ( trim( $pee ) === '' ) {
		return '';
	}

	// Just to make things a little easier, pad the end.
	$pee = $pee . "\n";

	/*
	 * Pre tags shouldn't be touched by autop.
	 * Replace pre tags with placeholders and bring them back after autop.
	 */
	if ( strpos( $pee, '<pre' ) !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee  = array_pop( $pee_parts );
		$pee       = '';
		$i         = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos( $pee_part, '<pre' );

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name              = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[ $name ] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}
	// Change multiple <br>s into two line breaks, which will turn into paragraphs.
	$pee = preg_replace( '|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee );

	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

	// Add a double line break above block-level opening tags.
	$pee = preg_replace( '!(<' . $allblocks . '[\s/>])!', "\n\n$1", $pee );

	// Add a double line break below block-level closing tags.
	$pee = preg_replace( '!(</' . $allblocks . '>)!', "$1\n\n", $pee );

	// Standardize newline characters to "\n".
	$pee = str_replace( array( "\r\n", "\r" ), "\n", $pee );

	// Find newlines in all elements and add placeholders.
	$pee = wp_replace_in_html_tags( $pee, array( "\n" => ' <!-- wpnl --> ' ) );

	// Collapse line breaks before and after <option> elements so they don't get autop'd.
	if ( strpos( $pee, '<option' ) !== false ) {
		$pee = preg_replace( '|\s*<option|', '<option', $pee );
		$pee = preg_replace( '|</option>\s*|', '</option>', $pee );
	}

	/*
	 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
	 * so they don't get autop'd.
	 */
	if ( strpos( $pee, '</object>' ) !== false ) {
		$pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
		$pee = preg_replace( '|\s*</object>|', '</object>', $pee );
		$pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
	}

	/*
	 * Collapse line breaks inside <audio> and <video> elements,
	 * before and after <source> and <track> elements.
	 */
	if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
		$pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
		$pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
		$pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
	}

	// Collapse line breaks before and after <figcaption> elements.
	if ( strpos( $pee, '<figcaption' ) !== false ) {
		$pee = preg_replace( '|\s*(<figcaption[^>]*>)|', '$1', $pee );
		$pee = preg_replace( '|</figcaption>\s*|', '</figcaption>', $pee );
	}

	// Remove more than two contiguous line breaks.
	$pee = preg_replace( "/\n\n+/", "\n\n", $pee );

	// Split up the contents into an array of strings, separated by double line breaks.
	$pees = preg_split( '/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY );

	// Reset $pee prior to rebuilding.
	$pee = '';

	// Rebuild the content as a string, wrapping every bit with a <p>.
	foreach ( $pees as $tinkle ) {
		$pee .= '<p class="'.$className.'">' . trim($tinkle, "\n") . "</p>\n";
	}

	// Under certain strange conditions it could create a P of entirely whitespace.
	$pee = preg_replace( '|<p>\s*</p>|', '', $pee );

	// Add a closing <p> inside <div>, <address>, or <form> tag if missing.
	$pee = preg_replace( '!<p>([^<]+)</(div|address|form)>!', '<p>$1</p><$2>', $pee );

	// If an opening or closing block element tag is wrapped in a <p>, unwrap it.
	$pee = preg_replace( '!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $pee );

	// In some cases <li> may get wrapped in <p>, fix them.
	$pee = preg_replace( '|<p>(<li.+?)</p>|', '$1', $pee );

	// If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
	$pee = preg_replace( '|<p><blockquote([^>]*)>|i', '<blockquote$1><p>', $pee );
	$pee = str_replace( '</blockquote></p>', '</p></blockquote>', $pee );

	// If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
	$pee = preg_replace( '!<p>\s*(</?' . $allblocks . '[^>]*>)!', '$1', $pee );

	// If an opening or closing block element tag is followed by a closing <p> tag, remove it.
	$pee = preg_replace( '!(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $pee );

	// Optionally insert line breaks.
	if ( $br ) {
		// Replace newlines that shouldn't be touched with a placeholder.
		$pee = preg_replace_callback( '/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee );

		// Normalize <br>
		$pee = str_replace( array( '<br>', '<br/>' ), '<br />', $pee );

		// Replace any new line characters that aren't preceded by a <br /> with a <br />.
		$pee = preg_replace( '|(?<!<br />)\s*\n|', "<br />\n", $pee );

		// Replace newline placeholders with newlines.
		$pee = str_replace( '<WPPreserveNewline />', "\n", $pee );
	}

	// If a <br /> tag is after an opening or closing block tag, remove it.
	$pee = preg_replace( '!(</?' . $allblocks . '[^>]*>)\s*<br />!', '$1', $pee );

	// If a <br /> tag is before a subset of opening or closing block tags, remove it.
	$pee = preg_replace( '!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee );
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	// Replace placeholder <pre> tags with their original content.
	if ( ! empty( $pre_tags ) ) {
		$pee = str_replace( array_keys( $pre_tags ), array_values( $pre_tags ), $pee );
	}

	// Restore newlines in all elements.
	if ( false !== strpos( $pee, '<!-- wpnl -->' ) ) {
		$pee = str_replace( array( ' <!-- wpnl --> ', '<!-- wpnl -->' ), "\n", $pee );
	}

	return $pee;
}