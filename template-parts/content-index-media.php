<?php
/**
 * The template for displaying video and gallery post format content on the index page
 *
 * @package Lenscap
 */

// Get the post content
$content = apply_filters( 'the_content', $post->post_content );

// Check for video post format content
$media = get_media_embedded_in_content( $content );

if( ! empty( $media ) ) {
	// Return the content, minus the first embedded video we find
	$remaining_content = str_replace( $media[0], '', $content );
}
?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a class="index-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

			<?php if ( ! empty( $media ) || get_post_gallery() ) { ?>
				<div class="preview-toggle">
					<span>
					<?php if ( has_post_format( 'gallery' ) ) {
						echo '<i class="fa fa-camera"></i>';
						esc_html_e( 'View Gallery', 'lenscap' );
					} else {
						echo '<i class="far fa-play-circle"></i>';
						esc_html_e( 'View Video', 'lenscap' );
					}
					?>
					</span>
				</div>
			<?php } ?>

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
			<!-- Lightbox close button -->
			<a class="button lightbox-button close-lightbox" aria-hidden="true"><i class="fa fa-times"></i> <?php esc_html_e( 'Close', 'lenscap' ); ?></a>

			<!-- Media archive link-->
			<a class="button lightbox-button video-archive-link" aria-hidden="true" href="<?php echo get_post_format_link( get_post_format() ); ?>"><span class="view-all"> <i class="fas fa-video"></i> <?php echo get_post_format_string( get_post_format() ); ?> <?php esc_html_e( 'Archive', 'lenscap' ); ?></span></a>

			<header class="entry-header">

				<?php echo lenscap_list_cats( 'grid' ); ?>

				<!-- Post title -->
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php
					// Generate an excerpt
					echo '<div class="entry-excerpt">';
						// Remove the output of Jetpack sharing and likes
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
					$author_id = $post->post_author;
				?>

				<p class="entry-byline">
					<!-- Create an author post link -->
					<span class="entry-byline-on"><?php esc_html_e( 'By', 'lenscap' ); ?></span>
					<a class="entry-byline-author" href="<?php echo get_author_posts_url( $author_id ); ?>">
						<?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?>
					</a>
					<span class="entry-byline-on"><?php esc_html_e( 'on', 'lenscap' ); ?></span>
					<span class="entry-byline-date"><?php echo esc_attr( sprintf( __( '%s', 'lenscap' ), get_the_date() ) ); ?></span>
				</p>
			</header>
		</div><!-- .index-text -->

		<?php
		// Get the first video embed from the post to replace the featured image on video post types
		if ( ! empty( $media ) && has_post_format( 'video' ) ) {
			echo '<div class="featured-video" aria-hidden="true">';
				echo $media[0];
			echo '</div>';
		}

		// Get the first gallery embed on gallery post types
		if ( has_post_format( 'gallery' ) && get_post_gallery() ) :
			echo '<div class="gallery-container" aria-hidden="true">';
				echo get_post_gallery();
			echo '</div>';
		endif; ?>
	</div><!-- .post -->
