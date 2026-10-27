<?php 
if (have_rows('row_images') ):

/**
 * SWIPER SLIDER OPTIONS
 *
 * Flexslider variables:
 * data-effect | fade or slide | default fade
 * data-centerSlides | true or false
 * data-autoplay | 1 or 0
 * data-autoplayDelay | integer 0 to any number in ms eg 5000
 * data-pauseOnMouseEnter | 0 or 1
 * data-speed | integer 0 to any number in ms eg 1000
 * data-spaceBetween | decimal 1.0  | eg 1.1 to 2.0
 * data-slidesPerView
 * data-loop | true or false
 * 
 **_ data-controlNav | true or false | default true
 **_ data-directionNav | true or false | default false | if using custom controls set to true
 **_ data-pauseOnHover | true or false | default true
 **_ data-slideshowSpeed | time | default 7500
 **_ data-animationSpeed | time | default 1000
 **_ data-columnSlider | small or large | no default | slides multiple slides | largeColumnSize and smallColumnSize control how many slides are visible | changes animation to slide
 **_
 **_ Control Position Classes:
 **_ .flexslider--paging-offset | move the paging nav below the slider
 **_ .flexslider--paging-left & flexslider--paging-right | control the alignment of the paging nav
 **_ .flexslider--directional-offset | move the directional nav below the slider
 **_ .flexslider--overflow | make inactive slides visible | data-animation must be set to "slide"
 **_ .flexslider--force-columns | add space between slides | data-animation must be set to "slide"
 */
?>
<div class="swiper swiper--overflow js-swiper<?php if ($args['count_row_images'] <= 1) echo ' swiper--hide-controls'; ?>" data-effect="fade" data-centerSlides="false" data-autoplay="1" data-autoplayDelay="5000" data-pauseOnMouseEnter="1" data-speed="1000" data-spaceBetween="1.5" data-slidesPerView="1.4" _data-loop="true">
	<div class="swiper-wrapper grid-x grid-padding-x grid-padding-y align-middle" >
		<?php
		while ( have_rows( 'row_images' ) ): the_row();
		
		switch (get_field('image_size')) {
			case 'landscape' :
				$_image 	= wp_get_attachment_image_src( get_sub_field( 'image' ), 'medium' );
				break;
			case 'portrait' :
				$_image 	= wp_get_attachment_image_src( get_sub_field( 'image' ), 'portrait' );
				break;
			case 'square' :
				$_image 	= wp_get_attachment_image_src( get_sub_field( 'image' ), 'thumbnail' );
				break;
			case 'full' :
				$_image 	= wp_get_attachment_image_src( get_sub_field( 'image' ), 'full' );
				break;
		}
		
		$_alt_text 	= get_post_meta( get_sub_field( 'image' ), '_wp_attachment_image_alt', true );
		$_caption	= wp_get_attachment_caption( get_sub_field( 'image' ) );
		?>

			<div class="swiper-slide cell">

				<?php if (get_field('image_size') == 'full') : ?>
					
					<figure>
						<img src="<?php echo $_image[0]; ?>" alt="<?php echo ($_alt_text) ? $_alt_text : $args['page_title'] . ' image'; ?>">
						<?php if ($_caption) echo '<figcaption>' . $_caption . '</figcaption>'; ?>
					</figure>

				<?php else: ?>

					<figure class="height_100">
						<div class="set-size set-size--<?php echo $args['set_size']; ?> height_100">
							<div class="set-size__image"<?php if ($_image) echo ' style="background-image:url(' . $_image[0] . ')"'; ?>>
								<img src="<?php echo $_image[0]; ?>" alt="<?php echo ($_alt_text) ? $_alt_text : $args['page_title'] . ' image'; ?>">
							</div>
						</div>
						<?php if ($_caption) echo '<figcaption>' . $_caption . '</figcaption>'; ?>
					</figure>

				<?php endif; ?>

			</div>

		<?php endwhile; ?>
	</div>
	<div class="swiper-pagination"></div>
</div>
<?php endif; ?>