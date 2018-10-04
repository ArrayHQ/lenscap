<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Lenscap
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<article class="without-featured-image">
				<header class="entry-header">
					<h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'lenscap' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Please use the search box or the sitemap to locate the content you were looking for.', 'lenscap' ); ?></p>

					<?php get_search_form(); ?>

					<div class="archive-box">
						<h4><?php esc_html_e( 'Sitemap', 'lenscap' ); ?></h4>
						<ul>
							<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
						</ul>
					</div>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar();

get_footer(); ?>
