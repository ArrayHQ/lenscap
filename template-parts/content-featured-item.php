<?php
/**
 * The template used for displaying Featured Content posts in the Featured Content Carousel
 *
 * @package Lenscap
 */
global $post;
$featured_options = get_option( 'featured-content' );
$featured_name    = $featured_options[ 'tag-name' ];
$featured_id      = (int) $featured_options[ 'tag-id' ];
$featured_layout  = get_option( 'lenscap_featured_layout', 'column-header' );
$author_id        = $post->post_author;
?>
	<article id="post-<?php the_ID(); ?>-carousel" <?php post_class(); ?> data-src="post-<?php echo esc_attr( $post->ID ); ?>">
		<?php
		// Get cover image opacity from the Customizer
		$header_opacity = get_theme_mod( 'lenscap_hero_opacity', '1' );

		// Get the right size image for the hero background
		$detect = new Mobile_Detect;

		if ( $detect->isMobile() ) {
			// Get mobile size image
			$hero_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "lenscap-hero-mobile" );
		} else if( $detect->isTablet() ) {
			// Get tablet size image
			$hero_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "lenscap-hero-tablet" );
		} else {
			// Get desktop sized image
			$hero_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "lenscap-hero" );
		}

		if ( ! empty( $hero_src ) ) { ?>
			<!-- Get the cover image -->
			<div class="blur">
				<div class="cover-image" data-src="post-<?php echo esc_attr( $post->ID ); ?>" style="background-image: url(<?php echo esc_url( $hero_src[0] ); ?>);"></div>
			</div>
		<?php } ?>

		<div class="container clear">
			<div class="entry-content">
			
				<?php
					$featured_content_title = get_theme_mod( 'lenscap_featured_content_title' );
					$term_link = get_term_link( $featured_id, 'post_tag' );
					if ( ! is_wp_error( $term_link ) && $featured_content_title ) { ?>
					<h3 class="featured-content-title">
						<a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $featured_content_title ); ?></a>
					</h3>
				<?php } ?>

				<div class="slide-navs">
					<a href="#" class="prev"><?php esc_html_e( 'Previous', 'lenscap' ); ?></a>
					<a href="#" class="next"><?php esc_html_e( 'Next', 'lenscap' ); ?></a>
				</div>

				<!-- Post title and categories -->
				<div class="grid-text">
					<?php echo lenscap_list_cats( 'grid' ); ?>

					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

					<?php
						// Disable automatic output of Jetpack sharing
						if ( function_exists( 'sharing_display' ) ) {
							remove_filter( 'the_excerpt', 'sharing_display', 19 );
						}

						// Disable automatic output of Jetpack Likes
						if ( class_exists( 'Jetpack_Likes' ) ) {
							remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
						}

						echo '<div class="entry-excerpt">';
							add_filter( 'excerpt_length', 'lenscap_featured_excerpt' );

							echo the_excerpt();

							remove_filter( 'excerpt_length', 'lenscap_featured_excerpt' );
						echo '</div>';
					?>

					<p class="entry-byline">
						<!-- Create an avatar link -->
						<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'Posts by %s', 'lenscap' ), get_the_author() ) ); ?>">
							<?php echo get_avatar( $author_id, apply_filters( 'lenscap_author_bio_avatar', 44 ) ); ?>
						</a>

						<!-- Create an author post link -->
						<a class="entry-byline-author" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
							<?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?>
						</a>
						<span class="entry-byline-on"><?php esc_html_e( 'on', 'lenscap' ); ?></span>
						<span class="entry-byline-date"><?php echo get_the_date(); ?></span>
					</p>
				</div><!-- .grid-text -->
			</div><!-- .entry-content -->
		</div><!-- .container -->
	</article><!-- .post -->
