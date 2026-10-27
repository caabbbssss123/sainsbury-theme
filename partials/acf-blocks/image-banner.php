<?php

/**
 * Image Banner
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$image = get_field('image');
$image_src = $image ? wp_get_attachment_image_src($image, 'xlarge') : false;
$image_alt = $image ? get_post_meta($image, '_wp_attachment_image_alt', true) : '';

?>
<section id="row-<?php echo $blockID; ?>" class="image-banner">
	<?php if ($image_src) : ?>
		<img class="image-banner__image" src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
	<?php endif; ?>
</section>
