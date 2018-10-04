/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Loads WooCommerce theme options asynchronously.
 */

(function($){

	// Hero background opacity
	wp.customize('lenscap_hero_opacity_woo', function(value) {
		value.bind(function(to) {
			$('.cover-image').css('opacity',to);
		} );
	} );

	// Hero background blur radius
	wp.customize('lenscap_blur_radius_woo',function(value) {
		value.bind(function(to) {
			var filterVal = 'blur(' + to + 'px)';
			$('.blur')
				.css('filter',filterVal)
				.css('webkitFilter',filterVal)
				.css('mozFilter',filterVal)
				.css('oFilter',filterVal)
				.css('msFilter',filterVal);
		} );
	} );

	// Featured Content hero background
	wp.customize('lenscap_featured_bg_color_woo',function(value) {
		value.bind(function(to) {
			$('.featured-content-wrapper').css('background',to);
		} );
	} );


	// Featured Content text background
	wp.customize('lenscap_hero_text_opacity_woo',function(value) {
		value.bind(function(to) {
			$('.featured-content-posts .post .grid-text, .hero-pager-wrap, .featured-content-wrapper .slide-navs a, .featured-content-wrapper .featured-content-title, .featured-content-nav').css('background',to);

			$('.pager-tip').css('border-bottom-color',to);
		} );
	} );


	// Featured Content header height
	wp.customize('lenscap_hero_height_woo',function(value) {
		value.bind(function(to) {
			$('.featured-content-posts .post .container').css( 'padding', to + '% 5%' );
		} );
	} );


	// Featured Content position
	wp.customize('lenscap_featured_position_woo',function(value) {
		value.bind(function(to) {
			$('.entry-content').css( 'float', to);
		} );
	} );


	// Featured Content text width
	wp.customize('lenscap_hero_width_woo',function(value) {
		value.bind(function(to) {
			$('.entry-content').css( 'width', to + '%' );
		} );
	} );

})(jQuery);
