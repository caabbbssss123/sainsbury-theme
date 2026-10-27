<?php // Single Post Navigation
global $post_type, $tile_colour;

$myquery = array(
	'post_status'		=> 'publish',
	'posts_per_page'	=> -1,
	'post_type'			=> $post_type,
);

$queryObject = new WP_Query($myquery); 

while( $queryObject->have_posts() ) : $queryObject->the_post();

$posts_array[] = $post->ID;

endwhile;

wp_reset_query();

$current = array_search($post->ID, $posts_array); // returns key
$prevID = (!empty($posts_array[$current - 1])) ? $posts_array[$current - 1] : null; // get value from key 1 before
$nextID = (!empty($posts_array[$current + 1])) ? $posts_array[$current + 1] : null; // get value from key 1 after
?>

<?php if ( !empty( $prevID ) || !empty( $nextID ) ) : ?>
<div class="content-area padding-bottom-x0">
	<nav class="pagination boxed-content background-<?php echo $tile_colour; ?>">
		<div class="grid-x align-justify align-middle">
			<?php if ( !empty( $prevID ) ) : ?>
			<div class="cell shrink">
				<a href="<?php echo get_permalink( $prevID ); ?>" class="icon-link">
					<span class="grid-x grid-x--small grid-padding-x grid-padding-y align-middle">
						<span class="cell shrink">
							<span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span>
						</span>
						<span class="cell shrink show-for-medium">
							<?php _e('Previous'); ?>
						</span>
					</span>
				</a>
			</div>
			<?php else : ?>
			<div class="cell shrink">
				<span class="icon-link flex-disabled">
					<span class="grid-x grid-x--small grid-padding-x grid-padding-y align-middle">
						<span class="cell shrink">
							<span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span>
						</span>
						<span class="cell shrink show-for-medium">
							<?php _e('Previous'); ?>
						</span>
					</span>
				</span>
			</div>
			<?php endif; ?>
			<?php if ( !empty( $nextID ) ) : ?>
			<div class="cell shrink">
				<a href="<?php echo get_permalink( $nextID ); ?>" class="icon-link">
					<span class="grid-x grid-x--small grid-padding-x grid-padding-y align-middle">
						<span class="cell shrink show-for-medium">
							<?php _e('Next'); ?>
						</span>
						<span class="cell shrink">
							<span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span>
						</span>
					</span>
				</a>
			</div>
			<?php else : ?>
			<div class="cell shrink">
				<span class="icon-link flex-disabled">
					<span class="grid-x grid-x--small grid-padding-x grid-padding-y align-middle">
						<span class="cell shrink show-for-medium">
							<?php _e('Next'); ?>
						</span>
						<span class="cell shrink">
							<span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span>
						</span>
					</span>
				</span>
			</div>
			<?php endif; ?>
		</div>
	</nav>
</div>
<?php endif; ?>