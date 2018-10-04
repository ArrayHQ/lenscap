<?php
/**
 * The template for displaying the Testimonials archive page.
 *
 * @package Lenscap
 */

get_header(); ?>

	<?php $jetpack_options = get_theme_mod( 'jetpack_testimonials' ); ?>

	<?php if ( '' != $jetpack_options['page-content'] ) : // only display if content not empty ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="entry-header">
				<h1 class="entry-title">
					<?php
						if ( isset( $jetpack_options['page-title'] ) && '' != $jetpack_options['page-title'] ) {
							echo esc_html( $jetpack_options['page-title'] );
						}
						else {
							esc_html_e( 'Testimonials', 'lenscap' );
						}
					?>
				</h1>

				<div class="entry-content">
					<?php echo convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( $jetpack_options['page-content'] ) ) ) ) ) ); ?>
				</div>
			</header>
		</main>
	</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="jetpack-testimonial-shortcode column-1">
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'inc/testimonials/content', 'testimonials' );
			endwhile; ?>
		</div>
	<?php
		lenscap_page_navs();
		endif;
		wp_reset_postdata();
	?>

<?php get_footer(); ?>