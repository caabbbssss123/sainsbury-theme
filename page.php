<?php
/**
 * The template for displaying all pages.
 */

get_header();

$page_title = get_the_title();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(sanitize_title($page_title)); ?>>
	<?php the_content(); ?>
</article>

<?php get_footer();