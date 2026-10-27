<?php

/**
 * Button
 *
 * @param array $args {
 *     @type string $url     Link URL.
 *     @type string $title   Link text.
 *     @type string $target  Link target. Default _self.
 *     @type string $classes CSS classes.
 *     @type bool   $arrow   Show the arrow icon. Default false.
 *     @type array  $attributes Extra HTML attributes keyed by attribute name.
 * }
 */
$args    = isset($args) ? $args : array();
$url     = isset($args['url']) ? $args['url'] : '';
$title   = isset($args['title']) ? $args['title'] : '';
$target  = !empty($args['target']) ? $args['target'] : '_self';
$classes = isset($args['classes']) ? $args['classes'] : 'btn';
$arrow   = !empty($args['arrow']);
$attributes = (isset($args['attributes']) && is_array($args['attributes'])) ? $args['attributes'] : array();

if (!$url) {
	return;
}

if ($arrow && !preg_match('/(^|\s)btn-arrow(\s|$)/', $classes)) {
	$classes .= ' btn-arrow';
}

?>
<a class="<?php echo esc_attr(trim($classes)); ?>" href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>"<?php foreach ($attributes as $attribute => $value) : ?> <?php echo esc_attr($attribute); ?>="<?php echo esc_attr($value); ?>"<?php endforeach; ?>>
	<span class="btn-text">
		<?php echo esc_html($title); ?>
	</span>
	<?php if ($arrow) : ?>
		<?php get_template_part('partials/components/component-button-icon'); ?>
	<?php endif; ?>
</a>
