<?php // Posts Template Header

global $background_colour;

$blog_page				= get_field('blog_page', 'option');
$page_content			= get_the_content();
$post_type				= get_field('post_type');
$show_category_select	= get_field('show_category_select');

switch($post_type) {
	case 'post':
		$taxonomy		= 'category';
		break;
	default:
		$taxonomy		= '';
}
?>
<header class="content-area-x2 background-<?php echo $background_colour; ?>">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="cell">
				<div class="grid-x">
					<div class="cell xxlarge-10">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
				<?php 
				if ($page_content) echo do_shortcode('<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . apply_filters('the_content', $page_content) . '</div></div></div>');

				if ($show_category_select) :
				
				$args = array(
				   'hierarchical'		=> 1,
				   'hide_empty'			=> 1,
				   'parent'				=> 0,
				   'taxonomy'			=> $taxonomy
				 );
				$categories = get_categories($args);

				if ($categories) :
				?>
				<div class="padding-top-x2">
					<div class="grid-x grid-padding-x grid-padding-y">
						<div class="cell medium-8 large-6 xlarge-4">
							<form class="category-dropdown" method="get">
								<select name="category" onchange="location = this.options[this.selectedIndex].value;">
									<option value=""><?php _e('Category'); ?></option>
									<?php 
									if ($blog_page) echo '<option value="' . get_the_permalink($blog_page) . '">All</option>';
									
									$i = 0; foreach ($categories as $category) : $i++;
									$category_link = get_term_link( $category->slug, $category->taxonomy );
									?>
									<option value="<?php echo $category_link; ?>"><?php echo $category->name; ?></option>
									<?php
									endforeach;
									?>
								</select>
							</form>
						</div>
					</div>
				</div>
				<?php
				endif;
				
				endif;
				?>
			</div>
		</div>
	</div>
</header>