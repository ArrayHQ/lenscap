<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Lenscap
 */

// Don't show the sidebar on some pages
if ( class_exists( 'WooCommerce' ) ) {
	if ( is_cart() || is_checkout() || is_shop() || is_product_category() || is_product_tag() ) {
		return;
	}
}

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar' ) ) { ?>
	<div id="secondary" class="widget-area">
		<?php do_action( 'lenscap_above_sidebar' );

		dynamic_sidebar( 'sidebar' );

		do_action( 'lenscap_below_sidebar' ); ?>
	</div><!-- #secondary .widget-area -->
<?php }