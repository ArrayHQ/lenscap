<?php
/**
 * Template Name: Shop Homepage
 *
 * @package Lenscap
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post();

				// Move Jetpack share links below author box
				if ( function_exists( 'sharing_display' ) ) {
					remove_filter( 'the_content', 'sharing_display', 19 );
					remove_filter( 'the_excerpt', 'sharing_display', 19 );
				} ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- Grab the featured image -->
					<?php if ( has_post_thumbnail() ) { ?>
						<div class="featured-image"><?php the_post_thumbnail( 'lenscap-featured-image' ); ?></div>
					<?php } ?>

					<div class="entry-content">
						<?php the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lenscap' ),
							'after'  => '</div>',
						) ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->

			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
