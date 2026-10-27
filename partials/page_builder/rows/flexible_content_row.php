<?php // Flexible Content Row
global $i, $page_title;

$row_type						= get_row_layout();
$background_colour				= get_sub_field('background_colour');
$row_padding					= get_sub_field('row_padding');
$row_title						= get_sub_field('row_title');
$title_size						= get_sub_field('title_size');
$flexible_content_display		= get_sub_field('flexible_content_display');
$flexible_content_image			= get_sub_field('flexible_content_image');
$flexible_content_title_size	= get_sub_field('flexible_content_title_size');
$boxed_content					= get_sub_field('boxed_content');
$slider_size					= get_sub_field('slider_size');
$grid_size						= get_sub_field('grid_size');
$flexible_content				= get_sub_field('flexible_content');
$count_content					= count($flexible_content);
$row_content					= get_sub_field('row_content');
$show_row_content				= get_sub_field('show_row_content');
$content_position   			= get_sub_field('content_position');

$title_element					= ($i == 1) ? 'h1' : 'h2';

$title_padding					= 'padding-bottom';
if (
	($row_title && $title_size == 'h1' && !$show_row_content) || 
	($row_title && $title_size == 'h1' && $show_row_content && $content_position == 'below') ||
	($row_title && $title_size == 'h2' && !$show_row_content) || 
	($row_title && $title_size == 'h2' && $show_row_content && $content_position == 'below')
) {
	$title_padding				= 'padding-bottom-x2';
}

switch($grid_size) {
	case 'small':
		$grid_classes			= 'medium-up-2 large-up-3';
		break;
	case 'large':
		$grid_classes			= 'medium-up-2';
		break;
}
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php echo $row_padding; ?> background-<?php echo $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<div class="grid-container">
		<div class="grid-x align-center">
			<div class="cell position_relative">						
				<?php if ($flexible_content_display == 'slider' && $count_content > 1) : ?>
				<div class="slider-functions <?php echo $title_padding; ?>">
					<div class="grid-x grid-padding-x grid-padding-y align-middle">
						<?php
						if ($row_title) echo '
						<div class="cell medium-auto">
							<' . $title_element . ' class="' . $title_size . ' fix_line_height">' . $row_title . '</' . $title_element . '>
						</div>';
						?>
						<?php /*<div class="cell shrink<?php if (empty($row_title)) echo ' push-right'; ?>">
							<div class="slider-controls">
								<ul class="custom-direction-nav">
									<li><a href="#" class="flex-prev"><span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span></a></li>
									<li><a href="#" class="flex-next"><span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span></a></li>
								</ul>
							</div>
						</div> */ ?>
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
					</div>
				</div>
				
				<?php
				else : 
				
					if ($row_title) echo '
					<div class="' . $title_padding . '">
						<' . $title_element . ' class="' . $title_size . ' fix_line_height">' . $row_title . '</' . $title_element . '>
					</div>';
				
				endif;
				
				if ($show_row_content && $content_position == 'above' && $row_content) echo do_shortcode('<div class="padding-bottom-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');

				if (have_rows('flexible_content')) :
				
				// Open display tags
				if ($flexible_content_display == 'slider') :
				
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
						 * data-slidesPerView | integer 1,2,3
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
				<div class="swiper _swiper--overflow js-swiper<?php if ($count_content <= 1) echo ' swiper--hide-controls'; ?>" data-effect="slide" data-centerSlides="false" data-autoplay="0" data-autoplayDelay="5000" data-pauseOnMouseEnter="1" data-speed="1000" data-spaceBetween="30" data-slidesPerView="3" _data-loop="false">
				<div class="swiper-wrapper grid-x grid-padding-x grid-padding-y align-middle" >
				<?php elseif ($flexible_content_display == 'grid' && $boxed_content) : ?>
				<div class="grid-x grid-padding-x grid-padding-y<?php if ($count_content > 1) echo ' ' . $grid_classes; ?>">
				<?php elseif ($flexible_content_display == 'grid' && !$boxed_content) : ?>
				<div class="grid-x grid-padding-x <?php if ($count_content > 1) echo ' ' . $grid_classes; ?> negative-top-margin-x2">
				<?php endif;
						
					while ( have_rows( 'flexible_content' ) ): the_row();
					$_box_background_colour		= get_sub_field('box_background_colour');
					
					if ($boxed_content) {
						switch ($_box_background_colour) {
							case 'primary':
								$_button_colour		= 'white';
								break;
							case 'highlight':
								$_button_colour		= 'primary';
								break;
							default:
								$_button_colour		= 'primary';
						}
					} else {
						switch ($background_colour) {
							case 'black':
							case 'primary':
							case 'secondary':
							case 'tertiary':
								$_button_colour		= 'white';
								break;
							default:
								$_button_colour		= 'primary';
						}
					}
					
					$_portrait_image			= wp_get_attachment_image_src( get_sub_field( 'portrait_image' ), 'portrait' );
					$_portrait_image_alt_text	= get_post_meta( get_sub_field( 'portrait_image' ), '_wp_attachment_image_alt', true );
					$_landscape_image			= wp_get_attachment_image_src( get_sub_field( 'landscape_image' ), 'medium' );
					$_landscape_image_alt_text	= get_post_meta( get_sub_field( 'landscape_image' ), '_wp_attachment_image_alt', true );
					
					$_icon						= get_sub_field('icon');
					$_icon_type					= $_icon['icon_type'];
					$_icon_image				= wp_get_attachment_image_src( $_icon['image'], 'full' );
					$_icon_image_alt_text		= get_post_meta( $_icon['image'], '_wp_attachment_image_alt', true );
					$_icon_font_awesome			= $_icon['font_awesome'];
					
					$_title						= get_sub_field('title');
					$_content					= get_sub_field('content');
					
					if ($flexible_content_display == 'slider') : ?>
					<div class="swiper-slide cell<?php //echo $slide_classes; ?>">
					<div class="slide-content height_100">
					<?php elseif ($flexible_content_display == 'grid' && $boxed_content) : ?>
					<div class="cell">
					<?php elseif ($flexible_content_display == 'grid' && !$boxed_content) : ?>
					<div class="cell padding-top-x2">
					<?php endif; ?>
						
						<?php if ($boxed_content && $flexible_content_image == 'none' || $boxed_content && $flexible_content_image == 'icon') : ?>
						<div class="boxed-content <?php
									if ($flexible_content_display == 'grid' && $grid_size == 'large' || $flexible_content_display == 'slider' && $slider_size == 'large' || $count_content == 1) {
										echo ' content-area-x2';
									} elseif ($flexible_content_display == 'grid' && $grid_size == 'small' || $flexible_content_display == 'slider' && $slider_size == 'small' || $flexible_content_image == 'icon' || $count_content == 1) {
										echo ' content-area';
									} ?> background-<?php echo $_box_background_colour; ?> height_100">
						<?php endif; ?>
						
						<div class="grid-x height_100 align-stretch flex-dir-column<?php if ($boxed_content) echo ' background-' . $_box_background_colour; ?>">
							<?php if ($flexible_content_image != 'none') : ?>
							<div class="cell flex-child-shrink">
								<figure>
									<?php if ($flexible_content_image == 'portrait') : ?>
									<span class="tile-link__image-container set-size set-size--portrait set-size--portrait--short">
										<span class="set-size__image background-image" style="background-image:url(<?php echo $_portrait_image[0]; ?>)">
											<img src="<?php echo $_portrait_image[0]; ?>" alt="<?php echo ($_portrait_image_alt_text) ? $_portrait_image_alt_text : $_title . ' image'; ?>">
										</span>
									</span>
									<?php elseif ($flexible_content_image == 'landscape') : ?>
									<span class="tile-link__image-container set-size set-size--landscape">
										<span class="set-size__image background-image" style="background-image:url(<?php echo $_landscape_image[0]; ?>)">
											<img src="<?php echo $_landscape_image[0]; ?>" alt="<?php echo ($_landscape_image_alt_text) ? $_landscape_image_alt_text : $_title . ' image'; ?>">
										</span>
									</span>
									<?php elseif ($flexible_content_image == 'icon') : ?>
										
										<?php if ($_icon_type == 'image' && $_icon_image) : ?>
										<img src="<?php echo $_icon_image[0]; ?>" class="icon icon--80" alt="<?php echo ($_icon_image_alt_text) ? $_icon_image_alt_text : $_title . ' icon'; ?>">
										<?php elseif ($_icon_type == 'font-awesome' && $_icon_font_awesome) : ?>
										<span class="<?php echo $flexible_content_title_size; ?>"><?php echo $_icon_font_awesome; ?></span>
										<?php endif; ?>
										
									<?php endif; ?>
								</figure>
							</div> 
							<?php endif; ?>
							
							<?php if ($boxed_content && $flexible_content_image == 'landscape' || $boxed_content && $flexible_content_image == 'portrait') : ?>
							<div class="cell flex-child-grow boxed-content">
							<?php else : ?>
							<div class="cell flex-child-grow<?php if ($flexible_content_image != 'none') echo ' padding-top'; ?>">	
							<?php endif; ?>
								<div class="grid-x height_100">
									<div class="cell">
										<h3 class="<?php echo $flexible_content_title_size; ?>"><?php echo $_title; ?></h3>
										<?php if ($_content) : ?>
										<div class="grid-x">
											<div class="cell<?php if ($count_content == 1) echo ' large-10 xlarge-8'; if ($count_content >= 2 && !$boxed_content) echo ' medium-11'; ?> wysiwyg">
												<?php echo do_shortcode($_content); ?>
											</div>
										</div>
										<?php endif; ?>
									</div>
									<?php if ( have_rows('buttons') ): ?>
									<div class="cell align-self-bottom padding-top<?php if ($_content) echo ' padding-top-x2'; ?>">
										<div class="grid-x grid-x--small grid-padding-x grid-padding-y">
											<?php
											while ( have_rows( 'buttons' ) ): the_row();
											$_button			= get_sub_field('button');
											$_button_url		= $_button['url'];
											$_button_title		= $_button['title'];
											$_button_target		= $_button['target'] ? $_button['target'] : '_self';
											?>
											<div class="cell<?php if ($count_content == 1 || $grid_size != 'small' || $slider_size != 'small') echo ' shrink'; ?>">
												<a class="btn btn--<?php echo $_button_colour; ?>" href="<?php echo esc_url( $_button_url ); ?>" target="<?php echo esc_attr( $_button_target ); ?>"><?php echo esc_html( $_button_title ); ?></a>
											</div>
											<?php endwhile; ?>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
							
						<?php if ($boxed_content && $flexible_content_image == 'none' || $boxed_content && $flexible_content_image == 'icon') : ?>
						</div>
						<?php endif; ?>
						
					<?php if ($flexible_content_display == 'slider') : ?>
					</div>
					</div>
					<?php elseif ($flexible_content_display == 'grid') : ?>
					</div>
					<?php endif;
						
					endwhile;
				
				// Close display tags
				if ($flexible_content_display == 'slider') : ?>
				</div>
				</div>
				<div class="swiper-pagination"></div>
				<?php elseif ($flexible_content_display == 'grid') : ?>
				</div>
				<?php endif; 
				
				endif; // if (have_rows('flexible_content')) :
				
				if ($show_row_content && $content_position == 'below' && $row_content) echo do_shortcode('<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');				
				?>
			</div>
		</div>
	</div>
</section>