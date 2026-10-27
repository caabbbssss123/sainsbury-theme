<?php

/**
 * Two Column Media and Text Slider
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockID = $block['id'];

$slides = get_field('slides');

$left_arrow_path = get_theme_file_path('assets/img/svg/left-arrow.svg');
$right_arrow_path = get_theme_file_path('assets/img/svg/right-arrow.svg');
$left_arrow = ($left_arrow_path && file_exists($left_arrow_path)) ? preg_replace('/<\?xml[^>]*\?>/', '', file_get_contents($left_arrow_path)) : '';
$right_arrow = ($right_arrow_path && file_exists($right_arrow_path)) ? preg_replace('/<\?xml[^>]*\?>/', '', file_get_contents($right_arrow_path)) : '';
?>

<section id="row-<?php echo $blockID; ?>" class="two-column-media-and-text-slider">
  <div class="swiper two-column-media-and-text-slider__carousel">
    <?php if ($slides) : ?>
      <div class="swiper-wrapper">
        <?php foreach ($slides as $slide) :
          $eyebrow_heading = $slide['eyebrow_heading'];
          $heading = $slide['heading'];
          $body_copy = $slide['body_copy'];
          $image = $slide['image'];

          $image_src = $image ? wp_get_attachment_image_src($image, 'large') : false;
          $image_alt = $image ? get_post_meta($image, '_wp_attachment_image_alt', true) : '';
        ?>
          <div class="swiper-slide two-column-media-and-text-slider__slide">
            <div class="row">
              <div class="col-lg-6 col-content">
                <?php if ($eyebrow_heading) : ?>
                  <h3 class="two-column-media-and-text-slider__eyebrow-heading"><?php echo $eyebrow_heading; ?></h3>
                <?php endif; ?>

                <?php if ($heading) : ?>
                  <h2 class="two-column-media-and-text-slider__heading"><?php echo $heading; ?></h2>
                <?php endif; ?>

                <?php if ($body_copy) : ?>
                  <div class="two-column-media-and-text-slider__body-copy">
                    <?php echo wpautop($body_copy); ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-lg-6 col-media">
                <?php if ($image_src) : ?>
                  <img class="two-column-media-and-text-slider__image" src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($slides) : ?>
    <div class="two-column-media-and-text-slider__nav-frame">
      <div class="row">
        <div class="col-lg-6 col-content"></div>
        <div class="col-lg-6 col-media">
          <div class="two-column-media-and-text-slider__nav">
            <button type="button" class="two-column-media-and-text-slider__arrow two-column-media-and-text-slider__arrow--prev" aria-label="Previous slide">
              <?php echo $left_arrow; ?>
            </button>
            <button type="button" class="two-column-media-and-text-slider__arrow two-column-media-and-text-slider__arrow--next" aria-label="Next slide">
              <?php echo $right_arrow; ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>
