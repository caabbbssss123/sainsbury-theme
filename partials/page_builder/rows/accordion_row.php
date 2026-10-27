<?php // Accordion Row
global $i, $page_title;

$row_type				= get_row_layout();
$background_colour		= get_sub_field('background_colour');
$row_padding			= get_sub_field('row_padding');
$boxed_content			= get_sub_field('boxed_content');
$box_background_colour	= get_sub_field('box_background_colour');
$row_title				= get_sub_field('row_title');
$title_size				= get_sub_field('title_size');
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

$box_background			= ($box_background_colour == 'highlight') ? 'highlight' : 'white';
										
if ($background_colour == 'white' && $box_background_colour == 'default') {
	$box_background		= 'grey';
}
if ($background_colour == 'highlight' && $box_background_colour == 'highlight') {
	$box_background		= 'primary';
}
?>
<section id="<?php echo ($row_title) ? sanitize_title($row_title) : 'row-' . $i; ?>" class="<?php echo $row_padding; ?> background-<?php echo $background_colour; ?>" data-row-type="<?php echo $row_type; ?>" data-row-index="row_<?php echo $i; ?>">
	<div class="grid-container">
		<div class="grid-x align-center">
			<div class="cell">
				<div class="grid-x grid-padding-x grid-padding-y">
					<div class="cell">
						<?php if ($boxed_content) : ?>
						<div class="boxed-content content-area background-<?php echo $box_background; ?>">
						<?php endif; ?>
					
						<?php
						if ($row_title) echo '
						<div class="' . $title_padding . '">
							<' . $title_element . ' class="' . $title_size . ' fix_line_height">' . $row_title . '</' . $title_element . '>
						</div>';
						
						if ($show_row_content && $content_position == 'above' && $row_content) echo do_shortcode('<div class="padding-bottom-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');
						
						if( have_rows('accordion') ): ?>
						<div class="accordion">
							<?php
							while ( have_rows( 'accordion' ) ): the_row();
							$_panel_title	= get_sub_field('panel_title');
							$_panel_content	= get_sub_field('panel_content');
							?>
							<div id="<?php echo sanitize_title($_panel_title); ?>" class="accordion__panel accordion__panel--closed">
								<div class="panel__title">
									<a href="#" class="panel__title__link h5"><?php
										echo $_panel_title;
										?><span class="title__link__icon link-icon"></span>
									</a>
								</div>
								<div class="panel__content boxed-content">
									<div class="grid-x">
										<div class="cell large-10 xlarge-8 wysiwyg">
											<?php if ($_panel_content) echo do_shortcode($_panel_content); ?>
										</div>
									</div>
								</div>
							</div>
							<?php endwhile; ?>
						</div>
						<?php 
						endif;
						
						if ($show_row_content && $content_position == 'below' && $row_content) echo do_shortcode('<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . $row_content . '</div></div></div>');
                        ?>
							
						<?php if ($boxed_content) : ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
