/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Site title and description
	wp.customize('blogname',function(value){
		value.bind(function(to){
			$('.site-title').text(to);
		});
	});


	wp.customize('blogdescription',function(value){
		value.bind(function(to){
			$('.site-description').text(to);
		});
	});

	// Featured content title
	wp.customize('lenscap_browse_title',function(value){
		value.bind(function(to){
			$('html, body').animate({
		        scrollTop: $('.category-wrap').offset().top
		    }, 2000);

			$('.category-wrap .category-menu-title').text(to);
		});
	});

	// Category menu title
	wp.customize('lenscap_featured_content_title',function(value){
		value.bind(function(to){
			if (to) {
				$('.featured-content-title').show();
				$('.featured-content-title').text(to);
			} else {
				$('.featured-content-title').hide();
			}
		});
	});


	// Hero background opacity
	wp.customize('lenscap_hero_opacity', function(value) {
		value.bind(function(to) {
			$('.cover-image').css('opacity',to);
		} );
	} );

	// Hero background blur radius
	wp.customize('lenscap_blur_radius',function(value) {
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


	// Accent colors
	wp.customize('lenscap_button_color',function(value) {
		value.bind( function( to ) {
			$('button:not(.preview-toggle), input[type="button"], input[type="reset"], input[type="submit"], .button, .comment-navigation a, .drawer .tax-widget a, .su-button, h3.comments-title, .page-numbers.current, .page-numbers:hover').css('background-color',to);

			$('.search-toggle').css('background-color','transparent');

			$('.widget-area aside .widget-title, .widget-area aside .widgettitle, .widget-area .widget-grofile h4 a, .site-footer .widget-title, .archive-header, .featured-content-title, .h3.comment-reply-title' ).css('border-left-color',to);

			$('.main-navigation ul li.current-menu-item').css('border-top-color',to);

			$('.sort-list .current-menu-item').css('border-bottom-color',to);

			$('.index-posts .grid-cats a, .grid-wrapper .grid-cats a').css('color',to);
		} );
	} );


	// Footer background opacity
	wp.customize('lenscap_footer_bg_opacity', function(value) {
		value.bind(function(to) {
			$('.cover-image-footer-wrap').css('opacity',to);
		} );
	} );

	// Footer background blur radius
	wp.customize('lenscap_footer_bg_blur_radius',function(value) {
		value.bind(function(to) {
			var filterVal = 'blur(' + to + 'px)';
			$('.cover-image-footer-wrap')
				.css('filter',filterVal)
				.css('webkitFilter',filterVal)
				.css('mozFilter',filterVal)
				.css('oFilter',filterVal)
				.css('msFilter',filterVal);
		} );
	} );

	// Footer background color
	wp.customize('lenscap_footer_bg_color', function(value) {
		value.bind(function(to) {
			$('.site-footer').css('background',to);
		} );
	} );


	// Featured Content hero background
	wp.customize('lenscap_featured_bg_color',function(value) {
		value.bind(function(to) {
			$('.featured-content-wrapper').css('background',to);
		} );
	} );


	// Featured Content text background
	wp.customize('lenscap_hero_text_opacity',function(value) {
		value.bind(function(to) {
			$('.featured-content-posts .post .grid-text, .hero-pager-wrap, .featured-content-wrapper .slide-navs a, .featured-content-wrapper .featured-content-title, .featured-content-nav').css('background',to);

			$('.pager-tip').css('border-bottom-color',to);
		} );
	} );


	// Featured Content header height
	wp.customize('lenscap_hero_height',function(value) {
		value.bind(function(to) {
			$('.featured-content-posts .post .container').css( 'padding', to + '% 5%' );
		} );
	} );


	// Featured Content position
	wp.customize('lenscap_featured_position',function(value) {
		value.bind(function(to) {
			$('.entry-content').css( 'float', to);
		} );
	} );


	// Featured Content text width
	wp.customize('lenscap_hero_width',function(value) {
		value.bind(function(to) {
			$('.entry-content').css( 'width', to + '%' );
		} );
	} );


	// Change footer text
	wp.customize('lenscap_footer_text',function(value){
		value.bind(function(to){
			$('.site-info').text(to);
		});
	});

})(jQuery);
