<?php if ( has_nav_menu( 'primary' ) ) : ?>

	<div class="wrapper">

	<?php wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => '',
				'menu_id'         => 'menu-primary',
				'menu_class'      => 'site-nav_primary',
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%s" class="%s">%s</ul>'
			)
		); ?>

	<?php get_search_form(); ?>

	</div>

<?php endif; ?>
