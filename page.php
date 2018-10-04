<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Lenscap
 */

// Remove automatic output of share icons on Woo pages
if ( class_exists( 'WooCommerce' ) ) {
	if ( is_cart() || is_checkout() || is_shop() || is_account_page() ) {
		$hide_icons = 'true';
	} else {
		$hide_icons = 'false';
	}
} else {
	$hide_icons = 'false';
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post();

				// Page content template
				get_template_part( 'template-parts/content-page' );

					if ( 'false' === $hide_icons && function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) {
						echo "<div class='share-icons'>";

							// Sharing Buttons
							if ( function_exists( 'sharing_display' ) ) {
								echo sharing_display();
							}

							// Likes
							if ( class_exists( 'Jetpack_Likes' ) ) {
								$custom_likes = new Jetpack_Likes;
								echo $custom_likes->post_likes( '' );
							}

						echo "</div>";
					}

				// Comments template
				comments_template();

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar();

get_footer(); ?>
