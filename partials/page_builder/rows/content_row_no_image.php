<?php // Content Row: No Image
global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$content_width			= get_sub_field('content_width');
$text_alignment			= get_sub_field('text_alignment');
$content_alignment		= get_sub_field('content_alignment');
$background_image		= get_sub_field('background_image');
$boxed_content			= get_sub_field('boxed_content');
$box_background_colour	= get_sub_field('box_background_colour');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
$row_content			= get_sub_field('row_content');

if ($background_image)
	$background_colour	= 'black';

$title_element			= ($i == 1) ? 'h1' : 'h2';

switch ($content_width) {
	case 'full':
		$cell_classes	= '';
		break;
	case 'slim':
		$cell_classes	= ' large-8 xlarge-6';
		break;
	default:
		$cell_classes	= ' large-10 xlarge-8';
}

switch ($content_alignment) {
	case 'centered':
		$grid_classes	= ' align-center';
		break;
	case 'right':
		$grid_classes	= ' align-right';
		break;
	default:
		$grid_classes	= '';
}

switch ($text_alignment) {
	case 'centered':
		$text_classes	= ' text-center';
		break;
	case 'right':
		$text_classes	= ' text-right';
		break;
	default:
		$text_classes	= '';
}

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
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php if (!$background_image) echo $row_padding . ' background-' . $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<?php
	if ($background_image) echo '<div class="' . $row_padding . ' background-' . $background_colour . ' position_relative">';
	?>
	<div class="grid-container position_relative">
		<div class="grid-x align-center">
			<div class="cell">
				<div class="grid-x grid-padding-x grid-padding-y <?php echo $grid_classes . ' ' . $text_classes; ?>">
					<div class="cell <?php echo $cell_classes; ?>">
						<?php if ($boxed_content) : ?>
						<div class="boxed-content large-boxed-content-x2 background-<?php echo $box_background_colour; ?>">
						<?php endif; ?>
					
						<?php
						if ($row_title) echo '<' . $title_element . ' class="' . $title_size . '">' . $row_title . '</' . $title_element . '>';
						
						if ($row_content) echo do_shortcode('<div class="wysiwyg">' . $row_content . '</div>');
                        
						if( have_rows('row_buttons') ): ?>
						<div class="<?php if ($row_content) echo 'padding-top-x2'; ?>">
							<div class="grid-x grid-x--small grid-padding-x grid-padding-y <?php echo $grid_classes; ?>">
								<?php
								while ( have_rows( 'row_buttons' ) ): the_row();
								$_button		= get_sub_field('button');
								$_link_url		= $_button['url'];
								$_link_title	= $_button['title'];
								$_link_target	= $_button['target'] ? $_button['target'] : '_self';
								?>
								<div class="cell shrink">
									<a class="btn btn--<?php echo $button_colour; ?>" href="<?php echo esc_url( $_link_url ); ?>" target="<?php echo esc_attr( $_link_target ); ?>"><?php echo esc_html( $_link_title ); ?></a>
								</div>
								<?php endwhile; ?>
							</div>
						</div>
						<?php endif; ?>
							
						<?php if ($boxed_content) : ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
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