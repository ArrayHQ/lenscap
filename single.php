<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Lenscap
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post();

			// Post content template
			get_template_part( 'template-parts/content' );

		endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
