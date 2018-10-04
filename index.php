<?php
/**
 * The main template file.
 *
 * @package Lenscap
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<!-- Load standard posts -->
			<?php if ( have_posts() ) : ?>

				<div id="post-wrapper">
					<div class="index-posts">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();

							if ( 'full-post' === get_option( 'lenscap_layout_style', 'excerpt' ) ) {
								get_template_part( 'template-parts/content' );
							} else if ( has_post_format( array( 'gallery', 'video' ) ) ) {
								get_template_part( 'template-parts/content-index-media' );
							} else {
								get_template_part( 'template-parts/content-index' );
							}

						endwhile;
					?>
					</div><!-- .index-posts -->

					<?php lenscap_page_navs(); ?>
				</div><!-- #post-wrapper -->

				<?php else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
