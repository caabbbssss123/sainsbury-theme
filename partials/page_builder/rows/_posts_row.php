<?php // Posts Row
global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
$post_display			= get_sub_field('post_display');
$grid_size				= get_sub_field('grid_size');
$slider_size			= get_sub_field('slider_size');
$post_type				= get_sub_field('post_type');
$select_category		= get_sub_field('select_category');
$post_categories		= get_sub_field('post_categories');
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

switch($grid_size) {
	case 'small':
		$grid_classes	= 'medium-up-2 large-up-3';
		break;
	case 'large':
		$grid_classes	= 'medium-up-2';
		break;
}

$posts_per_page			= 6;
if ($post_display == 'grid' && $grid_size == 'large') {
	$posts_per_page		= 2;
} elseif ($post_display == 'grid' && $grid_size == 'small') {
	$posts_per_page		= 3;
}

$args = array(
	'post_type'				=> $post_type,
	'post_status'			=> 'publish',
	'posts_per_page'		=> $posts_per_page,
	'ignore_sticky_posts'	=> true
);

if ($select_category) {
	
	$query_categories		= array();
	foreach ($post_categories as $post_category) {
		$query_categories[]	= $post_category->slug;
	}
	
	if ($post_type == 'post') {
		$args['tax_query'][]	= array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $query_categories,
			)
		);
	}
}

$posts_query = new WP_Query( $args );

if ($posts_query->have_posts()) :
$post_count = $posts_query->found_posts; 
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php echo $row_padding; ?> background-<?php echo $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<div class="grid-container">
		<div class="grid-x align-center">
			<div class="cell">	
				<?php if ($post_display == 'slider' && $post_count > 1) : ?>
				<div class="slider-functions <?php echo $title_padding; ?>">
					<div class="grid-x grid-padding-x grid-padding-y align-middle">
						<?php
						if ($row_title) echo '
						<div class="cell medium-auto">
							<' . $title_element . ' class="' . $title_size . ' fix_line_height">' . $row_title . '</' . $title_element . '>
						</div>';
						?>
						<div class="cell shrink<?php if (empty($row_title)) echo ' push-right'; ?>">
							<div class="slider-controls">
								<ul class="custom-direction-nav">
									<li><a href="#" class="flex-prev"><span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span></a></li>
									<li><a href="#" class="flex-next"><span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span></a></li>
								</ul>
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
				
				// Open display tags
				if ($post_display == 'slider') :
				/**
				 * FLEXSLIDER OPTIONS
				 *
				 * Flexslider variables:
				 * data-animation | fade or slide | default fade
				 * data-controlNav | true or false | default true
				 * data-directionNav | true or false | default false | if using custom controls set to true
				 * data-animationLoop | true or false | default true
				 * data-pauseOnAction | true or false | default true
				 * data-pauseOnHover | true or false | default true
				 * data-startAt | integer | default 0
				 * data-slideshow | true or false | default true
				 * data-slideshowSpeed | time | default 7500
				 * data-animationSpeed | time | default 1000
				 * data-columnSlider | small or large | no default | slides multiple slides | largeColumnSize and smallColumnSize control how many slides are visible | changes animation to slide
				 *
				 * Control Position Classes:
				 * .flexslider--paging-offset | move the paging nav below the slider
				 * .flexslider--paging-left & flexslider--paging-right | control the alignment of the paging nav
				 * .flexslider--directional-offset | move the directional nav below the slider
				 * .flexslider--overflow | make inactive slides visible | data-animation must be set to "slide"
				 * .flexslider--force-columns | add space between slides | data-animation must be set to "slide" and "flexslider--overflow" must be added
				 */
				?>
				<div class="flexslider <?php if ($post_count <= 1) echo ' flexslider--hide-controls'; ?>" data-controlNav="false" data-directionNav="true" data-animationLoop="false" data-slideshow="false" data-columnSlider="<?php echo $slider_size; ?>">
				<ul class="slides">
				<?php elseif ($post_display == 'grid') : ?>
				<div class="grid-x grid-padding-x grid-padding-y <?php if ($post_count > 1) echo ' ' . $grid_classes; ?>">
				<?php
				endif;
					
				$_p = 0; while ($posts_query->have_posts() ): $posts_query->the_post(); $_p++;

					if ($post_display == 'slider') :
					?>
					<li>
					<div class="slide-content height_100">
					<?php
					elseif ($post_display == 'grid') :
						
					switch($_p) {
						case 3:
							$_cell_classes	= 'show-for-large';
							break;
						case 2:
							$_cell_classes	= 'show-for-medium';
							break;
						default:
							$_cell_classes	= '';
					}
					?>
					<div class="cell <?php echo $_cell_classes; ?>">
					<?php
					endif;
					
					get_template_part('partials/post_tiles/' . $post_type);


					if ($post_display == 'slider') :
					?>
					</div>
					</li>
					<?php
					elseif ($post_display == 'grid') :
					?>
					</div>
					<?php
					endif;

				endwhile;
				
				// Close display tags
				if ($post_display == 'slider') : ?>
				</ul>
				</div>
				<?php elseif ($post_display == 'grid') : ?>
				</div>
				<?php endif; 
				
				if ($show_row_content && $content_position == 'below' && $row_content) echo do_shortcode('<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');
				?>
			</div>
		</div>
	</div>
</section>
<?php
endif;
wp_reset_query();
?>