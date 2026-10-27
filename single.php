<?php
/**
 * The template for displaying all posts.
 */

get_header();

if (post_password_required()) :

	get_template_part('partials/password_protected/password_form');

else :

	if ( have_posts() ) while ( have_posts() ) : the_post();
	$post_type			= get_post_type();
	$post_title			= get_the_title();
	$background_colour	= 'white';

	switch($background_colour) {
		case 'white':
			$tile_colour	= 'grey';
			break;
		default:
			$tile_colour	= 'white';
	}
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('background-' . $background_colour); ?>>
		<div class="js-ajax-content">
		
			<?php get_template_part('partials/post_single/post_header'); ?>

			<section class="content-area-x2 padding-top-x0">
				<div class="grid-container">
					<div class="grid-x align-center">
						<div class="cell xlarge-10 xxlarge-8">

							<?php
							
							get_template_part('partials/post_single/post_content');
							
							get_template_part('partials/post_single/post_navigation');
							
							?>
							
						</div>
					</div>
				</div>
			</section>
		
		</div>
	</article>

	<?php 
	endwhile;

endif;

get_footer();
?>