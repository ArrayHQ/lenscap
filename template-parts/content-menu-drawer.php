<?php
/**
 * This template adds the mobile menu drawer
 *
 * @package Lenscap
 * @since Lenscap 1.0
 */
?>

<div class="drawer-wrap">
	<div class="drawer drawer-menu-explore">
		<?php if ( has_nav_menu( 'primary' ) ) { ?>
			<nav id="drawer-navigation" class="drawer-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'primary'
				) );?>
			</nav><!-- #site-navigation -->
		<?php } ?>

		<?php if ( has_nav_menu( 'social' ) ) { ?>
			<nav class="social-navigation drawer-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'social',
					'depth'          => 1,
					'fallback_cb'    => false
				) );?>
			</nav><!-- .footer-navigation -->
		<?php } ?>

		<?php get_search_form(); ?>
	</div><!-- .drawer -->
</div>