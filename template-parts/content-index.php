<?php
/**
 * The template for displaying posts with a thumbnail, title and excerpt.
 *
 * @package Lenscap
 */
?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<a class="index-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

			<!-- Grab the image -->
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'lenscap-index-thumb' );
			 } else { ?>
				<!-- Use a fallback image and first letter of post -->
				<div class="fallback-letter">
					<span><?php lenscap_get_first_letter(); ?></span>
				</div>

				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/fallback-thumb.png' ); ?>" />
			<?php } ?>
		</a>

		<!-- Post title and categories -->
		<div class="index-text">
			<header class="entry-header">

				<?php echo lenscap_list_cats( 'grid' ); ?>

				<!-- Post title -->
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php
					echo '<div class="entry-excerpt">';
				    		if ( function_exists( 'sharing_display' ) ) {
							remove_filter( 'the_excerpt', 'sharing_display', 19 );
						}

						if ( class_exists( 'Jetpack_Likes' ) ) {
							remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
						}
						
						add_filter( 'excerpt_length', 'lenscap_extend_excerpt_length' );

						the_excerpt();

						remove_filter( 'excerpt_length', 'lenscap_extend_excerpt_length' );
					echo '</div>';
				?>

				<?php
					// Get the post author outside the loop
					global $post;
					$author_id   = $post->post_author;
				?>
				<p class="entry-byline">
					<!-- Create an author post link -->
					<span class="entry-byline-on"><?php esc_html_e( 'By', 'lenscap' ); ?></span>
					<a class="entry-byline-author" href="<?php echo get_author_posts_url( $author_id ); ?>">
						<?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?>
					</a>
					<span class="entry-byline-on"><?php esc_html_e( 'on', 'lenscap' ); ?></span>
					<span class="entry-byline-date"><?php echo esc_attr( sprintf( __( '%s', 'lenscap' ), get_the_date() ) ); ?></span>
				</p>
			</header>
		</div><!-- .grid-text -->
	</div><!-- .post -->
