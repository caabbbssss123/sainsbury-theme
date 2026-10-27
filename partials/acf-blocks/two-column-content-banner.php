<?php

/**
 * Two Column Content Banner
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$block_background_colour = get_field('block_background_colour');
$eyebrow_heading = get_field('eyebrow_heading');
$block_heading = get_field('block_heading');
$body_copy = get_field('body_copy');

$section_classes = 'two-column-content-banner';
if ($block_background_colour) {
	$section_classes .= ' two-column-content-banner--' . $block_background_colour;
}

$scroll_targets = array(
	'about us' => 'about',
	'why us' => 'why-us',
);
$eyebrow_key = strtolower(trim(wp_strip_all_tags($eyebrow_heading)));
$scroll_id = isset($scroll_targets[$eyebrow_key]) ? $scroll_targets[$eyebrow_key] : '';
$scroll_attribute = $scroll_id ? ' data-scroll="#' . esc_attr($scroll_id) . '"' : '';

?>
<section id="row-<?php echo $blockID; ?>" class="<?php echo esc_attr($section_classes); ?>"<?php echo $scroll_attribute; ?>>
	<div class="inner-wrapper">
		<div class="container">
			<?php if ($eyebrow_heading) : ?>
				<h3 class="two-column-content-banner__eyebrow-heading"><?php echo $eyebrow_heading; ?></h3>
			<?php endif; ?>
			<div class="row">
				<div class="col-lg-6 col-left">
					<?php if ($block_heading) : ?>
						<h2 class="two-column-content-banner__block-heading"><?php echo $block_heading; ?></h2>
					<?php endif; ?>
				</div>
				<div class="col-lg-6 col-right">
					<?php if ($body_copy) : ?>
						<div class="body-copy">
							<?php echo wpautop($body_copy); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
