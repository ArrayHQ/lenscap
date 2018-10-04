<?php
/**
 * The template used for displaying a post inside the Footer Category Menu
 *
 * @package Lenscap
 */
?>
	<article id="post-<?php the_ID(); ?>-browse" <?php post_class(); ?> data-src="post-<?php echo $post->ID; ?>">
		<a class="grid-post-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<!-- Grab the featured image -->
			<?php if ( has_post_thumbnail() ) {

				the_post_thumbnail( 'lenscap-grid-thumb' );

			} else { ?>
				<!-- Create a fallback image -->
				<div class="fallback-letter">
					<span><?php lenscap_get_first_letter(); ?></span>
				</div>

				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/fallback-thumb.png' ); ?>" />
			<?php } ?>
		</a>

		<!-- Post title and categories -->
		<div class="grid-text">
			<?php echo lenscap_list_cats( 'grid' ); ?>

			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			<div class="grid-date">
				<span class="date"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_date(); ?></a></span>
			</div>
		</div><!-- .grid-text -->
	</article><!-- .post -->
