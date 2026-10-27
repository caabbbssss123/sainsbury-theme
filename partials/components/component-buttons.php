<?php if( have_rows('row_buttons') ): ?>
	<div class="<?php if ($row_content) echo 'padding-top-x2'; ?>">
		<div class="grid-x grid-x--small grid-padding-x grid-padding-y">
			<?php
			while ( have_rows( 'row_buttons' ) ): the_row();
			$button			= get_sub_field('button');
			$link_url		= $button['url'];
			$link_title		= $button['title'];
			$link_target	= $button['target'] ? $button['target'] : '_self';
			?>
			<div class="cell shrink">
				<a class="btn btn--<?php echo $button_colour; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif; ?>