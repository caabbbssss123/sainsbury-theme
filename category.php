<?php
/**
 * Category Page
 *
 * @package WordPress
 * @subpackage sainsbury
 * @since Sainsbury 3.0
 */

$taxonomy	= get_queried_object();

get_template_part('partials/category/category_data');

get_header(); ?>

	<article <?php post_class(sanitize_title($taxonomy->name)); ?>>

		<?php 
		get_template_part('partials/category/category_header');

		get_template_part('partials/category/category_content');
		?>

	</article>

<?php get_footer(); ?>