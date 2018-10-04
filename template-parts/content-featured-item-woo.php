<?php
/**
 * The template used for displaying Featured Content posts in the Featured Content Carousel
 *
 * @package Lenscap
 */
global $post;
$author_id    = $post->post_author;
$featured_tag = get_theme_mod( 'lenscap_woo_tag_select', '' );
global $woocommerce, $product;
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-src="post-<?php echo $post->ID; ?>">
		<?php
		// Get cover image opacity from the Customizer
		$header_opacity = get_theme_mod( 'lenscap_hero_opacity_woo', '1' );

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
		} if ( ! empty( $hero_src ) ) { ?>
			<!-- Get the cover image -->
			<div class="blur">
				<div class="cover-image" data-src="post-<?php echo $post->ID; ?>" style="background-image: url(<?php echo esc_url( $hero_src[0] ); ?>);"></div>
			</div>

		<?php } ?>

		<div class="container clear">
			<?php if ( ! empty( $hero_src ) ) { ?>
				<a class="woo-featured-image" href="<?php the_permalink(); ?>" rel="bookmark" style="background-image: url(<?php echo esc_url( $hero_src[0] ); ?>);"></a>
			<?php } ?>

			<div class="entry-content">
				<div class="featured-nav-container">
					<?php
						$tag = get_term_by( 'name', $featured_tag, 'product_tag' );
						$term_link = get_term_link( $tag->term_id );

						if ( ! is_wp_error( $term_link ) ) { ?>

						<h3 class="featured-content-title">
							<a href="<?php echo $term_link; ?>"><?php echo $tag->name; ?></a>
						</h3>

						<?php } ?>


					<div class="slide-navs">
						<a href="#" class="prev"><?php esc_html_e( 'Previous', 'lenscap' ); ?></a>
						<a href="#" class="next"><?php esc_html_e( 'Next', 'lenscap' ); ?></a>
					</div>
				</div>

				<!-- Post title and categories -->
				<div class="grid-text">
					<?php echo lenscap_list_cats( 'grid' ); ?>

					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

					<?php if( $product->get_price_html() || $product->get_average_rating() ) { ?>
						<div class="entry-price woocommerce">
							<?php
								echo $product->get_price_html();
								echo wc_get_rating_html( $product->get_average_rating() );
							?>
						</div>
					<?php } ?>

					<?php
						// Disable automatic output of Jetpack sharing
						if ( function_exists( 'sharing_display' ) ) {
							remove_filter( 'the_excerpt', 'sharing_display', 19 );
						}

						// Disable automatic output of Jetpack Likes
						if ( class_exists( 'Jetpack_Likes' ) ) {
							remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
						}

						$excerpt_length = get_theme_mod( 'lenscap_featured_excerpt_length_woo', '40' );
						// Only show if number of words is greater than zero
						if ( $excerpt_length > 0 ) {
							echo '<div class="entry-excerpt">';
							echo '<p>' . wp_trim_words( get_the_excerpt(), $excerpt_length, ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">...</a>' . '</p>' );
							echo '</div>';
						}
					?>

					<?php
					// Get Woo Product Categories
					echo get_the_term_list( $post->ID, 'product_cat', '<p class="entry-byline"><span>' . __( 'View all in: ', 'lenscap' ), ', ', '</span></p>' ); ?>
				</div><!-- .grid-text -->
			</div><!-- .entry-content -->
		</div><!-- .container -->
	</article><!-- .post -->
