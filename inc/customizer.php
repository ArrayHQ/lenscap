<?php
/**
 * Lenscap Theme Customizer
 *
 * @package Lenscap
 */

add_action( 'customize_register', 'lenscap_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}


/**
 * Sanitize range slider
 */
function lenscap_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize post layout select option
 */
function lenscap_sanitize_layout_select( $layout ) {

	if ( ! in_array( $layout, array( 'full-post', 'excerpt' ) ) ) {
		$layout = 'excerpt';
	}
	return $layout;
}


/**
 * Sanitize header style
 */
function lenscap_sanitize_header_style_select( $header_layout ) {

	if ( ! in_array( $header_layout, array( 'fullwidth', 'boxed' ) ) ) {
		$header_layout = 'fullwidth';
	}
	return $header_layout;
}


/**
 * Sanitize mega menu select option
 */
function lenscap_sanitize_category_select( $cat_menu ) {

	if ( ! in_array( $cat_menu, array( 'disabled', 'enabled' ) ) ) {
		$cat_menu = 'enabled';
	}
	return $cat_menu;
}


/**
 * Sanitize header alignment
 */
function lenscap_sanitize_align_select( $alignment ) {

	if ( ! in_array( $alignment, array( 'none', 'right' ) ) ) {
		$alignment = 'none';
	}
	return $alignment;
}


/**
 * Sanitize text
 */
function lenscap_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize checkbox
 */
function lenscap_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}

/**
 * Footer category menu callback
 */
function lenscap_category_menu_callback( $control ) {
    if ( $control->manager->get_setting('lenscap_category_browse')->value() == 'enabled' ) {
        return true;
    } else {
        return false;
    }
}


/**
 * Index post excerpt callback
 */
function lenscap_index_excerpt_callback( $control ) {
    if ( $control->manager->get_setting('lenscap_layout_style')->value() == 'excerpt' ) {
        return true;
    } else {
        return false;
    }
}


/**
 * Footer background image callback
 */
function lenscap_footer_image_callback( $control ) {
    if ( $control->manager->get_setting('lenscap_footer_bg')->value() == '' ) {
        return false;
    } else {
        return true;
    }
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function lenscap_register( $wp_customize ) {

	/**
	 * Inlcude the Alpha Color Picker
	 */
	require_once( get_template_directory() . '/inc/admin/alpha-color-picker/alpha-color-picker.php' );

	/**
	 * Featured Content Panel
	 */
	$wp_customize->add_panel( 'lenscap_theme_options_panel', array(
		'priority'   => 5,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Theme Options', 'lenscap' ),
	) );

	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_section( 'lenscap_theme_options', array(
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'General Settings', 'lenscap' ),
		'panel'      => 'lenscap_theme_options_panel',
	) );

	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'lenscap_button_color', array(
		'default'           => '#1d96f3',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lenscap_button_color', array(
		'label'       => esc_html__( 'Accent Color', 'lenscap' ),
		'section'     => 'lenscap_theme_options',
		'settings'    => 'lenscap_button_color',
		'description' => esc_html__( 'Change the accent color of buttons and various typographical elements.', 'lenscap' ),
		'priority'    => 5
	) ) );


	// Index Post Style
	$wp_customize->add_setting( 'lenscap_layout_style', array(
		'default'           => 'excerpt',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'lenscap_sanitize_layout_select',
	));

	$wp_customize->add_control( 'lenscap_layout_select', array(
		'settings'    => 'lenscap_layout_style',
		'label'       => esc_html__( 'Index Post Style', 'lenscap' ),
		'section'     => 'lenscap_theme_options',
		'description' => esc_html__( 'Choose the layout for your post index, archive and search pages.', 'lenscap' ),
		'type'        => 'select',
		'choices'     => array(
			'excerpt'   => esc_html__( 'Thumbnail & Excerpt', 'lenscap' ),
			'full-post' => esc_html__( 'Full Post', 'lenscap' )
		),
		'priority' => 10
	) );


	/**
	 * Grid excerpt length
	 */
	$wp_customize->add_setting( 'lenscap_grid_excerpt_length', array(
		'default'           => '35',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_grid_excerpt_length', array(
		'type'            => 'number',
		'priority'        => 10,
		'section'         => 'lenscap_theme_options',
		'label'           => esc_html__( 'Index Post Excerpt Length', 'lenscap' ),
		'description'     => esc_html__( 'Change the size of the excerpt on index and archive posts.', 'lenscap' ),
		'active_callback' => 'lenscap_index_excerpt_callback',
		'input_attrs'     => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),
	) );


	/**
	 * Footer Category Menu
	 */
	$wp_customize->add_setting( 'lenscap_category_browse', array(
		'default'           => 'enabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'lenscap_sanitize_category_select',
	));

	$wp_customize->add_control( 'lenscap_category_browse_select', array(
		'settings'        => 'lenscap_category_browse',
		'label'           => esc_html__( 'Footer Category Menu', 'lenscap' ),
		'description'     => esc_html__( 'Show the category browsing menu below your posts on the homepage.', 'lenscap' ),
		'section'         => 'lenscap_theme_options',
		'type'            => 'select',
		'choices'  	  => array(
			'enabled'  => esc_html__( 'Enabled', 'lenscap' ),
			'disabled' => esc_html__( 'Disabled', 'lenscap' ),
		),
		'priority' => 55
	) );

	/**
	 * Footer Category Menu Title
	 */
	$wp_customize->add_setting( 'lenscap_browse_title', array(
		'sanitize_callback' => 'lenscap_sanitize_text',
		'transport'         => 'postMessage',
		'default'           => esc_html__( 'Browse Categories', 'lenscap' )
	) );

	$wp_customize->add_control( 'lenscap_browse_title', array(
		'label'           => esc_html__( 'Footer Category Menu Title', 'lenscap' ),
		'section'         => 'lenscap_theme_options',
		'settings'        => 'lenscap_browse_title',
		'description'     => esc_html__( 'Change the title of the Footer Category Menu section. Leave blank for no title.', 'lenscap' ),
		'type'            => 'text',
		'active_callback' => 'lenscap_category_menu_callback',
		'priority'        => 60
	) );



	/**
	 * Footer Background Image
	 */
	$wp_customize->add_setting( 'lenscap_footer_bg', array(
		'sanitize_callback' => 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lenscap_footer_bg', array(
		'label'    => esc_html__( 'Footer Background Image', 'lenscap' ),
		'section'  => 'lenscap_theme_options',
		'settings' => 'lenscap_footer_bg',
		'priority' => 90
	) ) );

	/**
	 * Footer background image opacity
	 */
	$wp_customize->add_setting( 'lenscap_footer_bg_opacity', array(
		'default'           => '.3',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_footer_bg_opacity', array(
		'type'            => 'range',
		'priority'        => 95,
		'section'         => 'lenscap_theme_options',
		'label'           => esc_html__( 'Footer Background Image Opacity', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the opacity of the footer background image.', 'lenscap' ),
		'active_callback' => 'lenscap_footer_image_callback',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => .05,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Footer background image blur radius
	 */
	$wp_customize->add_setting( 'lenscap_footer_bg_blur_radius', array(
		'default'           => '0',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_footer_bg_blur_radius', array(
		'type'            => 'range',
		'priority'        => 100,
		'section'         => 'lenscap_theme_options',
		'label'           => esc_html__( 'Footer Background Image Blur', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the blur effect on the footer background image.', 'lenscap' ),
		'active_callback' => 'lenscap_footer_image_callback',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 52,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Footer background Color
	 */
	$wp_customize->add_setting( 'lenscap_footer_bg_color', array(
		'default'           => '#272c30',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lenscap_footer_bg_color', array(
		'label'           => esc_html__( 'Footer Background Color', 'lenscap' ),
		'section'         => 'lenscap_theme_options',
		'settings'        => 'lenscap_footer_bg_color',
		'description'     => esc_html__( 'Change the background color of the footer area.', 'lenscap' ),
		'active_callback' => 'lenscap_footer_image_callback',
		'priority'        => 105
	) ) );


	/**
	 * Footer Tagline
	 */
	$wp_customize->add_setting( 'lenscap_footer_text', array(
		'sanitize_callback' => 'lenscap_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'lenscap_footer_text', array(
			'label'       => esc_html__( 'Footer Tagline', 'lenscap' ),
			'section'     => 'lenscap_theme_options',
			'settings'    => 'lenscap_footer_text',
			'description' => esc_html__( 'Change the text that appears in the footer tagline at the bottom of your site.', 'lenscap' ),
			'type'        => 'text',
			'priority'    => 110
		)
	);


	/**
	 * Featured Content style
	 */
	$wp_customize->add_setting( 'lenscap_featured_header_style', array(
		'default'           => 'boxed',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'lenscap_sanitize_header_style_select',
	));

	$wp_customize->add_control( 'lenscap_featured_header_style_select', array(
		'settings'        => 'lenscap_featured_header_style',
		'label'           => esc_html__( 'Header Layout Style', 'lenscap' ),
		'description'     => esc_html__( 'Choose between a full width or boxed header style.', 'lenscap' ),
		'section'         => 'featured_content',
		'type'            => 'select',
		'choices'  	  => array(
			'fullwidth' => esc_html__( 'Full Width', 'lenscap' ),
			'boxed'     => esc_html__( 'Boxed', 'lenscap' ),
		),
		'priority' => 59
	) );


	/**
	 * Featured Content Title
	 */
	$wp_customize->add_setting( 'lenscap_featured_content_title', array(
		'sanitize_callback' => 'lenscap_sanitize_text',
		'transport'         => 'postMessage',
		'default'           => esc_html__( 'Featured', 'lenscap' )
	) );

	$wp_customize->add_control( 'lenscap_featured_content_title', array(
		'label'           => esc_html__( 'Header Title', 'lenscap' ),
		'section'         => 'featured_content',
		'settings'        => 'lenscap_featured_content_title',
		'description'     => esc_html__( 'Add a title to your Featured Content section.', 'lenscap' ),
		'type'            => 'text',
		'priority'        => 60
		)
	);


	/**
	 * Featured Content text position
	 */
	$wp_customize->add_setting( 'lenscap_featured_position', array(
		'default'           => 'none',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'lenscap_sanitize_align_select',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control( 'lenscap_featured_position_select', array(
		'settings'        => 'lenscap_featured_position',
		'label'           => esc_html__( 'Header Text Position', 'lenscap' ),
		'description'     => esc_html__( 'Choose between left and right positioned text in the header.', 'lenscap' ),
		'section'         => 'featured_content',
		'type'            => 'select',
		'choices'  	  => array(
			'none'  => esc_html__( 'Left', 'lenscap' ),
			'right' => esc_html__( 'Right', 'lenscap' ),
		),
		'priority' => 65
	) );


	/**
	 * Featured content excerpt length
	 */
	$wp_customize->add_setting( 'lenscap_featured_excerpt_length', array(
		'default'           => '35',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_featured_excerpt_length', array(
		'type'        => 'number',
		'priority'    => 70,
		'section'     => 'featured_content',
		'label'       => esc_html__( 'Header Excerpt Length', 'lenscap' ),
		'description' => esc_html__( 'Change the length of the post excerpt in the Featured Content header.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),
	) );


	/**
	 * Featured content background image opacity
	 */
	$wp_customize->add_setting( 'lenscap_hero_opacity', array(
		'default'           => '.5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_hero_opacity', array(
		'type'            => 'range',
		'priority'        => 90,
		'section'         => 'featured_content',
		'label'           => esc_html__( 'Header Background Image Opacity', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the opacity of the Featured Content header background image.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => .05,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Featured Content blur radius
	 */
	$wp_customize->add_setting( 'lenscap_blur_radius', array(
		'default'           => '0',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_blur_radius', array(
		'type'            => 'range',
		'priority'        => 90,
		'section'         => 'featured_content',
		'label'           => esc_html__( 'Header Background Image Blur', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the blur effect on the Featured Content header background image.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 52,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Alpha Color Picker setting
	 */
	$wp_customize->add_setting('lenscap_hero_text_opacity', array(
			'default'           => 'rgba(27,36,48,0.7)',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'lenscap_sanitize_text',
		)
	);

	/**
	 * Alpha Color Picker control
	 */
	$wp_customize->add_control(
		new Customize_Alpha_Color_Control( $wp_customize, 'alpha_color_control', array(
				'label'        => esc_html__( 'Header Accent Color', 'lenscap' ),
				'section'      => 'featured_content',
				'settings'     => 'lenscap_hero_text_opacity',
				'show_opacity' => true,
				'priority'     => 80,
				'description'  => esc_html__( 'Change the background color of the text area and carousel navigation in the Featured Content header.', 'lenscap' ),
				'palette'      => array(
					'rgba(27,36,48,0.7)',
					'rgba(0,158,226,0.60)',
					'rgba(0,178,116,0.80)',
					'rgba(160,108,209,0.82)',
				)
			)
		)
	);


	/**
	 * Featured Content Background Color
	 */
	$wp_customize->add_setting( 'lenscap_featured_bg_color', array(
		'default'           => '#272c30',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lenscap_featured_bg_color', array(
		'label'       => esc_html__( 'Header Background Color', 'lenscap' ),
		'section'     => 'featured_content',
		'settings'    => 'lenscap_featured_bg_color',
		'description' => esc_html__( 'Change the background color of the Featured Content header. Lower the Background Image Opacity setting to see the background color.', 'lenscap' ),
		'priority'    => 85
	) ) );


	/**
	 * Featured Content Height
	 */
	$wp_customize->add_setting( 'lenscap_hero_height', array(
		'default'           => '5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_hero_height', array(
		'type'            => 'range',
		'priority'        => 90,
		'section'         => 'featured_content',
		'label'           => esc_html__( 'Header Height', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the height of the Featured Content header.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 5,
			'max'   => 15,
			'step'  => .25,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Featured content width
	 */
	$wp_customize->add_setting( 'lenscap_hero_width', array(
		'default'           => '47.5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_hero_width', array(
		'type'            => 'range',
		'priority'        => 95,
		'section'         => 'featured_content',
		'label'           => esc_html__( 'Header Text Width', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the width of the text area in the Featured Content header.', 'lenscap' ),
		'input_attrs'     => array(
			'min'   => 47.5,
			'max'   => 100,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );
}


/**
 * Adjust header height based on theme option
 */
function lenscap_css_output() {
	// Theme Options
	$accent_color  = esc_html( get_theme_mod( 'lenscap_button_color', '#1d96f3' ) );
	$text_bg_color = esc_html( get_theme_mod( 'lenscap_hero_text_opacity', '.6' ) );

	// Hero settings
	$hero_height   = esc_html( get_theme_mod( 'lenscap_hero_height', '5' ) );
	$hero_bg_color = esc_html( get_theme_mod( 'lenscap_featured_bg_color', '#272c30' ) );
	$hero_position = esc_html( get_theme_mod( 'lenscap_featured_position', 'none' ) );
	$hero_width    = esc_html( get_theme_mod( 'lenscap_hero_width', '47.5' ) );
	$hero_blur     = esc_html( get_theme_mod( 'lenscap_blur_radius', '0' ) . 'px' );
	$hero_opacity  = esc_html( get_theme_mod( 'lenscap_hero_opacity', '.3' ) );

	// Footer settings
	$footer_bg_image   = esc_html( get_theme_mod( 'lenscap_footer_bg', '' ) );
	$footer_bg_opacity = esc_html( get_theme_mod( 'lenscap_footer_bg_opacity', '.3' ) );
	$footer_bg_blur    = esc_html( get_theme_mod( 'lenscap_footer_bg_blur_radius', '0' ) . 'px' );
	$footer_bg_color   = esc_html( get_theme_mod( 'lenscap_footer_bg_color', '#272c30' ) );

	// Check for styles before outputting
	if ( $accent_color || $text_bg_color || $hero_height || $hero_bg_color || $hero_position || $hero_width || $footer_bg_image || $footer_bg_opacity || $footer_bg_blur || $footer_bg_color ) {

	wp_enqueue_style( 'lenscap-style', get_stylesheet_uri() );

	$lenscap_custom_css = "

	button, input[type='button'],
	input[type='reset'],
	input[type='submit'],
	.button,
	#page #infinite-handle button,
	#page #infinite-handle button:hover,
	.comment-navigation a,
	.drawer .tax-widget a,
	.su-button,
	h3.comments-title,
	.page-numbers.current,
	.page-numbers:hover,
	.woocommerce nav.woocommerce-pagination ul li span.current,
	.woocommerce nav.woocommerce-pagination ul li span:hover,
	.woocommerce nav.woocommerce-pagination ul li a:hover,
	a.added_to_cart,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
	.woocommerce button.button.alt,
	.woocommerce button.button.alt:hover,
	.woocommerce button.button,
	.woocommerce button.button:hover,
	.woocommerce a.button.lenscap,
	.woocommerce-cart .wc-proceed-to-lenscap a.lenscap-button,
	.woocommerce-cart .wc-proceed-to-lenscap a.lenscap-button:hover,
	.woocommerce input.button.alt,
	.woocommerce input.button.alt:hover {
	      background-color: $accent_color;
	}

	.widget-area aside .widget-title,
	.widget-area aside .widgettitle,
	.widget-area .widget-grofile h4 a,
	.site-footer .widget-title,
	.archive-header,
	.featured-content-title,
	h3.comment-reply-title,
	.category-menu-title,
	#jp-relatedposts .jp-relatedposts-headline {
		border-left-color: $accent_color;
	}

	.sort-list .current-menu-item {
		border-bottom-color: $accent_color;
	}

	.index-posts .grid-cats a,
	.grid-cats a,
	li.is-active:before,
	li:hover:before {
		color: $accent_color;
	}

	.main-navigation ul li.current-menu-item,
	.main-navigation ul li.current-page-item,
	.main-navigation ul li:hover {
		border-top-color: $accent_color;
	}

	.featured-content-posts .post .grid-text,
	.hero-pager-wrap,
	.featured-content-wrapper .slide-navs a,
	.featured-content-wrapper .featured-content-title,
	.featured-content-nav {
		background: $text_bg_color;
	}

	#hero-pager .pager-tip {
		border-bottom-color: $text_bg_color;
	}

	.featured-content-wrapper {
		background: $hero_bg_color;
	}

	.featured-content-wrapper .entry-content {
		float: $hero_position;
		width: $hero_width%;
	}

	.cover-image {
		opacity: $hero_opacity;
	}

	.blur {
		-webkit-filter: blur($hero_blur);
		filter: blur($hero_blur);
	}

	.site-footer {
		background: $footer_bg_color;
	}

	.cover-image-footer-wrap {
		opacity: $footer_bg_opacity;
		-webkit-filter: blur($footer_bg_blur);
		filter: blur($footer_bg_blur);
	}

	.featured-content-posts .post .container {
		padding-top: $hero_height%;
		padding-bottom: $hero_height%;
	}
	";
	wp_add_inline_style( 'lenscap-style', $lenscap_custom_css );
} }
add_action( 'wp_enqueue_scripts', 'lenscap_css_output' );


/**
 * Replaces the footer tagline text
 */
function lenscap_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'lenscap_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'lenscap' ), 'Lenscap', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'lenscap_footer_text', 'lenscap_filter_footer_text' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lenscap_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'lenscap_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lenscap_customize_preview_js() {
	wp_enqueue_script( 'lenscap_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20168836', true );
}
add_action( 'customize_preview_init', 'lenscap_customize_preview_js' );
