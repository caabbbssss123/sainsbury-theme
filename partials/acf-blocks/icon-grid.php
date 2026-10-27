<?php

/**
 * Icon Grid
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$heading = get_field('heading');
$items = get_field('items');

?>
<section id="row-<?php echo $blockID; ?>" class="icon-grid" data-scroll="#services">
	<div class="container">
		<?php if ($heading) : ?>
			<h2 class="icon-grid__heading"><?php echo esc_html($heading); ?></h2>
		<?php endif; ?>
		<?php if ($items) : ?>
			<div class="icon-grid__grid" role="tablist">
				<?php foreach ($items as $index => $item) :
					$icon = isset($item['icon']) ? $item['icon'] : '';
					$text = isset($item['text']) ? $item['text'] : '';
					$icon_src = $icon ? wp_get_attachment_image_src($icon, 'full') : false;
					$is_active = (0 === $index);
				?>
					<button type="button" class="icon-grid__item<?php echo $is_active ? ' is-active' : ''; ?>" id="icon-grid-tab-<?php echo esc_attr($blockID . '-' . $index); ?>" role="tab" aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>" aria-controls="icon-grid-panel-<?php echo esc_attr($blockID . '-' . $index); ?>" tabindex="<?php echo $is_active ? '0' : '-1'; ?>">
						<?php if ($icon_src) : ?>
							<span class="icon-grid__icon" style="--icon-url: url('<?php echo esc_url($icon_src[0]); ?>');" aria-hidden="true"></span>
						<?php endif; ?>
						<?php if ($text) : ?>
							<div class="icon-grid__text">
								<?php echo wpautop($text); ?>
							</div>
						<?php endif; ?>
					</button>
				<?php endforeach; ?>
			</div>
			<div class="icon-grid__panels">
				<?php foreach ($items as $index => $item) :
					$content_heading = isset($item['content_heading']) ? $item['content_heading'] : '';
					$content_starter_copy = isset($item['content_starter_copy']) ? $item['content_starter_copy'] : '';
					$content_image = !empty($item['content_image']) ? $item['content_image'] : null;
					$content_left_heading = isset($item['content_left_heading']) ? $item['content_left_heading'] : '';
					$content_left_copy = isset($item['content_left_copy']) ? $item['content_left_copy'] : '';
					$content_right_heading = isset($item['content_right_heading']) ? $item['content_right_heading'] : '';
					$content_right_copy = isset($item['content_right_copy']) ? $item['content_right_copy'] : '';
					$content_cta = !empty($item['content_cta']) ? $item['content_cta'] : null;
					$is_active = (0 === $index);
				?>
					<div class="icon-grid__panel" id="icon-grid-panel-<?php echo esc_attr($blockID . '-' . $index); ?>" role="tabpanel" aria-labelledby="icon-grid-tab-<?php echo esc_attr($blockID . '-' . $index); ?>" <?php echo $is_active ? '' : 'hidden'; ?>>
						<?php if ($content_heading || $content_starter_copy || $content_image) : ?>
						<div class="icon-grid__panel-row icon-grid__panel-row--intro">
							<div class="icon-grid__panel-col">
								<?php if ($content_heading) : ?>
									<h3 class="icon-grid__content-heading"><?php echo esc_html($content_heading); ?></h3>
								<?php endif; ?>
								<?php if ($content_starter_copy) : ?>
									<div class="icon-grid__content-copy">
										<?php echo wpautop($content_starter_copy); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="icon-grid__panel-col">
								<?php if ($content_image) : ?>
									<img class="icon-grid__content-image" src="<?php echo esc_url($content_image['url']); ?>" alt="<?php echo esc_attr($content_image['alt']); ?>">
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if ($content_left_heading || $content_left_copy || $content_right_heading || $content_right_copy || $content_cta) : ?>
						<div class="icon-grid__panel-row icon-grid__panel-row--detail">
							<div class="icon-grid__panel-col">
								<?php if ($content_left_heading) : ?>
									<h4 class="icon-grid__content-subheading"><?php echo esc_html($content_left_heading); ?></h4>
								<?php endif; ?>
								<?php if ($content_left_copy) : ?>
									<div class="icon-grid__content-copy">
										<?php echo wpautop($content_left_copy); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="icon-grid__panel-col">
								<?php if ($content_right_heading) : ?>
									<h4 class="icon-grid__content-subheading"><?php echo esc_html($content_right_heading); ?></h4>
								<?php endif; ?>
								<?php if ($content_right_copy) : ?>
									<div class="icon-grid__content-copy">
										<?php echo wpautop($content_right_copy); ?>
									</div>
								<?php endif; ?>
								<?php if ($content_cta) : ?>
									<?php get_template_part('partials/components/component-button', null, array(
										'url'     => $content_cta['url'],
										'title'   => $content_cta['title'],
										'target'  => !empty($content_cta['target']) ? $content_cta['target'] : '_self',
										'classes' => 'btn btn-primary',
										'arrow'   => true,
									)); ?>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
