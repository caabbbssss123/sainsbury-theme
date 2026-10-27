<?php // Content Row: Two Columns
global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$background_image		= get_sub_field('background_image');
$boxed_content			= get_sub_field('boxed_content');
$box_background_colour	= get_sub_field('box_background_colour');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
$left_column_content	= get_sub_field('left_column_content');
$right_column_content	= get_sub_field('right_column_content');

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
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php if (!$background_image) echo $row_padding . ' background-' . $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<?php
	if ($background_image) echo '<div class="' . $row_padding . ' background-' . $background_colour . ' position_relative">';
	?>
	<div class="grid-container position_relative">
		<div class="grid-x align-center">
			<div class="cell">
				<?php if ($boxed_content) : ?>
				<div class="boxed-content large-boxed-content-x2 background-<?php echo $box_background_colour; ?>">
				<?php endif; ?>
				
				<?php
				if ($row_title) echo '<' . $title_element . ' class="' . $title_size . '">' . $row_title . '</' . $title_element . '>';

				if ($left_column_content || $right_column_content) : ?>
				<div class="grid-x grid-padding-x grid-padding-y wysiwyg">
					<div class="cell large-6">
                        <div class="grid-x">
                            <div class="cell">
						        <?php if ($left_column_content) echo do_shortcode($left_column_content); ?>
                            </div>
                        </div>
					</div>
					<div class="cell large-6">
                         <div class="grid-x">
                            <div class="cell">
						        <?php if ($right_column_content) echo do_shortcode($right_column_content); ?>
                            </div>
                        </div>
					</div>
				</div>
				<?php
                endif;
                
                if( have_rows('row_buttons') ): ?>
                <div class="padding-top-x2">
                    <div class="grid-x grid-x--small grid-padding-x grid-padding-y">
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