<?php // Page Banner
global $page_title, $first_background;

while( have_rows('page_banner') ): the_row();

$banner_images	= get_sub_field('banner_images');
$banner_content	= get_sub_field('banner_content');
$banner_buttons	= get_sub_field('banner_buttons');
$banner_video	= get_sub_field('banner_video');
?>
<header class="banner-row<?php echo ($banner_images || $banner_video) ? ' color-white' : ' background-' . $first_background; ?> position_relative">
	<div class="content-area-x2 position_relative">
		<div class="grid-container">
			<div class="grid-x">
				<div class="cell">
					<div class="grid-x">
						<div class="cell xxlarge-10">
							<h1 class="<?php if ($banner_images || $banner_video) echo ' color-white'; ?> fix_line_height"><?php the_title(); ?></h1>
						</div>
					</div>
					<?php 
					if ($banner_content) echo '<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . coord_wpautop($banner_content, 'size-h6') . '</div></div></div>';

					if( have_rows('banner_buttons') ): ?>
					<div class="padding-top-x2">
						<div class="grid-x grid-x--small grid-padding-x grid-padding-y">
							<?php
							while ( have_rows( 'banner_buttons' ) ): the_row();
							$button_type	= get_sub_field('button_type');
							$button			= get_sub_field('button');
							$link_url		= $button['url'];
							$link_title		= $button['title'];
							$link_target	= $button['target'] ? $button['target'] : '_self';
							$button_text	= get_sub_field('button_text');
							$video_url		= get_sub_field('video_url');

							if ($button_type == 'default') :
							?>
							<div class="cell shrink">
								<a class="btn <?php echo ($banner_images || $banner_video) ? 'btn--white' : 'btn--highlight'; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
							</div>
							<?php
							elseif ($button_type == 'video') :
							?>
							<div class="cell shrink">
								<a class="btn <?php echo ($banner_images || $banner_video) ? 'btn--white' : 'btn--highlight'; ?>" href="<?php echo esc_url( $video_url ); ?>" data-fancybox="banner"><?php echo esc_html( $button_text ); ?></a>
							</div>
							<?php
							endif;
							endwhile;
							?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php 
	if ($banner_video) : ?>
	<div class="banner-row__video background-image background-image--overlay">
		 <video class="js-banner-video" preload="auto" autoplay loop muted playsinline controlsList="nodownload">
			<source src="<?php echo $banner_video; ?>" type="video/mp4">
		</video>
	</div>
	<?php
	else :
	
	if( have_rows('banner_images') ): ?>
	<div class="background-slider flexslider" data-controlNav="false" data-pauseOnHover="false" data-slideshowSpeed="5000">
		<ul class="slides height_100">
			<?php while( have_rows('banner_images') ): the_row(); 
			$image	= wp_get_attachment_image_src(get_sub_field('image'), 'large');
			?>
			<li class="background-image background-image--overlay height_100"<?php if ($image) echo ' style="background-image:url(' . $image[0] . ')"'; ?>></li>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php
	endif;
	
	endif;
	?>
</header>
<?php
endwhile;
?>