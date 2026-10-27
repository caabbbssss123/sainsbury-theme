<?php

/**
 * The Header for our theme.
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri() ?>/favicon/favicon.svg" />
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/favicon/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="Sainsbury" />
	<link rel="manifest" href="<?php echo get_template_directory_uri() ?>/favicon/site.webmanifest" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" href="<?php echo get_bloginfo('template_url'); ?>/assets/css/outdatedbrowser.min.css">

	<?php
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="smooth-wrapper">
	<div id="smooth-content">

	<header id="main-header" aria-label="Main Header">
		<div class="container">
			<div class="inner-wrapper">
				<div class="logo-wrapper">
					<a href="<?php echo bloginfo('url') ?>" class="logo">
						<?php get_template_part('assets/img/svg/site-logo'); ?>
					</a>
				</div>
				<div class="nav-wrapper">
					<button type="button" class="navbar-toggle collapsed" tabindex="2">
						<span class="visually-hidden"><?php echo esc_html_x( 'Toggle Navigation', 'header', 'estatein' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<nav class="nav main-menu">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
							)
						);
						?>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<main>