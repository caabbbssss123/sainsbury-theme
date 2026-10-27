<?php if (get_field('video_type') == 'vimeo') : ?>

	<script type="text/javascript">
		var bodyStyles		= window.getComputedStyle(document.body),
			colorPrimary	= bodyStyles.getPropertyValue('--vimeo-controls-color'),
			cleanColor		= colorPrimary.replace(' #', '');

		document.write('<iframe src="https://player.vimeo.com/video/<?php the_field('vimeo_id'); ?>?api=1&amp;color=' + cleanColor + '&amp;player_id=video1&amp;autoplay=false" frameborder="0" allow="fullscreen" allowfullscreen></iframe>');
	</script>

<?php elseif (get_field('video_type') == 'youtube') : ?>

	<iframe src="https://www.youtube.com/embed/<?php the_field('youtube_id'); ?>?rel=0" frameborder="0" allowfullscreen></iframe>

<?php  endif; ?>