<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Lenscap
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="masthead" class="site-header">
	<div class="search-drawer" aria-expanded="false" role="region">
		<div class="container">
			<div class="drawer-search">
				<div class="big-search">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- .drawer -->

	<div class="top-navigation">
		<div class="container">
			<div class="site-identity clear">
				<!-- Site title and logo -->
				<?php lenscap_title_logo(); ?>

				<div class="top-navigation-right">
					<?php if ( has_nav_menu( 'social' ) ) { ?>
						<nav class="social-navigation">
							<?php wp_nav_menu( array(
								'theme_location' => 'social',
								'depth'          => 1,
								'fallback_cb'    => false
							) );?>
						</nav><!-- .social-navigation -->
					<?php } ?>

					<button class="search-toggle button-toggle">
						<span class="toggle-visible">
							<i class="fa fa-search"></i>
							<?php esc_html_e( 'Search', 'lenscap' ); ?>
						</span>
						<span>
							<i class="fa fa-times"></i>
							<?php esc_html_e( 'Close', 'lenscap' ); ?>
						</span>
					</button><!-- .overlay-toggle-->

					<button class="menu-toggle button-toggle">
						<span>
							<i class="fa fa-bars"></i>
							<?php esc_html_e( 'Menu', 'lenscap' ); ?>
						</span>
						<span>
							<i class="fa fa-times"></i>
							<?php esc_html_e( 'Close', 'lenscap' ); ?>
						</span>
					</button><!-- .overlay-toggle
					-->
				</div><!-- .top-navigation-right -->
			</div><!-- .site-identity-->

			<!-- Main navigation -->
			<nav id="site-navigation" class="main-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'primary'
				) );?>
			</nav><!-- .main-navigation -->
		</div><!-- .container -->

		<?php
			// Get the mobile menu (template-parts/content-menu-drawer.php)
			get_template_part( 'template-parts/content-menu-drawer' );
		?>
	</div><!-- .top-navigation -->
</header><!-- .site-header -->

<?php
	if ( is_page_template( 'templates/template-shop-homepage.php' ) ) {
		get_template_part( 'template-parts/content-featured-carousel-woo' );
	} else {
		get_template_part( 'template-parts/content-featured-carousel' );
	}
?>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content">
