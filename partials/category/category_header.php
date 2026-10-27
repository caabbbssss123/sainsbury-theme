<?php // Category Archive Header

global $taxonomy, $parent_page, $background_colour;

$taxonomy_description	= $taxonomy->description;
?>
<header class="content-area-x2 background-<?php echo $background_colour; ?>">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="cell">
				<div class="grid-x">
					<div class="cell xxlarge-10">
						<h1><?php echo $taxonomy->name; ?></h1>
					</div>
				</div>
				<?php 
				if ($taxonomy_description) echo do_shortcode('<div class="padding-top-x2 wysiwyg"><div class="grid-x"><div class="cell large-10 xlarge-8">' . apply_filters('the_content', $taxonomy_description) . '</div></div></div>');

				$args = array(
				   'hierarchical'		=> 1,
				   'hide_empty'			=> 1,
				   'parent'				=> 0,
				   'taxonomy'			=> $taxonomy->taxonomy
				 );
				$categories = get_categories($args);

				if ($categories) :
				?>
				<div class="padding-top-x2">
					<div class="grid-x grid-padding-x grid-padding-y">
						<div class="cell medium-8 large-6 xlarge-4">
							<form class="category-dropdown" method="get">
								<select name="category" onchange="location = this.options[this.selectedIndex].value;">
									<option value=""><?php echo $taxonomy->name; ?></option>
									<?php 
									if ($parent_page) echo '<option value="' . get_the_permalink($parent_page) . '">All</option>';
									
									$i = 0; foreach ($categories as $category) : $i++;
									$link = get_term_link( $category->slug, $category->taxonomy );
									
									if ($category->name != $taxonomy->name) :
									?>
									<option value="<?php echo $link; ?>"><?php echo $category->name; ?></option>
									<?php
									endif;
									
									endforeach;
									?>
								</select>
							</form>
						</div>
					</div>
				</div>
				<?php
				endif;
				?>
			</div>
		</div>
	</div>
</header>