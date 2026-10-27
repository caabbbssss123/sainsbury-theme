<?php // Gallery Row
global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$full_width				= get_sub_field('full_width');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
$gallery_display		= get_sub_field('gallery_display');
$gallery_type			= get_sub_field('gallery_type');
$gallery_badge			= get_sub_field('gallery_badge');
$gallery				= get_sub_field('gallery');
$centered_slider		= get_sub_field('centered_slider');
$loop_slider			= get_sub_field('loop_slider');
$slider_size			= get_sub_field('slider_size');
$variable_image_sizes	= get_sub_field('variable_image_sizes');
$full_width_section		= get_sub_field('full_width_section');
$controls_position		= get_sub_field('controls_position');
$variable_images		= false;
$count_gallery			= count($gallery);
$row_content			= get_sub_field('row_content');
$show_row_content		= get_sub_field('show_row_content');
$content_position   	= get_sub_field('content_position');

if ($gallery_display == 'slider' && $gallery_type == 'image' && $variable_image_sizes) {
	$variable_images	= true;
}

$title_element			= ($i == 1) ? 'h1' : 'h2';

$title_padding			= 'content-area padding-top-x0';
//if (
//	($row_title && $title_size == 'h1' && !$show_row_content) || 
//	($row_title && $title_size == 'h1' && $show_row_content && $content_position == 'below') ||
//	($row_title && $title_size == 'h2' && !$show_row_content) || 
//	($row_title && $title_size == 'h2' && $show_row_content && $content_position == 'below')
//) {
//	$title_padding		= 'padding-bottom-x2';
//}

switch($gallery_type) {
	case 'image':
		$grid_classes	= 'medium-up-3 large-up-3 grid-x--xsmall';
		break;
	case 'video':
		$grid_classes	= 'medium-up-2';
		break;
}
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php if (!$full_width_section) echo $row_padding; ?> background-<?php echo $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<div class="grid-container<?php if ($full_width_section) echo ' full';?>">
		<div class="grid-x align-center text-center<?php if ($gallery_badge) echo ' position_relative'; ?>">
			<div class="cell">	
				<?php
				if ($row_title) echo '
				<div class="' . $title_padding . '">
					<' . $title_element . ' class="' . $title_size . ' fix_line_height text-uppercase">' . $row_title . '</' . $title_element . '>
				</div>';
					
				if ($show_row_content && $content_position == 'above' && $row_content) echo do_shortcode('<div class="content-area padding-top-x0 wysiwyg"><div class="grid-x align-center"><div class="cell large-10 xlarge-7">' . $row_content . '</div></div></div>');

				if (have_rows('gallery')) :
				
				// Open display tags
				if ($gallery_display == 'slider') : ?>
				<?php 
						/**
						 * SWIPER SLIDER OPTIONS
						 *
						 * Flexslider variables:
						 * data-effect | fade or slide | default fade
						 * data-autoplay | 1 or 0
						 * data-autoplayDelay | integer 0 to any number in ms eg 5000
						 * data-pauseOnMouseEnter | 0 or 1
						 * data-speed | integer 0 to any number in ms eg 1000
						 * data-spaceBetween | integer 0 to any number in px
						 * data-slidesPerView
						 * data-centeredSlide | true 
						 * data-loop | true 
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

				<div class="swiper<?php if ($full_width == 1) echo ' swiper--overflow';?> js-swiper<?php if ($count_gallery <= 1) echo ' swiper--hide-controls'; ?>" data-effect="slide" data-autoplay="1" data-autoplayDelay="3000" data-pauseOnMouseEnter="1" data-speed="1000" data-spaceBetween="30" data-slidesPerView="<?php echo $slider_size; ?>" <?php if ($centered_slider	== "true") echo ' data-centeredSlides="true"';?> <?php if ($count_gallery > 2 && $loop_slider	== "true") echo ' data-loop="true"';?>>
    			<div class="swiper-wrapper grid-x grid-padding-y align-middle" >
				<?php elseif ($gallery_display == 'grid') : ?>
				<div class="grid-x grid-padding-x grid-padding-y<?php if ($count_gallery > 1) echo ' ' . $grid_classes; ?>">
				<?php endif;
						
					while ( have_rows( 'gallery' ) ): the_row();
					
					$_image				= wp_get_attachment_image_src( get_sub_field( 'image' ), 'medium' );
					$_image_xlarge		= wp_get_attachment_image_src( get_sub_field( 'image' ), 'large' );
					$_image_zoom		= wp_get_attachment_image_src( get_sub_field( 'image' ), 'fancybox' );
					$_image_alt_text	= get_post_meta( get_sub_field( 'image' ), '_wp_attachment_image_alt', true );
					$_caption			= wp_get_attachment_caption( get_sub_field( 'image' ) );
					$_image_size		= get_sub_field('image_size');
					$_video_type		= get_sub_field('video_type');
					$_vimeo_id			= get_sub_field('vimeo_id');
					$_youtube_id		= get_sub_field('youtube_id');
					//$_title				= get_sub_field('title');
					//$_description		= get_sub_field('description');
					
					$slide_classes		= '';
					$figure_classes		= '';
					
					if ($variable_images) {
						switch($_image_size) {
							case 'portrait':
								$slide_classes = 'small-6 medium-4';
								$figure_classes = '';
								break;
							case 'landscape':
								$slide_classes = 'small-10 medium-6';
								$figure_classes = 'content-area padding-top-x0';
								break;
							case 'square':
								$slide_classes = 'small-8 medium-4';
								$figure_classes = 'content-area padding-top-x0';
								break;
							case 'portrait_round':
								$slide_classes = 'small-8 medium-4';
								$figure_classes = '';
								break;								
						}
						
						if ($_image_size == 'portrait') {
							$_image_size = 'portrait';
						}
						if ($_image_size == 'portrait_round') {
							$_image_size = 'portrait--tall round-top';
						}
						if ($_image_size == 'landscape' && !$variable_images) {
							$_image_size = 'landscape-short';
						}						
					}
					
					if ($gallery_display == 'slider') : ?>
					<div class="swiper-slide cell <?php echo $slide_classes; ?>">
					<?php elseif ($gallery_display == 'grid') : ?>
					<div class="cell">
					<?php endif; 
						
						if ($gallery_type == 'image' && $_image) : ?>
						
						<figure class="height_100 <?php echo $figure_classes; ?>">
							<?php if ($variable_image_sizes) : ?>
							<a href="<?php echo $_image_zoom[0]; ?>" class="tile-link height_100" data-fancybox="gallery-<?php echo $i; ?>"<?php if ($_caption) echo ' data-caption="' . $_caption . '"'; ?>>
							<?php elseif (!$variable_image_sizes) : ?>
							<a class="tile-link height_100 no-zoom" <?php if ($_caption) echo ' data-caption="' . $_caption . '"'; ?>>	
							<?php endif; ?>
								<span class="tile-link__image-container set-size set-size--ratio set-size--limit-height set-size--<?php echo ($variable_images) ? $_image_size : 'landscape-short'; ?> <?php if (!$variable_images) echo ' height_100'; ?>">
									<span class="set-size__image background-image" style="background-image:url(<?php echo ($count_gallery == 1 || $gallery_display == 'slider') ? $_image_xlarge[0] : $_image[0]; ?>)">
										<img src="<?php echo ($count_gallery == 1 || $gallery_display == 'slider') ? $_image_xlarge[0] : $_image[0]; ?>" alt="<?php echo ($_image_alt_text) ? $_image_alt_text : 'Gallery image'; ?>">
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
					<?php elseif ($gallery_display == 'grid') : ?>
					</div>
					<?php endif;
						
					endwhile;
				
				// Close display tags
				if ($gallery_display == 'slider') : ?>
				</div>
				
				<?php if (!$variable_images && $count_gallery > 1 && $slider_size == '1') : ?>
				<div class="swiper-pagination <?php if ($controls_position == "bottom") echo ' padding-top-half position_relative';?>"></div>
				<?php endif; ?>
				</div>
				
				<?php if ($slider_size != '1' && $count_gallery > 1) : ?>
					<div class="swiper-direction-nav padding-bottom">
						<div class="grid-x grid-padding-x align-right">
							<div class="cell shrink padding-right-x0">
								<a href="#" class="swiper-prev color-tertiary link-icon"><i class="fa-light fa-sharp fa-arrow-left"></i></a>
							</div>
							<div class="cell shrink">
								<a href="#" class="swiper-next color-tertiary link-icon"><i class="fa-light fa-sharp fa-arrow-right"></i></a>
							</div>
						</div>
					</div>
				<?php endif; ?>	
			
				<?php elseif ($gallery_display == 'grid') : ?>
				</div>
				
				<?php endif; 
				
				endif; // if (have_rows('gallery')) :
			
				if ($show_row_content && $content_position == 'below' && $row_content) echo do_shortcode('<div class="content-area padding-bottom-x0 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');
				?>
			</div>
			<?php if ($gallery_badge) : 
				
				$_url		= $gallery_badge['url'];
				$_title		= $gallery_badge['title'];
				$_alt_text	= $gallery_badge['alt'];
				$_alt		= $_alt_text ? $_alt_text : 'Gallery badge';
				$_caption	= $gallery_badge['caption'];
			
			?>
			<div class="cell large-shrink small-5 gallery-badge">
				<img src="<?php echo $_url; ?>" alt="<?php echo $_alt; ?>" class="rotate-continuously--disabled ">
			</div>
			<?php endif; ?>
			
		</div>
	</div>
</section>