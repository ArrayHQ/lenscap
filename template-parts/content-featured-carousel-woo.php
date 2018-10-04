<?php
/**
 * The template displays the Featured Content Carousel
 *
 * @package Lenscap
 */
$featured_tag     = get_theme_mod( 'lenscap_woo_tag_select', '' );
$hero_count_class = lenscap_count_featured_products();
$featured_layout  = get_theme_mod( 'lenscap_featured_header_style_woo', 'fullwidth' );
?>

<!-- Featured WooCommerce products -->
<?php
	if ( '' != $featured_tag ) {

		$featured_args = array(
			'post_type'      => 'product',
			'posts_per_page' => 4,
			'no_found_rows'  => true,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'slug',
					'terms'    => $featured_tag
				),
			),
		);
		$featured_content = new WP_Query ( $featured_args );
		if ( $featured_content -> have_posts() ) :
	?>

	<?php
	// Add a boxed container if selected in the customizer
	if ( 'boxed' === $featured_layout ) { ?>
		<div class="container">
	<?php } ?>

		<div class="featured-content-wrapper featured-content-woo <?php echo $hero_count_class; ?>">
			<div class="cover-wrap">
				<span class="header-cover"></span>
			</div>

			<div class="featured-content-posts">
				<?php while ( $featured_content -> have_posts() ) : $featured_content -> the_post();
					get_template_part( 'template-parts/content-featured-item-woo' );
				endwhile; ?>
			</div><!-- .hero-posts -->

			<?php
				// If we have more than one post, load the carousel pager
				$count = $featured_content->post_count;
				if ( $count > 1 ) { ?>
				<div class="hero-pager-wrap clear">
					<div class="container">
						<ul id="hero-pager">
							<?php while ( $featured_content -> have_posts() ) : $featured_content -> the_post(); ?>
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
												<?php global $woocommerce, $product;
												if( $product->get_price_html() ) { ?>
													<div class="entry-price">
														<?php
															echo $product->get_price_html();
														?>
													</div>
												<?php } ?>
											</div>
										</div>
									</a>
								</li>
							<?php endwhile; ?>
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

	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
<?php } // If featured_tag exists ?>