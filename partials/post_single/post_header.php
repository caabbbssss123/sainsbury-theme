<?php // Single Post Heading 

$post_date			= get_the_date('F j, Y');
$iso_post_date		= get_the_date('c');
?>
<header class="content-area padding-bottom-x0 position_relative">
	<div class="content-area position_relative">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell">
					<div class="grid-x align-center text-center">
						<div class="cell xxlarge-10">
							<h1 class="h2 no-margin"><?php the_title(); ?></h1>
							<p><time datetime="<?php echo $iso_post_date; ?>" itemprop="date-published"><i class="fal fa-calendar-alt"></i>&emsp;<?php echo $post_date; ?></time></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>