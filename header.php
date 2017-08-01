<!DOCTYPE html>

<html <?php language_attributes( 'html' ); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class('no-js');?>>

	<div id="site" class="hfeed site">

		<header class="site-header">

			<nav class="site-nav">

				<a class="site-nav_home" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php echo file_get_contents( get_stylesheet_directory_uri() . '/img/icons/logo.svg' ); ?></a>

				<?php hybrid_get_menu( 'primary' ); ?>

			</nav>

			<button class="toggle-menu" type="button" aria-label="Toggle Navigation">
    		
				<span class="screen-reader-text"><?php _e( 'Navigation', 'piquant' ); ?></span>

			</button>

		</header>

		<main class="content group" itemprop="mainContentOfPage">