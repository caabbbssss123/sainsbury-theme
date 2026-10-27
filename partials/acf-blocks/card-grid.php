<?php

/**
 * Card Grid
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$heading = get_field('heading');

?>
<section id="row-<?php echo $blockID; ?>" class="card-grid" data-scroll="#team">
  <div class="container">
    <?php if ($heading) : ?>
			<h2 class="card-grid__heading"><?php echo esc_html($heading); ?></h2>
		<?php endif; ?>
    <?php if (have_rows('items')) : ?>
      <div class="row">
        <?php $item_index = 0; ?>
        <?php while (have_rows('items')) : the_row();
          $item_index++;
          $name = get_sub_field('name');
          $position = get_sub_field('position');
          $thumbnail_image = get_sub_field('thumbnail_image');
          $large_image = get_sub_field('large_image');
          $biography = get_sub_field('biography');

          $large_image_src = $large_image ? wp_get_attachment_image_src($large_image, 'portrait') : false;
          $large_image_alt = $large_image ? get_post_meta($large_image, '_wp_attachment_image_alt', true) : '';

          $popup_id = 'card-grid-popup-' . $blockID . '-' . $item_index;
        ?>
          <div class="col-md-6 col-lg-4 card-grid__item">
            <div class="card-grid__item-inner">
              <div class="card-grid__item-thumbnail-wrapper">
                <?php if ($thumbnail_image) : ?>
                  <img src="<?php echo esc_url($thumbnail_image); ?>" class="card-grid__item-thumbnail-image" alt="<?php echo esc_attr($name); ?>">
                <?php endif; ?>
              </div>
              <div class="card-grid__item-content">
                <?php if ($name) : ?>
                  <h3><?php echo esc_html($name); ?></h3>
                <?php endif; ?>
                <?php if ($position) : ?>
                  <p><?php echo esc_html($position); ?></p>
                <?php endif; ?>
                <?php get_template_part('partials/components/component-button', null, array(
                  'url'     => '#',
                  'title'   => 'Read More',
                  'target'  => '',
                  'classes' => 'btn btn-simple card-grid__item-trigger',
                  'arrow'   => true,
                  'attributes' => array(
                    'data-popup'     => '#' . $popup_id,
                    'aria-haspopup'  => 'dialog',
                  ),
                )); ?>
              </div>
            </div>
            <div id="<?php echo esc_attr($popup_id); ?>" class="card-grid__popup" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr($name); ?>" hidden>
              <div class="card-grid__popup-overlay" data-popup-close></div>
              <div class="card-grid__popup-dialog">
                <button type="button" class="card-grid__popup-close" data-popup-close>
                  <span class="visually-hidden">Close</span>
                </button>
                <div class="row">
                  <div class="col card-grid__popup-content">
                    <?php if ($name) : ?>
                      <h3 class="card-grid__popup-name"><?php echo esc_html($name); ?></h3>
                    <?php endif; ?>
                    <?php if ($position) : ?>
                      <p class="card-grid__popup-position"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                    <?php if ($biography) : ?>
                      <div class="card-grid__popup-biography">
                        <?php echo wpautop($biography); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="col card-grid__popup-media">
                    <?php if ($large_image_src) : ?>
                      <img class="card-grid__popup-image" src="<?php echo esc_url($large_image_src[0]); ?>" alt="<?php echo esc_attr($large_image_alt ?: $name); ?>">
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
