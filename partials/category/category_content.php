<?php // Category Archive Content

global $background_colour, $tile_colour, $taxonomy, $post_type;
?>
<section id="posts-container" class="content-area-x2 background-<?php echo $background_colour; ?>">
	<div class="grid-container">
		<div class="grid-x align-center">
			<div class="cell">
				<?php
				/*
				 * Posts
				 */
				$args = array(
					'post_type'				=> $post_type,
					'post_status'			=> 'publish',
					'posts_per_page'		=> 12,
					'tax_query' 			=> array(
							array(
								'taxonomy' 	=> $taxonomy->taxonomy,
								'field'    	=> 'slug',
								'terms'    	=> $taxonomy->slug
							)
					),
					'ignore_sticky_posts'	=> true,
					'paged'					=> $paged
				);
				$wp_query = new WP_Query( $args );

				if ($wp_query->have_posts()):					

					echo '<div class="grid-x grid-padding-x medium-up-2 large-up-3 negative-top-margin-x2">';

						while ($wp_query->have_posts() ): $wp_query->the_post();

							echo '<div class="cell padding-top-x2">';

								get_template_part('partials/post_tiles/' . $post_type, '', array('tile-colour' => $tile_colour));

							echo '</div>';

						endwhile;

					echo '</div>';

				else :

					echo '<div class="text-center"><p>Apologies, but there are no posts to display.</p></div>';

				endif;
				
				if ( $wp_query->max_num_pages > 1 ) :
				?>
				<div class="content-area padding-bottom-x0 text-center">
					<div class="grid-x align-center align-middle">
						<div class="cell">
							<nav class="pagination boxed-content background-<?php echo $tile_colour; ?>">
								<?php 
								if (function_exists('pagenavi')) {
									pagenavi('<div class="grid-x align-middle">', '</div>');
								};
								?>
							</nav>
						</div>
					</div>
				</div>
				<?php
				endif;
				
				wp_reset_query();
				?>
			</div>
		</div>
	</div>
</section>