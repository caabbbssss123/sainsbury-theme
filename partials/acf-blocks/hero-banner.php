<?php

/**
 * Hero Banner
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$heading = get_field('heading');
$content_copy = get_field('content_copy');
$cta_button = get_field('cta_button');
$image = get_field('image');
$background_image = get_field('background_image');

$cta_url = $cta_button ? $cta_button['url'] : '';
$cta_title = $cta_button ? $cta_button['title'] : '';
$cta_target = ($cta_button && $cta_button['target']) ? $cta_button['target'] : '_self';

$image_src = $image ? wp_get_attachment_image_src($image, 'large') : false;
$image_alt = $image ? get_post_meta($image, '_wp_attachment_image_alt', true) : '';

$background_image_src = $background_image ? wp_get_attachment_image_src($background_image, 'xlarge') : false;

?>
<section id="row-<?php echo $blockID; ?>" class="hero-banner" <?php if ($background_image_src) echo ' style="background-image: url(' . $background_image_src[0] . ');"'; ?>>
	<div class="container">
		<div class="row">
			<div class="col col-left">
				<?php if ($heading) : ?>
					<h1 class="hero-banner__heading"><?php echo $heading; ?></h1>
				<?php endif; ?>
				<?php if ($content_copy) : ?>
					<div class="hero-banner__content-copy">
						<?php echo nl2br($content_copy); ?>
					</div>
				<?php endif; ?>
				<?php if ($cta_button) : ?>
					<?php get_template_part('partials/components/component-button', null, array(
						'url'     => $cta_url,
						'title'   => $cta_title,
						'target'  => $cta_target,
						'classes' => 'btn btn-primary',
						'arrow'   => true,
					)); ?>
				<?php endif; ?>
			</div>
			<div class="col col-right">
				<?php if ($image_src) : ?>
					<img class="hero-banner__image" src="<?php echo $image_src[0]; ?>" alt="<?php echo $image_alt; ?>">
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>