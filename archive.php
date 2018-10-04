<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Lenscap
 */
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php if ( have_posts() ) : ?>
				<header class="entry-header archive-header">
				<?php
					// Grab author profile box
					if ( is_author() ) {
						lenscap_author_box();
					} else {
						the_archive_title( '<h1 class="entry-title">', '</h1>' );
						the_archive_description( '<div class="entry-content"><div class="taxonomy-description">', '</div></div>' );
					} ?>

				</header><!-- .entry-header -->

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
