<?php
/**
 * The template for displaying 404 pages.
 */

get_header(); ?>

	<section class="content-area-x2">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell">
					<h1><?php _e( 'Not Found', 'sainsbury' ); ?></h1>
					<div class="grid-x grid-padding-x">
						<div class="cell large-10 xlarge-8">
							<p><?php _e( 'Apologies, but the page you requested could not be found.', 'sainsbury' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>