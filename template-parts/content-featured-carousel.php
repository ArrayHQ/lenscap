<?php
/**
 * The template displays the Featured Content Carousel
 *
 * @package Lenscap
 */
$featured_options = get_option( 'featured-content' );
$featured_name    = $featured_options[ 'tag-name' ];
$featured_layout  = get_theme_mod( 'lenscap_featured_header_style', 'fullwidth' );
?>

<?php
	// Get the featured content
	$featured_content = lenscap_get_featured_content();

	// Count the featured content posts
	$hero_count = apply_filters( 'lenscap_get_featured_posts', array() );

	// Apply a class for conditional styling
	if ( lenscap_has_featured_posts( 2 ) ) {
		$hero_count_class = 'multi-hero';
	} else {
		$hero_count_class = 'single-hero';
	}

	// If there is no featured content, don't return markup
	if ( $featured_options[ 'tag-id' ] && lenscap_has_featured_posts( 1 ) && is_home() ) {
	?>
		<?php
		// Add a boxed container if selected in the customizer
		if ( 'boxed' === $featured_layout ) { ?>
			<div class="container">
		<?php } ?>

			<div class="featured-content-wrapper <?php echo $hero_count_class; ?>">
				<div class="cover-wrap">
					<span class="header-cover"></span>
				</div>

				<div class="featured-content-posts">
					<?php foreach ( $featured_content as $post ) : setup_postdata( $post );

						get_template_part( 'template-parts/content-featured-item' );

						endforeach;
					?>
				</div><!-- .hero-posts -->

				<?php
				// If we have more than one post, load the carousel pager
				if ( lenscap_has_featured_posts( 2 ) ) { ?>
				<div class="hero-pager-wrap clear">
					<div class="container">
						<ul id="hero-pager">
							<?php foreach ( $featured_content as $post ) : setup_postdata( $post ); ?>
								<li>
									<i class="pager-tip"></i>
									<a>
										<?php if ( has_post_thumbnail() ) { ?>
											<div class="paging-thumb">
												<?php the_post_thumbnail( 'lenscap-hero-thumb' ); ?>
											</div>
										<?php } ?>

										<div class="paging-text">
											<div class="entry-title">
												<?php the_title(); ?>
											</div>

											<div class="paging-date">
												<?php echo get_the_date(); ?>
											</div>
										</div>
									</a>
								</li>
							<?php endforeach; ?>
						</ul><!-- .hero-pager -->
					</div><!-- .container -->
				</div><!-- .hero-pager-wrap -->
				<?php } ?>
			</div><!-- .featured-content-wrapper -->
		<?php
		// Add a boxed container if selected in the customizer
		if ( 'boxed' == $featured_layout ) { ?>
			</div><!-- .container -->
		<?php } ?>

		<?php wp_reset_postdata(); ?>
<?php } ?>
