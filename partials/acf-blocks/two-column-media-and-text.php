<?php

/**
 * Two Column Media and Text
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$image_position = get_field('image_position') ?: 'left';
$heading = get_field('heading');
$body_copy = get_field('body_copy');
$cta_button = get_field('cta_button');
$image = get_field('image');

$cta_url = $cta_button ? $cta_button['url'] : '';
$cta_title = $cta_button ? $cta_button['title'] : '';
$cta_target = ($cta_button && $cta_button['target']) ? $cta_button['target'] : '_self';

$image_src = $image ? wp_get_attachment_image_src($image, 'large') : false;
$image_alt = $image ? get_post_meta($image, '_wp_attachment_image_alt', true) : '';

$section_classes = 'two-column-media-and-text two-column-media-and-text--image-' . $image_position;

?>
<section id="row-<?php echo $blockID; ?>" class="<?php echo esc_attr($section_classes); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-content">
				<?php if ($heading) : ?>
					<h2 class="two-column-media-and-text__heading"><?php echo $heading; ?></h2>
				<?php endif; ?>
				<?php if ($body_copy) : ?>
					<div class="two-column-media-and-text__body-copy">
						<?php echo wpautop($body_copy); ?>
					</div>
				<?php endif; ?>
				<?php if ($cta_button) : ?>
					<?php get_template_part('partials/components/component-button', null, array(
						'url'     => $cta_url,
						'title'   => $cta_title,
						'target'  => $cta_target,
						'classes' => 'btn btn-secondary',
						'arrow'   => true,
					)); ?>
				<?php endif; ?>
			</div>
			<div class="col-lg-6 col-media">
				<?php if ($image_src) : ?>
					<img class="two-column-media-and-text__image" src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
