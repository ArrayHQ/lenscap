<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Lenscap
 */
?>

	</div><!-- #content -->
</div><!-- #page .container -->

<?php
	// Related Posts
	if ( class_exists( 'Jetpack_RelatedPosts' ) && is_singular( 'post' ) ) {
		echo '<div class="related-post-wrap">';
			echo '<div class="container">';
				echo do_shortcode( '[jetpack-related-posts]' );
			echo '</div>';
		echo '</div>';
	}
?>

<?php
	// Check if the menu is enabled via the Customizer (Appearance > Customize > Theme Options)
	$footer_browse_title = get_theme_mod( 'lenscap_browse_title', esc_html__( 'Browse Categories', 'lenscap' ) );

	// Get the category menu title
	$footer_browse = get_theme_mod( 'lenscap_category_browse', 'enabled' );

	// Make sure we have categories
	$category_check = get_the_category_list();

	// Show the footer category browser
	if ( is_home() && $category_check && 'disabled' != $footer_browse ) { ?>
	<div class="category-wrap">
		<div class="container">
			<h3 class="category-menu-title"><?php if( $footer_browse_title ) { echo esc_html( $footer_browse_title ); } ?></h3>

			<button class="sort-list-toggle">
			<?php if( $footer_browse_title ) { echo esc_html( $footer_browse_title ); } else {
					esc_html_e( 'Browse Categories', 'lenscap' );
				} ?> <i class="fa fa-caret-down"></i></button>

			<?php wp_nav_menu( array(
				'theme_location' => 'category-footer',
				'menu_id'        => 'footer-category-menu',
				'fallback_cb'    => 'lenscap_fallback_category_menu',
				'menu_class'     => 'sort-list',
				'depth'          => 1,
			) );?>

			<div class="featured-posts-wrap clear">
				<div class="featured-posts grid-wrapper clear">
					<div class="post-container clear"></div>
				</div>
			</div><!-- .featured-posts -->
		</div><!-- .container -->
	</div><!-- .category-wrap -->
<?php } ?>

<footer id="colophon" class="site-footer">
	<?php
		// Footer background image
		$footer_bg = get_theme_mod( 'lenscap_footer_bg' );

		if ( $footer_bg ) { ?>
			<div class="cover-image-footer-wrap">
				<div class="cover-image-footer" style="background-image: url(<?php echo esc_url( $footer_bg ) ?>);"></div>
			</div>
	<?php } ?>

	<div class="container">

		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="footer-widgets">
				<?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-4' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php } ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<?php if ( has_nav_menu( 'footer' ) ) { ?>
				<nav class="footer-navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .footer-navigation -->
			<?php } ?>

			<div class="footer-tagline">
				<div class="site-info">
					<?php echo lenscap_filter_footer_text(); ?>
				</div>
			</div><!-- .footer-tagline -->
		</div><!-- .footer-bottom -->
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
