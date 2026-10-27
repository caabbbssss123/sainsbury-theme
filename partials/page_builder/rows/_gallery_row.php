<?php // Gallery Row
global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
$gallery_display		= get_sub_field('gallery_display');
$gallery_type			= get_sub_field('gallery_type');
$gallery				= get_sub_field('gallery');
$count_gallery			= count($gallery);
$row_content			= get_sub_field('row_content');
$show_row_content		= get_sub_field('show_row_content');
$content_position   	= get_sub_field('content_position');

$title_element			= ($i == 1) ? 'h1' : 'h2';

$title_padding			= 'padding-bottom';
if (
	($row_title && $title_size == 'h1' && !$show_row_content) || 
	($row_title && $title_size == 'h1' && $show_row_content && $content_position == 'below') ||
	($row_title && $title_size == 'h2' && !$show_row_content) || 
	($row_title && $title_size == 'h2' && $show_row_content && $content_position == 'below')
) {
	$title_padding		= 'padding-bottom-x2';
}

switch($gallery_type) {
	case 'image':
		$grid_classes	= 'medium-up-3 large-up-3 grid-x--xsmall';
		break;
	case 'video':
		$grid_classes	= 'medium-up-2';
		break;
}
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php echo $row_padding; ?> background-<?php echo $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<div class="grid-container">
		<div class="grid-x align-center">
			<div class="cell">	
				<?php
				if ($row_title) echo '
				<div class="' . $title_padding . '">
					<' . $title_element . ' class="' . $title_size . ' fix_line_height">' . $row_title . '</' . $title_element . '>
				</div>';
					
				if ($show_row_content && $content_position == 'above' && $row_content) echo do_shortcode('<div class="padding-bottom-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');

				if (have_rows('gallery')) :
				
				// Open display tags
				if ($gallery_display == 'slider') : ?>
				<?php 
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
				<?php /*<div class="flexslider<?php if ($count_gallery <= 1) echo ' flexslider--hide-controls'; ?>" data-controlNav="false" data-directionNav="true"<?php if ($gallery_type == 'video') echo ' data-slideshow="false"'; ?>> */ ?>
				<div class="swiper swiper--overflow js-swiper <?php if ($count_gallery <= 1) echo ' swiper--hide-controls'; ?>" data-centerSlides="false" data-effect="fade" data-autoplay="0" data-autoplayDelay="5000" data-pauseOnMouseEnter="1" data-speed="1000" data-spaceBetween="1.5" data-slidesPerView="1.4" data-loop="true">
				<div class="swiper-wrapper grid-x grid-padding-x grid-padding-y align-middle" >
				<?php elseif ($gallery_display == 'grid') : ?>
				<div class="grid-x grid-padding-x grid-padding-y<?php if ($count_gallery > 1) echo ' ' . $grid_classes; ?>">
				<?php endif;
						
					while ( have_rows( 'gallery' ) ): the_row();
					
					$_image				= wp_get_attachment_image_src( get_sub_field( 'image' ), 'medium' );
					$_image_xlarge		= wp_get_attachment_image_src( get_sub_field( 'image' ), 'large' );
					$_image_zoom		= wp_get_attachment_image_src( get_sub_field( 'image' ), 'fancybox' );
					$_image_alt_text	= get_post_meta( get_sub_field( 'image' ), '_wp_attachment_image_alt', true );
					$_caption			= wp_get_attachment_caption( get_sub_field( 'image' ) );
					$_video_type		= get_sub_field('video_type');
					$_vimeo_id			= get_sub_field('vimeo_id');
					$_youtube_id		= get_sub_field('youtube_id');
					$_title				= get_sub_field('title');
					$_description		= get_sub_field('description');
					
					if ($gallery_display == 'slider') : ?>
					<div class="swiper-slide cell <?php //echo $slide_classes; ?>">
						<div class="grid-x height_100">
						<?php elseif ($gallery_display == 'grid') : ?>
						<div class="cell">
						<?php endif; 

							if ($gallery_type == 'image' && $_image) : ?>

							<figure class="height_100">
								<a class="tile-link height_100 no-zoom" href="<?php echo $_image_zoom[0]; ?>" class="tile-link" data-fancybox="gallery-<?php echo $i; ?>"<?php if ($_caption) echo ' data-caption="' . $_caption . '"'; ?>>
									<span class="tile-link__image-container set-size set-size--landscape">
										<span class="set-size__image background-image" style="background-image:url(<?php echo ($count_gallery == 1 || $gallery_display == 'slider') ? $_image_xlarge[0] : $_image[0]; ?>)">
											<img src="<?php echo ($count_gallery == 1 || $gallery_display == 'slider') ? $_image_xlarge[0] : $_image[0]; ?>" alt="<?php echo ($_image_alt_text) ? $_image_alt_text : $_title; ?>">
										</span>
									</span>
								</a>
								<?php if ($_caption) echo '<figcaption>' . $_caption . '</figcaption>'; ?>
							</figure>
							<?php
							elseif ($gallery_type == 'video') :

							if ($_video_type == 'vimeo') : ?>
							<script type="text/javascript">
								var bodyStyles		= window.getComputedStyle(document.body),
									colorPrimary	= bodyStyles.getPropertyValue('--vimeo-controls-color'),
									cleanColor		= colorPrimary.replace(' #', '');

								document.write('<iframe src="https://player.vimeo.com/video/<?php echo $_vimeo_id; ?>?api=1&amp;color=' + cleanColor + '&amp;player_id=video1&amp;autoplay=false" frameborder="0" allow="fullscreen" allowfullscreen></iframe>');
							</script>
							<?php elseif ($_video_type == 'youtube') : ?>
							<iframe src="https://www.youtube.com/embed/<?php echo $_youtube_id; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
							<?php 
							endif;

							endif; 

						if ($gallery_display == 'slider') : ?>
						</div>
						</div>
					<?php elseif ($gallery_display == 'grid') : ?>
					</div>
					<?php endif;
						
					endwhile;
				
				// Close display tags
				if ($gallery_display == 'slider') : ?>
				</div>
				</div>
				<?php elseif ($gallery_display == 'grid') : ?>
				</div>
				<?php endif; 
				
				endif; // if (have_rows('gallery')) :
			
				if ($show_row_content && $content_position == 'below' && $row_content) echo do_shortcode('<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');
				?>
			</div>
		</div>
	</div>
</section>