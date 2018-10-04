<?php
/**
 * Lenscap functions and definitions
 *
 * @package Lenscap
 */


if ( ! function_exists( 'lenscap_setup' ) ) :
/**
 * Sets up Lenscap's defaults and registers support for various WordPress features
 */
function lenscap_setup() {

	/**
	 * Load Getting Started page and initialize theme updater
	 */
	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );

	/**
	 * TGM activation class
	 */
	require_once get_template_directory() . '/inc/admin/tgm/tgm-activation.php';

	/**
	 * Add styles to post editor (editor-style.css)
	 */
	add_editor_style( array( 'editor-style.css', lenscap_fonts_url() ) );

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'lenscap', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	// Index post image
	add_image_size( 'lenscap-index-thumb', 600, 450, true );

	// Index post image
	add_image_size( 'lenscap-index-full-thumb', 1200, 900, true );

	// Featured image
	add_image_size( 'lenscap-featured-image', 1100 );

	// Grid thumbnail
	add_image_size( 'lenscap-grid-thumb', 375, 250, true );

	// Grid thumbnail tall
	add_image_size( 'lenscap-grid-thumb-tall', 600, 800, true );

	// Testimonial avatar
	add_image_size( 'lenscap-testimonial-avatar', 100, 100, true );

	// Hero background image
	add_image_size( 'lenscap-hero', 1400 );
	add_image_size( 'lenscap-hero-tablet', 800 );
	add_image_size( 'lenscap-hero-mobile', 600 );

	// Hero pager thumb
	add_image_size( 'lenscap-hero-thumb', 50, 50, true );

	// Logo size
	add_image_size( 'lenscap-logo', 300 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary'         => esc_html__( 'Primary Menu', 'lenscap' ),
		'social'          => esc_html__( 'Social Icon Menu', 'lenscap' ),
		'category-footer' => esc_html__( 'Footer Category Menu', 'lenscap' ),
		'footer'          => esc_html__( 'Footer Menu', 'lenscap' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'custom-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'size'        => 'lenscap-logo',
	) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'gallery',
	) );

	/**
	 * Enable post formats
	 */
	add_theme_support( 'post-formats', array( 'video', 'gallery' ) );

	/**
	 * Enable WooCommerce gallery
	 */
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/**
	 * Mobile Detect
	 */
	if ( ! class_exists( 'Mobile_Detect' ) ) {
		require_once( get_template_directory() . '/inc/mobile/Mobile_Detect.php' );
	}

	/**
	 * Include WooCommerce functions and styles
	 */
	add_theme_support( 'woocommerce' );

	if ( class_exists( 'WooCommerce' ) ) {
		require_once( get_template_directory() . '/woocommerce/woo-functions.php' );
	}
}
endif; // lenscap_setup
add_action( 'after_setup_theme', 'lenscap_setup' );


/**
 * Set the content width based on the theme's design and stylesheet
 */
function lenscap_content_width() {
	if ( has_post_format( 'gallery' ) ) {
		$GLOBALS['content_width'] = apply_filters( 'lenscap_content_width', 1100 );
	} else {
		$GLOBALS['content_width'] = apply_filters( 'lenscap_content_width', 925 );
	}
}
add_action( 'after_setup_theme', 'lenscap_content_width', 0 );


/**
 * Gets the gallery shortcode data from post content.
 */
function lenscap_gallery_data() {
	global $post;
	$pattern = get_shortcode_regex();
	if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		&& array_key_exists( 2, $matches )
		&& in_array( 'gallery', $matches[2] ) )
	{

		return $matches;
	}
}


/**
 * If the post has a carousel gallery, remove the first gallery from the post
 *
 * @since lenscap 1.0
 */
function lenscap_filtered_content() {

	global $post, $wp_embed;

	$content = get_the_content( esc_html__( 'Read More', 'lenscap' ) );

	if ( has_post_format( 'gallery' ) ) {

		$gallery_data = lenscap_gallery_data();

		// Remove the first gallery from the post since we're using it in place of the featured image
		if ( $gallery_data && is_array( $gallery_data ) ) {
			$content = str_replace( $gallery_data[0][0], '', $content );
		}
	}

	if ( has_post_format( 'video' ) ) {

		// Remove the first video embed from the post since we're using it in place of the featured image
		if ( ! empty( $wp_embed->last_url ) ) {

			$content = str_replace( $wp_embed->last_url, '', $content );

		} else {

			$video = get_media_embedded_in_content( $content );
			$content = str_replace( $video, '', $content );
		}
	}

	echo apply_filters( 'the_content', $content );
}


/**
 * Register widget area
 */
function lenscap_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'lenscap' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of posts and pages.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 1', 'lenscap' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Widgets added here will appear in the left column of the footer.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 2', 'lenscap' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Widgets added here will appear in the center column of the footer.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 3', 'lenscap' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 4', 'lenscap' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'lenscap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'lenscap_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
function lenscap_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Archivo Narrow, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$archivo = esc_html_x( 'on', 'Archivo Narrow font: on or off', 'lenscap' );

	/* Translators: If there are characters in your language that are not
	 * supported by Roboto, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = esc_html_x( 'on', 'Roboto font: on or off', 'lenscap' );

	if ( 'off' !== $archivo || 'off' !== $roboto ) {
		$font_families = array();

		if ( 'off' !== $archivo )
			$font_families[] = 'Archivo Narrow:400,700';

		if ( 'off' !== $roboto )
			$font_families[] = 'Roboto:400,500,700,300,400italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Enqueue scripts and styles
 */
function lenscap_scripts() {

	wp_enqueue_style( 'lenscap-style', get_stylesheet_uri() );

	/**
	* Load fonts from Google
	*/
	wp_enqueue_style( 'lenscap-fonts', lenscap_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/fontawesome-all.css", array(), '5.0.10', 'screen' );

	/**
	 * Include WooCommerce functions and styles
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'lenscap-woocommerce-style', get_template_directory_uri() . "/woocommerce/lenscap-woo.css", array(), '1.0.9', 'screen' );
	}

	/**
	 * Load Lenscap's javascript
	 */
	wp_enqueue_script( 'lenscap-js', get_template_directory_uri() . '/js/lenscap.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load responsiveSlides javascript
	 */
	wp_enqueue_script( 'responsive-slides', get_template_directory_uri() . '/js/responsiveslides.js', array(), '1.54', true );

	/**
	 * Load fitvids javascript
	 */
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.1', true );

	/**
	 * Load touchSwipe javascript
	 */
	wp_enqueue_script( 'touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.js', array(), '1.6.6', true );


	/**
	 * Load Waypoints
	 */
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/jquery.waypoints.js', array(), '4.0.0', true );

	wp_enqueue_script( 'waypoints-sticky', get_template_directory_uri() . '/js/sticky.js', array(), '4.0.0', true );

	/**
	 * Localizes the lenscap-js file
	 */
	wp_localize_script( 'lenscap-js', 'lenscap_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lenscap_scripts' );


/**
 * Custom template tags for Lenscap
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Modify search form for drawer
 */
function lenscap_big_search( $form ) {
	$categories = get_categories(); ?>
	<div class="big-search">
		<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
			<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'lenscap' ); ?></label>

			<input type="text" name="s" class="big-search" placeholder="<?php esc_html_e( 'Search here...', 'lenscap' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" onfocus="if(this.value==this.getAttribute('placeholder'))this.value='';" onblur="if(this.value=='')this.value=this.getAttribute('placeholder');"/><br />

			<div class="search-controls">
			<?php
			/**
			 * Check if we have categories to show
			 */
			if ( $categories ) { ?>

				<div class="search-select-wrap">
					<select class="search-select" name="category_name">

						<option value=""><?php esc_html_e( 'Entire Site', 'lenscap' ); ?></option>

						<?php
							/**
							 * Generate list of categories
							 */
							foreach ( $categories as $category ) {
								echo '<option value="' . esc_attr( $category->slug ) . '">', $category->name, "</option>";
							}
						?>
					</select>
				</div>

			<?php } ?>

				<input type="submit" class="submit button" name="submit" id="big-search-submit" value="<?php esc_attr_e( 'Search', 'lenscap' ); ?>" />
			</div><!-- .search-controls -->
		</form><!-- #big-searchform -->

	</div><!-- .big-search -->
<?php }


/**
 * Add button class to next/previous post links
 */
function lenscap_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'lenscap_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'lenscap_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function lenscap_layout_class( $classes ) {

	// Add a layout class
	if ( 'full-post' === get_option( 'lenscap_layout_style', 'excerpt' ) ) {
		$classes[] = 'full-post-view';
	} else {
		$classes[] = 'excerpt-view';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add a featured content class
	if ( lenscap_has_featured_posts( 1 ) ) {
		$classes[] = 'has-featured-content';
	}

	// Add a featured content class
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'lenscap_layout_class' );


/**
 * Add post class to drawer posts
 */
function lenscap_grid_class( $classes ) {
	$classes[] = 'grid-post';
	return $classes;
}


/**
 * Add post class index posts
 */
function lenscap_index_class( $classes ) {
	$classes[] = 'index-post';
	return $classes;
}


/**
 * Add featured image class to posts
 */
function lenscap_featured_image_class( $classes ) {
	$classes[] = 'post';

	// Check for featured image
	$classes[] = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

	return $classes;
}
add_filter( 'post_class', 'lenscap_featured_image_class' );


/**
 * Adjust the grid excerpt length based on customizer setting
 */
function lenscap_extend_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'lenscap_grid_excerpt_length', '35' );
	return get_theme_mod( 'lenscap_grid_excerpt_length', $excerpt_length );
}


/**
 * Adjust the featured content item excerpt length
 */
function lenscap_featured_excerpt( $length ) {
	$excerpt_length = get_theme_mod( 'lenscap_featured_excerpt_length', '40' );
	return get_theme_mod( 'lenscap_featured_excerpt_length', $excerpt_length );
}


/**
 * Add an ellipsis read more link
 */
function lenscap_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">...</a>';
}
add_filter( 'excerpt_more', 'lenscap_excerpt_more' );


/**
 * Full size image on attachment pages
 */
function lenscap_attachment_size($p) {
	if ( is_attachment() ) {
		return '<p>' . wp_get_attachment_link( 0, 'full-size', false ) . '</p>';
	}
}
add_filter( 'prepend_attachment', 'lenscap_attachment_size' );


/**
 * Get the first letter of the post, used on fallback images
 *
 * @since lenscap 1.0
 */
function lenscap_get_first_letter() {
	$get_title =  get_the_title();
	$ltr_group = substr($get_title, 0, 1);
	echo $ltr_group;
}


/**
 * Adds a data-object-id attribute to nav links for category mega menu
 *
 * @return array $atts The HTML attributes applied to the menu item's <a> element
 */
function lenscap_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	if ( 'category' === $item->object ) {
		$atts['data-object-id'] = $item->object_id;
	}

	return $atts;
}


/**
 * Filters the current menu item to add another class.
 * Used to restore the active state when using the mega menu.
 */
function lenscap_nav_menu_css_class( $item, $args, $depth ) {
	if ( in_array( 'current-menu-item', $item ) ) {
		$item[] = 'current-menu-item-original';
	}
	return $item;
}


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function lenscap_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'lenscap_page_menu_args' );


/**
 * Fetches the posts for the mega menu posts
 */
function lenscap_menu_category_query() {

	$term_html = '';
	$output    = '';
	$id        = ( ! empty( $_POST['id' ] ) ) ? $_POST['id'] : '';

	if ( ! empty( $id ) ) {
		$term = get_term( (int) $id, 'category' );
	}

	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {

		$args = array(
			'posts_per_page' => '4',
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => (int) $id
				)
			)
		);

		$posts = new WP_Query( $args );

		if ( $posts->have_posts() ) {
			ob_start();
			while( $posts->have_posts() ) {
				$posts->the_post();
				add_filter( 'post_class', 'lenscap_grid_class' );
				get_template_part( 'template-parts/content-category-item' );
				remove_filter( 'post_class', 'lenscap_grid_class' );
			}
			$output = ob_get_clean();
		}
	}

	wp_send_json( array(
		'html' => $output
	) );

}
add_action( 'wp_ajax_lenscap_category', 'lenscap_menu_category_query' );
add_action( 'wp_ajax_nopriv_lenscap_category', 'lenscap_menu_category_query' );

/**
 * Adds the menu item filters
 */
function lenscap_mega_menu_check() {
	add_filter( 'nav_menu_css_class', 'lenscap_nav_menu_css_class', 10, 3 );
	add_filter( 'nav_menu_link_attributes', 'lenscap_nav_menu_link_attributes', 10, 4 );
}
add_action( 'template_redirect', 'lenscap_mega_menu_check' );


/**
 * Mega menu fallback
 */
function lenscap_fallback_category_menu() {
	$args = array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => 'true'
	);
	$categories = get_categories( $args );
	$count=0;
	echo "<ul id='footer-category-menu' class='sort-list'>";
	foreach( $categories as $category ) {
		$count++;
		echo '<li class="menu-item menu-item-' . esc_attr( $category->term_id ) . '"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . sprintf( esc_html__( "View all posts in %s", 'lenscap' ), $category->name ) . '" ' . ' data-object-id=" ' . esc_attr( $category->term_id ) . ' ">' . esc_html( $category->name ) . '</a></li>';
		if( $count > 8 ) break;
	}
	echo "</ul>";
}


/**
 * Removes the built-in styles in the Subtitles plugin.
 *
 * @since lenscap 1.0
 */
function lenscap_remove_subtitles_styles() {
	if ( class_exists( 'Subtitles' ) &&  method_exists( 'Subtitles', 'subtitle_styling' ) ) {
		remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
	}
}
add_action( 'template_redirect', 'lenscap_remove_subtitles_styles' );


/**
 * Remove automatic output of subtitles
 *
 * @since lenscap 1.0
 */
function lenscap_subtitles_mod_supported_views() {
	// Subtitle output handled by theme
}
add_filter( 'subtitle_view_supported', 'lenscap_subtitles_mod_supported_views' );


/**
 * Responsive Images
 */
function lenscap_post_thumbnail_sizes_attr($attr, $attachment, $size) {

	// Featured image thumbnails
	if ($size === 'lenscap-featured-image') {
		$attr['sizes'] = '(max-width: 1480px) 950px, (max-width: 800px) 800px, (max-width: 600px) 600px';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'lenscap_post_thumbnail_sizes_attr', 10 , 3 );


/**
 * Add a js class
 */
function lenscap_html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'lenscap_html_js_class', 1 );
