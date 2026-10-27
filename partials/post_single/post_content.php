<?php // Single Post Content
global $post_title;

$featured_image = get_field('featured_image');
$slide_count = is_array($featured_image) ? count($featured_image) : 0;

if ( have_rows('featured_image') ): ?>
<div class="content-area padding-top-x0">
	<div class="flexslider<?php if ($slide_count <= 1) echo ' flexslider--hide-controls'; ?>" data-controlNav="false" data-directionNav="true">
		<ul class="slides">
			<?php
			while ( have_rows( 'featured_image' ) ): the_row();
			$image = wp_get_attachment_image_src( get_sub_field( 'image' ), 'medium' );
			$alt_text = get_post_meta( get_sub_field( 'image' ), '_wp_attachment_image_alt', true );
			$caption	= wp_get_attachment_caption( get_sub_field( 'image' ) );
			?>
			<li>
				<figure>
					<div class="set-size set-size--landscape">
						<div class="set-size__image"<?php if ($image) echo ' style="background-image:url(' . $image[0] . ')"'; ?>>
							<img src="<?php echo $image[0]; ?>" alt="<?php echo ($alt_text) ? $alt_text : $post_title . ' image'; ?>">
						</div>
					</div>
					<?php if ($caption) echo '<figcaption>' . $caption . '</figcaption>'; ?>
				</figure>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>
<?php endif; ?>

<div class="wysiwyg">
<?php the_content(); ?>
</div>