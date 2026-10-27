<?php
/**
 * The template for displaying the footer.
 */

$company_address        = get_field('company_address', 'option');
$company_contact_number = get_field('company_contact_number', 'option');
$company_email          = get_field('company_email', 'option');
$footer_copyright_text  = get_field('footer_copyright_text', 'option');
$social_links           = get_field('social_links', 'option');
$form_heading           = get_field('form_heading', 'option');
$form_shortcode         = get_field('form_shortcode', 'option');
?>
		</main>

		<footer class="footer" id="footer" data-scroll="#contact">
			<div class="container">
				<div class="row">
					<div class="footer-brand">
						<a href="<?php echo bloginfo('url') ?>" class="logo">
							<?php get_template_part('assets/img/svg/site-logo-blue'); ?>
						</a>
					</div>
					<div class="footer-form-col">
						<?php if ($form_heading) : ?>
							<h2 class="form-heading"><?php echo esc_html($form_heading); ?></h2>
						<?php endif; ?>
						<?php if ($form_shortcode) : ?>
							<div class="footer-form">
								<?php echo do_shortcode($form_shortcode); ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="footer-meta">
						<?php if ($company_address || $company_contact_number || $company_email) : ?>
							<div class="company-details">
								<p>
									<?php if ($company_address) : ?>
										<span class="address"><?php echo nl2br(esc_html($company_address)); ?></span>
									<?php endif; ?>
									<?php if ($company_contact_number) : ?>
										<span class="contact-number">
											<a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $company_contact_number)); ?>"><?php echo esc_html($company_contact_number); ?></a>
										</span>
									<?php endif; ?>
									<?php if ($company_email) : ?>
										<span class="email-address">
											<a href="mailto:<?php echo esc_attr($company_email); ?>"><?php echo esc_html($company_email); ?></a>
										</span>
									<?php endif; ?>
								</p>
							</div>
						<?php endif; ?>
						<?php if ($social_links) : ?>
							<ul class="social-links">
								<?php foreach ($social_links as $social_link) :
									$icon_svg = isset($social_link['icon_svg']) ? $social_link['icon_svg'] : '';
									$social_media_url = isset($social_link['social_media_url']) ? $social_link['social_media_url'] : '';
									if (!$social_media_url && !$icon_svg) {
										continue;
									}
								?>
									<li>
										<a href="<?php echo esc_url($social_media_url); ?>" target="_blank" rel="noopener noreferrer">
											<?php echo $icon_svg; ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if ($footer_copyright_text) : ?>
							<div class="copyright-text">
								<?php echo wpautop( do_shortcode( $footer_copyright_text ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</footer>

	</div>
	</div>

		<?php do_action('shortcode_output'); ?>

		<div id="outdated"></div>
		<script src="<?php echo get_bloginfo('template_url'); ?>/assets/js/outdatedbrowser.min.js"></script>
		<script>		
		//event listener: DOM ready
		function addLoadEvent(func) {
			var oldonload = window.onload;
			if (typeof window.onload != 'function') {
				window.onload = func;
			} else {
				window.onload = function() {
					if (oldonload) {
						oldonload();
					}
					func();
				}
			}
		}
		//call plugin function after DOM ready
		addLoadEvent(function(){
			outdatedBrowser({
				bgColor: '#f25648',
				color: '#ffffff',
				lowerThan: 'borderImage',
				languagePath: '<?php echo get_bloginfo('template_url'); ?>/assets/js/lang/en.html'
			})
		});
		</script>

		<!--[if lt IE 9]>
		  <script src="<?php echo get_bloginfo('template_url'); ?>/assets/js/html5shiv.js"></script>
		  <script src="<?php echo get_bloginfo('template_url'); ?>/assets/js/respond.min.js"></script>
		<![endif]-->

		<?php wp_footer(); ?>

	</body>
</html>