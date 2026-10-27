<?php

/**
 * Two Column Boxed Content
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$columns = array(
	get_field('left_column') ?: array(),
	get_field('right_column') ?: array(),
);

?>
<section id="row-<?php echo $blockID; ?>" class="two-column-boxed-content">
	<div class="container container-large">
		<div class="two-column-boxed-content__box">
			<div class="row">
				<?php foreach ($columns as $column) :
					$heading = isset($column['heading']) ? $column['heading'] : '';
					$body_copy = isset($column['body_copy']) ? $column['body_copy'] : '';
					$cta_button = !empty($column['cta_button']) ? $column['cta_button'] : null;
					$cta_url = $cta_button ? $cta_button['url'] : '';
					$cta_title = $cta_button ? $cta_button['title'] : '';
					$cta_target = ($cta_button && !empty($cta_button['target'])) ? $cta_button['target'] : '_self';
				?>
					<div class="col-lg-6">
						<?php if ($heading) : ?>
							<h2 class="two-column-boxed-content__heading"><?php echo esc_html($heading); ?></h2>
						<?php endif; ?>
						<?php if ($body_copy) : ?>
							<div class="two-column-boxed-content__body-copy">
								<?php echo wpautop($body_copy); ?>
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
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
