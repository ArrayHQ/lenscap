<?php
/**
 * WooCommerce related functions
 *
 * @package Lenscap
 */


/**
 * Include WooCommerce Customizer Settings
 */
require_once( get_template_directory() . '/woocommerce/customizer-woo.php' );


/**
 * Register widget area
 */
function lenscap_woo_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Shop Archive Sidebar', 'lenscap' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce shop page.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Single Product Sidebar', 'lenscap' ),
		'id'            => 'sidebar-product',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce single product pages.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'lenscap_woo_widgets_init' );


/**
 * Add layout style class to body
 */
function lenscap_shop_layout_class( $classes ) {

	// Add sidebar class
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
		$classes[] = 'has-shop-sidebar';
	} else {
		$classes[] = 'no-shop-sidebar';
	}

	if ( is_active_sidebar( 'sidebar-product' ) ) {
		$classes[] = 'has-product-sidebar';
	} else {
		$classes[] = 'no-product-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'lenscap_shop_layout_class' );


/**
 * Add a sidebar to the shop page
 */
function lenscap_shop_sidebar () {
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
		echo '<div id="secondary" class="widget-area shop-sidebar">';
			do_action( 'lenscap_above_shop_sidebar' );
			dynamic_sidebar( 'sidebar-shop' );
			do_action( 'lenscap_below_shop_sidebar' );
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'lenscap_shop_sidebar', 1 );


/**
 * Add a sidebar to the single product page
 */
function lenscap_single_product_sidebar () {
	if ( is_active_sidebar( 'sidebar-product' ) ) {
		echo '<div id="secondary" class="widget-area">';
			do_action( 'lenscap_above_shop_sidebar' );
			dynamic_sidebar( 'sidebar-product' );
			do_action( 'lenscap_below_shop_sidebar' );
		echo '</div>';
	}
}
add_action( 'woocommerce_after_single_product_summary', 'lenscap_single_product_sidebar', 10 );


/**
 * Disable the auto output of the sidebar
 */
function lenscap_remove_sidebar () {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
}
add_action( 'template_redirect', 'lenscap_remove_sidebar' );


/**
 * Change the default product thumbnail
 */
function lenscap_product_thumbnail() {
	add_filter( 'woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src' );

	function custom_woocommerce_placeholder_img_src( $src ) {
		$src = get_template_directory_uri() . '/images/product-thumb.jpg';
		return $src;
	}
}
add_action( 'init', 'lenscap_product_thumbnail' );


/**
 * Add a conditional class to the Featured Product tags
 */
function lenscap_count_featured_products() {
	$featured_tag = get_theme_mod( 'lenscap_woo_tag_select', '' );
	$args        = array( 'post_type' => 'product', 'product_tag' => $featured_tag );
	$loop        = new WP_Query( $args );
	$count_posts = $loop->found_posts;

	if ( $loop->have_posts() ) :
		if ( $loop->found_posts > 1 ) :
			return 'multi-hero';
		else:
			return 'single-hero';
		endif;
	else :
	endif;
}


/**
 * Add layout style class to body
 */
function lenscap_woo_layout_class( $classes ) {
	$featured_tag = get_theme_mod( 'lenscap_woo_tag_select', '' );
	$featured_args = array(
		'post_type'      => 'product',
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

	$count = $featured_content->post_count;

	if ( is_page_template( 'templates/template-shop-homepage.php' ) && $count ) {
		$classes[] = 'has-featured-woo-content';
	}

	return $classes;
}
add_filter( 'body_class', 'lenscap_woo_layout_class' );