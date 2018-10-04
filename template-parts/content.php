<?php
/**
 * The template used for displaying standard post content
 *
 * @package Lenscap
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<!-- Post title -->
		<?php if ( is_single() ) { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } else { ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php }

		// Post excerpt used as subtitle
		if ( has_excerpt() ) {

			echo '<div class="entry-excerpt">';
				if ( function_exists( 'sharing_display' ) ) {
					remove_filter( 'the_excerpt', 'sharing_display', 19 );
				}

				if ( class_exists( 'Jetpack_Likes' ) ) {
					remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
				}
				the_excerpt();
			echo '</div>';
		} ?>

		<?php
			// Get the post author
			global $post;
			$author_id = $post->post_author;
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
	</header>

	<?php
	// Get the post content
	$content = apply_filters( 'the_content', $post->post_content );

	// Check for video post format content
	$media = get_media_embedded_in_content( $content );

	// If it's a video format, get the first video embed from the post to replace the featured image
	if ( has_post_format( 'video' ) && ! empty( $media ) ) {

		echo '<div class="featured-video">';
			echo $media[0];
		echo '</div>';

	}
	// If it's a gallery format, get the first gallery from the post to replace the featured image
	else if ( has_post_format( 'gallery' ) ) {

		echo '<div class="featured-image featured-gallery">';
			echo get_post_gallery();
		echo '</div>';

	} else if ( has_post_thumbnail() ) {

	if ( is_single() ) { ?>
		<div class="featured-image"><?php the_post_thumbnail( 'lenscap-featured-image' ); ?></div>
	<?php } else { ?>
		<div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'lenscap-featured-image' ); ?></a>
		</div>
	<?php } } wp_reset_postdata(); ?>

	<div class="entry-content">

		<?php
		// Remove Jetpack Sharing output
		remove_filter( 'the_content', 'sharing_display', 19 );

		// If it's a video format, filter out the first embed and return the rest of the content
		if ( has_post_format( 'video' ) || has_post_format( 'gallery' ) ) {
			lenscap_filtered_content();
		} else {
			the_content( esc_html__( 'Read More', 'lenscap' ) );
		}

		// Post pagination links
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lenscap' ),
			'after'  => '</div>',
		) );

		// Post meta sidebar
		get_template_part( 'template-parts/content-meta' );

		if ( is_single() ) {

			// Author profile box
			lenscap_author_box();

			// Comments template
			comments_template();
		} ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
