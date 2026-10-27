<?php // Post Tile

$tile_colour		= (isset($args['tile-colour'])) ? $args['tile-colour'] : 'grey';

$post_title			= get_the_title();
$post_date			= get_the_date('F j, Y');
$iso_post_date		= get_the_date('c');
$image				= wp_get_attachment_image_src( get_field( 'featured_image', get_the_ID() )[ 0 ][ 'image' ], 'medium' );
$alt_text			= get_post_meta( get_field( 'featured_image', get_the_ID() )[ 0 ][ 'image' ], '_wp_attachment_image_alt', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(sanitize_title($post_title) . ' grid-x height_100 align-stretch flex-dir-column background-' . $tile_colour); ?>>
	<?php if ($image) : ?>
	<div class="cell flex-child-shrink"> 
		<figure>
			<a class="tile-link" href="<?php the_permalink(); ?>">
				<span class="tile-link__image-container set-size set-size--landscape">
					<span class="set-size__image background-image" style="background-image:url('<?php echo $image[0]; ?>');">
						<img src="<?php echo $image[0]; ?>" alt="<?php echo ($alt_text) ? $alt_text : $post_title . ' image'; ?>">
					</span>
				</span>
			</a>
		</figure>
	</div>
	<?php endif; ?>
	<div class="cell flex-child-grow boxed-content">
		<div class="grid-x height_100">
			<div class="cell">
				<h3 class="h5"><?php
					echo '<time datetime="' . $iso_post_date . '" itemprop="date-published"><i class="fal fa-calendar-alt"></i>&emsp;' . $post_date . '</time>';
					echo $post_title;
				?></h3>
			</div>
			<div class="cell align-self-bottom padding-top">
				<a class="btn btn--primary" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>
			</div>
		</div>
	</div>
</article>