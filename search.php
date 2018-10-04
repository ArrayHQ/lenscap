<?php
/**
 * The template for displaying Search results.
 *
 * @package Lenscap
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php if ( have_posts() ) : ?>
				<header class="entry-header archive-header">
					<h1 class="entry-title"><?php printf( esc_html__( 'Results for: %s', 'lenscap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .entry-header -->

				<div id="post-wrapper">
					<div class="index-posts">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();

							if ( 'full-post' === get_option( 'lenscap_layout_style', 'excerpt' ) ) {
								get_template_part( 'template-parts/content' );
							} else if ( has_post_format( 'video' ) ) {
								get_template_part( 'template-parts/content-index-media' );
							} else {
								get_template_part( 'template-parts/content-index' );
							}

						endwhile;
					?>
					</div><!-- .grid-wrapper -->

					<?php lenscap_page_navs(); ?>
				</div><!-- #post-wrapper -->

				<div class="results-search">
						<h4>
						<?php esc_html_e( 'Refine your search:', 'lenscap' ); ?>
						</h4>
						<?php get_search_form(); ?>
					</div>

				<?php else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
