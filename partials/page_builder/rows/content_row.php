<?php // Content Row

global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$media_type				= get_sub_field('media_type');
$media_position			= get_sub_field('media_position');
$background_image		= get_sub_field('background_image');
$boxed_content			= get_sub_field('boxed_content');
$box_background_colour	= get_sub_field('box_background_colour');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
$row_content			= get_sub_field('row_content');
$image_size				= get_sub_field('image_size');
$row_images				= get_sub_field('row_images');
$count_row_images		= count($row_images);
$video_type				= get_sub_field('video_type');
$vimeo_id				= get_sub_field('vimeo_id');
$youtube_id				= get_sub_field('youtube_id');

if ($media_type == 'image')
	$slide_count		= count($row_images);

if ($background_image)
	$background_colour	= 'black';

$title_element			= ($i == 1) ? 'h1' : 'h2';

if ($boxed_content) {
	switch ($box_background_colour) {
		case 'black':
		case 'primary':
		case 'secondary':
		case 'tertiary':
			$button_colour	= 'white';
			break;
		default:
			$button_colour	= 'primary';
	}
} else {
	switch ($background_colour) {
		case 'black':
		case 'primary':
		case 'secondary':
		case 'tertiary':
			$button_colour	= 'white';
			break;
		default:
			$button_colour	= 'primary';
	}
}

switch ($image_size) {
	case 'landscape' :
		$set_size	= 'landscape';
		break;
	case 'portrait' :
		$set_size	= 'landscape large-set-size--portrait';
		break;
	case 'square' :
		$set_size	= 'square';
		break;
}
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php if (!$background_image) echo $row_padding . ' background-' . $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<?php
	if ($background_image) echo '<div class="' . $row_padding . ' background-' . $background_colour . ' position_relative">';
	?>
	<div class="grid-container position_relative">
		<div class="grid-x align-center">
			<div class="cell">
				<?php
				if ($boxed_content) echo '<div class="background-' . $box_background_colour . '">'; 
				?>	
				<div class="grid-x<?php if (!$boxed_content) echo ' grid-padding-x grid-padding-y align-middle'; ?> align-center<?php if ($media_position == 'right') echo ' large-flex-dir-row-reverse'; ?>">
					<div class="cell large-6">
						<?php 
						if ( $media_type == 'image' && have_rows('row_images') ):
						
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
						<div class="swiper swiper--overflow js-swiper<?php if ($count_row_images <= 1) echo ' swiper--hide-controls'; ?>" data-effect="fade" data-centerSlides="false" data-autoplay="1" data-autoplayDelay="5000" data-pauseOnMouseEnter="1" data-speed="1000" data-spaceBetween="1.5" data-slidesPerView="1.4" _data-loop="true">
							<div class="swiper-wrapper grid-x grid-padding-x grid-padding-y align-middle" >
								<?php
								while ( have_rows( 'row_images' ) ): the_row();
								
								switch ($image_size) {
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
								<div class="swiper-slide cell <?php //echo $slide_classes; ?>">
										<?php
										if ($image_size == 'full') :
										?>
										<figure>
											<img src="<?php echo $_image[0]; ?>" alt="<?php echo ($_alt_text) ? $_alt_text : $page_title . ' image'; ?>">
											<?php if ($_caption) echo '<figcaption>' . $_caption . '</figcaption>'; ?>
										</figure>
										<?php
										else :
										?>
										<figure class="height_100">
											<div class="set-size set-size--<?php echo $set_size; ?> height_100">
												<div class="set-size__image"<?php if ($_image) echo ' style="background-image:url(' . $_image[0] . ')"'; ?>>
													<img src="<?php echo $_image[0]; ?>" alt="<?php echo ($_alt_text) ? $_alt_text : $page_title . ' image'; ?>">
												</div>
											</div>
											<?php if ($_caption) echo '<figcaption>' . $_caption . '</figcaption>'; ?>
										</figure>
										<?php
										endif;
										?>
								</div>
								<?php endwhile; ?>
							</div>
							<div class="swiper-pagination"></div>
						</div>
						<?php /* CUSTOM SLIDER CONTROLS
						<div class="slider-controls padding-top">
							<ul class="custom-direction-nav">
								<li><a href="#" class="flex-prev"><span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span></a></li>
								<li><a href="#" class="flex-next"><span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span></a></li>
							</ul>
						</div>
						*/ ?>
						<?php elseif ( $media_type == 'video') :
							if ($video_type == 'vimeo') : ?>
								<script type="text/javascript">
									var bodyStyles		= window.getComputedStyle(document.body),
										colorPrimary	= bodyStyles.getPropertyValue('--vimeo-controls-color'),
										cleanColor		= colorPrimary.replace(' #', '');

									document.write('<iframe src="https://player.vimeo.com/video/<?php echo $vimeo_id; ?>?api=1&amp;color=' + cleanColor + '&amp;player_id=video1&amp;autoplay=false" frameborder="0" allow="fullscreen" allowfullscreen></iframe>');
								</script>
								<?php elseif ($video_type == 'youtube') : ?>
								<iframe src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
								<?php 
							endif;
						endif; ?>
					</div>
					<div class="cell large-6">
                        <div class="grid-x align-middle height_100">
                            <div class="cell<?php if (!$boxed_content) echo ' xlarge-11'; if (!$boxed_content && $media_position == 'left') echo ' xlarge-offset-1'; ?>">
								<?php
								if ($boxed_content) echo '<div class="boxed-content large-boxed-content-x2">'; 
									
								if ($row_title) echo '<' . $title_element . ' class="' . $title_size . '">' . $row_title . '</' . $title_element . '>';

								if ($row_content) echo do_shortcode('<div class="wysiwyg">' . $row_content . '</div>');

								if( have_rows('row_buttons') ): ?>
								<div class="<?php if ($row_content) echo 'padding-top-x2'; ?>">
									<div class="grid-x grid-x--small grid-padding-x grid-padding-y">
										<?php
										while ( have_rows( 'row_buttons' ) ): the_row();
										$button			= get_sub_field('button');
										$link_url		= $button['url'];
										$link_title		= $button['title'];
										$link_target	= $button['target'] ? $button['target'] : '_self';
										?>
										<div class="cell shrink">
											<a class="btn btn--<?php echo $button_colour; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
										</div>
										<?php endwhile; ?>
									</div>
								</div>
								<?php
								endif;
									
								if ($boxed_content) echo '</div>';
								?>
                            </div>
                        </div>
					</div>
				</div>
				<?php
				if ($boxed_content) echo '</div>';
				?>
			</div>
		</div>
	</div>
	<?php 
	if ($background_image && have_rows('background_images') ) :
	?>
	<div class="background-slider flexslider" data-controlNav="false" data-pauseOnHover="false" data-slideshowSpeed="5000">
		<ul class="slides height_100">
			<?php while( have_rows('background_images') ): the_row(); 
			$_image	= wp_get_attachment_image_src(get_sub_field('image'), 'large');
			?>
			<li class="background-image background-image--overlay<?php if (!$boxed_content) echo ' background-image--overlay--dark'; ?> height_100"<?php if ($_image) echo ' style="background-image:url(' . $_image[0] . ')"'; ?>></li>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php
	endif;
	
	if ($background_image) echo '</div>';
	?>
</section>