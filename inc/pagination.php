<?php

/* ==========================================================================
   Pagination
   ========================================================================== */

/*
 * Set the search results post types to enable pagination
 */
add_action( 'parse_query', 'sainsbury_search_post_types' );
function sainsbury_search_post_types() {
	
    if ( is_search() && !is_admin() ) {
		
		$post_types	= $_GET['post_type'];
		
		if ($post_types)
			set_query_var( 'post_type', $post_types );
		
	}
	
    return;
}

/*
 * Set posts_per_page for category/taxonomy/archive
 * This is used to overwrite WP "Blog pages show at most"
 * "Blog pages show at most" affects pagination on genterated pages
 */
add_action( 'pre_get_posts', 'set_posts_per_page' );
function set_posts_per_page( $query ) {

	global $wp_the_query;
	
	if ( ( ! is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_category() ) ) {
	  $query->set( 'posts_per_page', 12 );
	}
	elseif ( ( ! is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_tax() ) ) {
	  $query->set( 'posts_per_page', 12 );
	}
	elseif ( ( !is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_search() ) ) {
		$query->set( 'posts_per_page', 12 );
	}

	return $query;
}

/*
 * Add class to next/prev post links
 */
add_filter( 'next_posts_link_attributes', 'sainsbury_add_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'sainsbury_add_link_attributes' );
function sainsbury_add_link_attributes() {
	return 'class="icon-link"';
}

/*
 * Add hash to pagination links
 */
add_filter('get_pagenum_link', 'sainsbury_add_hash_to_pagination');
function sainsbury_add_hash_to_pagination($url) {
    return $url . '#posts-container';
}

/***** Numbered Page Navigation (Pagination) Code.
      Tested up to WordPress version 3.1.2 *****/

/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num( $num, $to_nearest ) {
	/*Round fractions down (http://php.net/manual/en/function.floor.php)*/
	return floor( $num / $to_nearest ) * $to_nearest;
}

/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi( $before = '', $after = '' ) {
	global $wpdb, $wp_query;
	$pagenavi_options = array();
	$pagenavi_options[ 'pages_text' ] = ( 'Page %CURRENT_PAGE% of %TOTAL_PAGES%:' );
	$pagenavi_options[ 'current_text' ] = '%PAGE_NUMBER%';
	$pagenavi_options[ 'page_text' ] = '%PAGE_NUMBER%';
	$pagenavi_options[ 'first_text' ] = ( 'First Page' );
	$pagenavi_options[ 'last_text' ] = ( 'Last Page' );
	$pagenavi_options[ 'next_text' ] = '<span class="grid-x grid-x--small grid-padding-x grid-padding-y align-middle"><span class="cell shrink show-for-medium">Next</span><span class="cell shrink"><span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span></span></span>';
	$pagenavi_options[ 'prev_text' ] = '<span class="grid-x grid-x--small grid-padding-x grid-padding-y align-middle"><span class="cell shrink"><span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span></span><span class="cell shrink show-for-medium">Previous</span></span>';
	$pagenavi_options[ 'dotright_text' ] = '&#x2026;';
	$pagenavi_options[ 'dotleft_text' ] = '&#x2026;';
	$pagenavi_options[ 'num_pages' ] = 3; //continuous block of page numbers
	$pagenavi_options[ 'always_show' ] = 0;
	$pagenavi_options[ 'num_larger_page_numbers' ] = 0;
	$pagenavi_options[ 'larger_page_numbers_multiple' ] = 5;

	$prev_link = get_previous_posts_link();
	$next_link = get_next_posts_link();

	//If NOT a single Post is being displayed
	/*http://codex.wordpress.org/Function_Reference/is_single)*/
	if ( !is_single() ) {
		$request = $wp_query->request;
		//intval — Get the integer value of a variable
		/*http://php.net/manual/en/function.intval.php*/
		$posts_per_page = intval( get_query_var( 'posts_per_page' ) );
		//Retrieve variable in the WP_Query class.
		/*http://codex.wordpress.org/Function_Reference/get_query_var*/
		$paged = intval( get_query_var( 'paged' ) );
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;

		//empty — Determine whether a variable is empty
		/*http://php.net/manual/en/function.empty.php*/
		if ( empty( $paged ) || $paged == 0 ) {
			$paged = 1;
		}

		$pages_to_show = intval( $pagenavi_options[ 'num_pages' ] );
		$larger_page_to_show = intval( $pagenavi_options[ 'num_larger_page_numbers' ] );
		$larger_page_multiple = intval( $pagenavi_options[ 'larger_page_numbers_multiple' ] );
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor( $pages_to_show_minus_1 / 2 );
		//ceil — Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
		$half_page_end = ceil( $pages_to_show_minus_1 / 2 );
		$start_page = $paged - $half_page_start;

		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		$end_page = $paged + $half_page_end;
		if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if ( $end_page > $max_page ) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		$larger_per_page = $larger_page_to_show * $larger_page_multiple;
		//round_num() custom function - Rounds To The Nearest Value.
		$larger_start_page_start = ( round_num( $start_page, 10 ) + $larger_page_multiple ) - $larger_per_page;
		$larger_start_page_end = round_num( $start_page, 10 ) + $larger_page_multiple;
		$larger_end_page_start = round_num( $end_page, 10 ) + $larger_page_multiple;
		$larger_end_page_end = round_num( $end_page, 10 ) + ( $larger_per_page );

		if ( $larger_start_page_end - $larger_page_multiple == $start_page ) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if ( $larger_start_page_start <= 0 ) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if ( $larger_start_page_end > $max_page ) {
			$larger_start_page_end = $max_page;
		}
		if ( $larger_end_page_end > $max_page ) {
			$larger_end_page_end = $max_page;
		}
		if ( $max_page > 1 || intval( $pagenavi_options[ 'always_show' ] ) == 1 ) {
			/*http://php.net/manual/en/function.str-replace.php */
			/*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
			$pages_text = str_replace( "%CURRENT_PAGE%", number_format_i18n( $paged ), $pagenavi_options[ 'pages_text' ] );
			$pages_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pages_text );
			echo $before . "\n";

			if ( !empty( $pages_text ) ) {
				//echo $pages_text;
			}
			//Displays a link to the previous post which exists in chronological order from the current post.
			//http://codex.wordpress.org/Function_Reference/previous_post_link
			if ( $prev_link ) {
				echo '<div class="cell shrink align-left push-left text-left">';
				previous_posts_link( $pagenavi_options[ 'prev_text' ] );
				echo '</div>';
			} else {
				echo '<div class="cell shrink align-left push-left text-left"><a href="#" class="icon-link flex-disabled">' . $pagenavi_options[ 'prev_text' ] . '</a></div>';	
			};

			echo '<div class="cell auto show-for-medium"><div class="pagination__numbers grid-x grid-x--xsmall grid-padding-x align-center align-middle">';

			if ( $start_page >= 2 && $pages_to_show < $max_page ) {
				$first_page_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pagenavi_options[ 'first_text' ] );
				//esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
				//get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
				echo '<div class="cell shrink"><a href="' . esc_url( get_pagenum_link() ) . '" class="first animated-underline" title="' . $first_page_text . '">1</a></div>';
				if ( !empty( $pagenavi_options[ 'dotleft_text' ] ) ) {
					echo '<div class="cell shrink"><span class="expand">' . $pagenavi_options[ 'dotleft_text' ] . '</span></div>';
				}
			}

			if ( $larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page ) {
				for ( $i = $larger_start_page_start; $i < $larger_start_page_end; $i += $larger_page_multiple ) {
					$page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options[ 'page_text' ] );
					echo '<div class="cell shrink"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="single_page animated-underline" title="' . $page_text . '">' . $page_text . '</a></div>';
				}
			}

			for ( $i = $start_page; $i <= $end_page; $i++ ) {
				if ( $i == $paged ) {
					$current_page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options[ 'current_text' ] );
					echo '<div class="cell shrink"><span class="current">' . $current_page_text . '</span></div>';
				} else {
					$page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options[ 'page_text' ] );
					echo '<div class="cell shrink"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="single_page animated-underline" title="' . $page_text . '">' . $page_text . '</a></div>';
				}
			}

			if ( $end_page < $max_page ) {
				if ( !empty( $pagenavi_options[ 'dotright_text' ] ) ) {
					echo '<div class="cell shrink"><span class="expand">' . $pagenavi_options[ 'dotright_text' ] . '</span></div>';
				}
				$last_page_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pagenavi_options[ 'last_text' ] );
				echo '<div class="cell shrink"><a href="' . esc_url( get_pagenum_link( $max_page ) ) . '" class="last animated-underline" title="' . $last_page_text . '">' . $max_page . '</a></div>';
			}

			if ( $larger_page_to_show > 0 && $larger_end_page_start < $max_page ) {
				for ( $i = $larger_end_page_start; $i <= $larger_end_page_end; $i += $larger_page_multiple ) {
					$page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options[ 'page_text' ] );
					echo '<div class="cell shrink"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="single_page animated-underline" title="' . $page_text . '">' . $page_text . '</a></div>';
				}
			}

			echo '</div></div>';

			if ( $next_link ) {
				echo '<div class="cell shrink align-right push-right text-right">';
				next_posts_link( $pagenavi_options[ 'next_text' ], $max_page );
				echo '</div>';
			} else {
				echo '<div class="cell shrink align-right push-right text-right"><a href="#" class="icon-link flex-disabled">' . $pagenavi_options[ 'next_text' ] . '</a></a></div>';	
			};

			echo $after . "\n";
		}
	}
}