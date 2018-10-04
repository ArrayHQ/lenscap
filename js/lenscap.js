(function($) {
	"use strict";

	$(document).ready(function() {

		// Fitvids
        $('.post,.featured-image').fitVids();


		// Comments toggle
		$('.comments-toggle').click(function(e) {
			$('.comment-list,.comment-respond').slideToggle(400);
			return false;
		});


		// Search togle
		$('.search-toggle').click(function(e) {
			$('.search-drawer').attr('aria-expanded', ($('.search-drawer').attr('aria-expanded')=='false') ? 'true':'false').slideToggle(200);

			$('.search-toggle span').toggle();
			$('.big-search .search-input').focus();
			return false;
		});


		// Close the search drawer
		function closeDrawer() {
			$('.search-drawer').attr('aria-expanded','false').slideUp(200);
			$('.search-toggle span').hide();
			$('.search-toggle span:first-child').show();
        }


        // When search drawer is open, allow click on body to close
		$('html').click(function() {
			closeDrawer();
		});


		// Escape key closes drawer
		$(document).keyup(function(e) {
		    if (e.keyCode == 27) {
				// Hide any drawers that are open
				closeDrawer();
				closeLightbox();
		    }
		});


		// Allow clicking in the drawer when it's open
		$('.search-drawer').click(function(event){
		    event.stopPropagation();
		});


		// Sort list toggle
		$('.sort-list-toggle').click(function(e) {
			$('.sort-list').slideToggle();
			return false;
		});


		// Close the sort list to show posts on mobile
		$(window).on('load resize', function() {
			var current_width = $(window).width();

		    // If width is below iPad size
		    if (current_width < 801) {
		    	$('.sort-list a').click(function(e) {
					setTimeout(function() {
						$('.sort-list').slideUp();
					}, 400)
				});

				closeDrawer();
		    }
		});


		// Scroll to comment on direct link
		if ( document.location.href.indexOf('#comment') > -1 ) {
			// Grab the comment ID from the url
			var commentID = window.location.hash.substr(1);

			// Show the comment form
			$('.comment-list,.comment-respond').show();
		}


		// Back to top
		$('.back-to-top a').click(function(e) {
			e.preventDefault();

			$('html,body').animate({
			    scrollTop: 0
			}, 700);

			return false;
		} );


		// Standardize drop menu types
		$('.main-navigation .children').addClass('sub-menu');
		$('.main-navigation .page_item_has_children').addClass('menu-item-has-children');


		/**
		 * Mobile menu functionality
		 */

		// Toggle the mobile menu
		$('.menu-toggle').click(function() {
			$('.drawer').toggle();
			$(this).find('span').toggle();
		});

		// Append a clickable icon to mobile drop menus
		var item = $('<button class="toggle-sub" aria-expanded="false"><i class="fa fa-angle-down"></i></button>');

		// Append clickable icon for mobile drop menu
		if ($('.drawer .menu-item-has-children .toggle-sub').length == 0) {
			$('.drawer .menu-item-has-children,.drawer .page_item_has_children').append(item);
		}

		// Show sub menu when toggle is clicked
		$('.drawer .menu-item-has-children .toggle-sub').click(function(e) {
			$(this).each(function() {
				e.preventDefault();

				// Change aria expanded value
				$(this).attr('aria-expanded', ($(this).attr('aria-expanded')=='false') ? 'true':'false');

				// Open the drop menu
				$(this).closest('.menu-item-has-children').toggleClass('drop-open');
				$(this).prev('.sub-menu').toggleClass('drop-active');

				// Change the toggle icon
				$(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
			});
		});


		// Fetch ajax posts for footer category menu in the footer
		var footer_drawer = $('#footer-category-menu a');

		footer_drawer.click(function (event) {

			var cat_link = $(this).attr('data-object-id');

			if (typeof cat_link !== typeof undefined && cat_link !== false) {

				event.preventDefault();

				var id        = $(this).attr('data-object-id');
				var container = $('.category-wrap .post-container');
				var catHeader = $('.category-wrap .featured-header-category');

				var data = {
					action: 'lenscap_category',
					id: id
				};

				// Fade out the category post container while loading
				$('.category-wrap .post-container').addClass('post-loading');

				$.ajax({
					data: data,
					type: "POST",
					dataType: "json",
					url: lenscap_js_vars.ajaxurl,
					success: function(response) {
						container.html(response.html);
						catHeader.html(response.term_html);
						$('.post-container').removeClass('post-loading');
					},
					error: function(response) {
						container.html(response.html);
					}
				});

				$(this).parent().siblings().removeClass('current-menu-item');
				$(this).parent().addClass('current-menu-item');
			}
		});


		// Click the first category link to use as a placeholder
		$('.sort-list li:first-child a').click();


		// Infinite scroll
		$( document.body ).on( "post-load", function () {
			var $container = $('.index-posts');
			var $newItems = $('.new-infinite-posts').not('.is--replaced');
			var $elements = $newItems.find('.post');

			// Remove the empty elements that break the grid
			$('.new-infinite-posts,.infinite-loader').remove();

			// Append IS posts
			$container.append($elements);
		});


		// Waypoint sticky
        function stickyBanner() {
            var $stickySidebar = $('.single .sticky-widget');
            var stickyAside;
            var sidebarWidth = $('.single .post .entry-meta').width();

            if ($stickySidebar.length) {
                stickyAside = new Waypoint.Sticky({
                    element: $stickySidebar[0],
                    handler: function(direction) {
                        $('.stuck').css({
                            'width': sidebarWidth + 'px',
                        });
                    },
                })
            }
        }

        // Only run it on desktop
        $(window).on('load', function() {
            var current_width = $(window).width();

            if ( current_width > 768 ) {
				var post_height    = $('.single .entry-content').outerHeight();
				var $sticky_height = $('.meta-list');
				var totalHeight    = 0;

				// Calculate the size of the sidebar
				$.each($sticky_height, function() {
				    totalHeight += $(this).height();
				});

				// If the sidebar is bigger than the post, add a min-height to the container so it all fits
				if (post_height < totalHeight) {
					$('.single .post .entry-meta').addClass('remove-stick');

					$('.single .post .entry-content').css({
		                'min-height': totalHeight + 'px'
		            });
				}

            	// Only trigger the sticky if the page has been scrolled
                var hasBeenTrigged = false;
			    $(window).scroll(function() {
			        if ($(this).scrollTop() >= 1 && !hasBeenTrigged) {
			            stickyBanner();
			            hasBeenTrigged = true;
			        }
			    });
        	}
        });

        // Calculate the width of the sidebar on page load/resize
        $(window).on("resize load", function() {
        	var current_width = $(window).width();

        	// Only run it on desktop
        	if ( current_width > 768) {
	        	var sidebarWidth = $('.single .entry-meta').width();

	        	$('.sticky-widget').css({
	                'width': sidebarWidth + 'px'
	            });
        	}
        });


        // Unhook the sticky sidebar when it hits the bottom
        var $isSticky = $('.single .entry-meta');
        if ($isSticky.length) {
            $(window).scroll(function() {
                var length = $('.single .entry-meta').height() - $('.single .sticky-wrapper').height() + $('.single .entry-meta').offset().top;
                var scroll = $(this).scrollTop();

                if (scroll > length) {
                    // When we hit the bottom of the page, remove the fixed positioning
                    $('.stuck').addClass('bottom-stick');
                } else {
                    $('.stuck').removeClass('bottom-stick');
                }
            });
        }


		// Initialize responsive slides
		var $slides = $('.featured-content-posts');
		$slides.responsiveSlides({
		    auto: false,
		    speed: 200,
		    nav: true,
		    manualControls: '#hero-pager',
		});


		$('.slide-navs .prev').click(function(e) {
			$(this).closest('.featured-content-wrapper').find('.rslides_nav.prev').click();
			return false;
		});

		$('.slide-navs .next').click(function(e) {
			$(this).closest('.featured-content-wrapper').find('.rslides_nav.next').click();
			return false;
		});


		// Add touch support to responsive slides
		$('.featured-content-posts .rslides').each(function() {
		    $(this).swipe({
			swipeLeft: function() {
			    $(this).parent().find('.rslides_nav.prev').click();
			},
			swipeRight: function() {
			    $(this).parent().find('.rslides_nav.next').click();
			}
		    });
		});


		// Video/gallery lightbox toggle
		$(document).on('click', '.excerpt-view .index-posts .preview-toggle', function(e) {
			$(this).each(function() {
				e.preventDefault();

				// Build the lightbox from the current post
				var lightbox = $(this).closest('.format-video,.format-gallery').clone().addClass('video-lightbox').appendTo('.index-posts');

				// Remove the transform effects from the post
				setTimeout(function() {
					$('.video-lightbox').addClass('remove-transform');
				}, 4000);

				$('.video-lightbox .index-image').click(false);
			});
		});


		// Close the video lightbox
		function closeLightbox() {
			// Fade out the lightbox
			$('.video-lightbox').addClass('fade-out');

			// Remove it from the DOM
			setTimeout(function() {
				$('.video-lightbox').remove();
			}, 500);

			$('.video-lightbox').removeClass('remove-transform');
        }


        // Close the video lightbox
		$( document ).on( 'click', '.close-lightbox', function() {
			closeLightbox();
		});

		$('.page-template-template-shop-homepage .testimonial-entry-title, .page-template-template-shop-homepage .testimonial-featured-image').click(false);

	});

})(jQuery);
