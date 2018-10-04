<?php
/**
 * Lenscap Theme Customizer
 *
 * @package Lenscap
 */

add_action( 'customize_register', 'lenscap_woo_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}


/**
 * WooCommerce tags dropdown
 */
function lenscap_woo_tags_select() {

	$results = array(
		'' => esc_html__( 'None', 'lenscap' )
	);

	$woo_tags = get_terms( 'product_tag', array( 'hide_empty' => false ) );

	if ( class_exists( 'WooCommerce' ) && $woo_tags ) {
		foreach( $woo_tags as $key => $value ) {
			$results[$value->slug] = $value->name;
		}
	}
	return $results;
}


/**
 * Sanitizes the WooCommerce tag select
 */
function lenscap_sanitize_woo_tag( $input ) {
	$args = array(
		'hide_empty' => false,
		'slug'       => $input
	);
	$valid = get_terms( 'product_tag', $args );

	if( ! empty( $valid ) ) {
		return $input;
	} else {
		return '';
	}
}


/**
 * WooCommerce callback
 */
function lenscap_is_woo() {
	if ( class_exists( 'WooCommerce' ) )
		return true;
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function lenscap_woo_register( $wp_customize ) {

	/**
	 * WooCommerce Options Panel
	 */
	$wp_customize->add_section( 'lenscap_woo_options', array(
		'priority'   => 2,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'WooCommerce Settings', 'lenscap' ),
		'panel'      => 'lenscap_theme_options_panel',
	) );


	/**
	 * WooCommerce Featured Tag Select
	 */
	$wp_customize->add_setting( 'lenscap_woo_tag_select', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'lenscap_sanitize_woo_tag',
	) );

	$wp_customize->add_control( 'lenscap_woo_tag_select', array(
		'settings'        => 'lenscap_woo_tag_select',
		'label'           => __( 'Featured Product Tag', 'lenscap' ),
		'description'     => esc_html__( 'Choose a tag to feature in the Featured Product header on the Shop Homepage template.', 'lenscap' ),
		'section'         => 'lenscap_woo_options',
		'priority'        => 1,
		'type'            => 'select',
		'active_callback' => 'lenscap_is_woo',
		'choices'         => lenscap_woo_tags_select(),
	) );


	/**
	 * Featured Product style
	 */
	$wp_customize->add_setting( 'lenscap_featured_header_style_woo', array(
		'default'           => 'boxed',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'lenscap_sanitize_header_style_select',
	));

	$wp_customize->add_control( 'lenscap_featured_header_style_select_woo', array(
		'settings'        => 'lenscap_featured_header_style_woo',
		'label'           => esc_html__( 'Featured Product Layout Style', 'lenscap' ),
		'description'     => esc_html__( 'Choose between a full width or boxed header style.', 'lenscap' ),
		'section'         => 'lenscap_woo_options',
		'type'            => 'select',
		'choices'  	  => array(
			'fullwidth' => esc_html__( 'Full Width', 'lenscap' ),
			'boxed'     => esc_html__( 'Boxed', 'lenscap' ),
		),
		'priority' => 59
	) );


	/**
	 * Featured Product excerpt length
	 */
	$wp_customize->add_setting( 'lenscap_featured_excerpt_length_woo', array(
		'default'           => '35',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_featured_excerpt_length_woo', array(
		'type'        => 'number',
		'priority'    => 70,
		'section'     => 'lenscap_woo_options',
		'label'       => esc_html__( 'Featured Product Excerpt Length', 'lenscap' ),
		'description' => esc_html__( 'Change the length of the post excerpt in the Featured Product header.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),
	) );


	/**
	 * Featured Product background image opacity
	 */
	$wp_customize->add_setting( 'lenscap_hero_opacity_woo', array(
		'default'           => '.5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_hero_opacity_woo', array(
		'type'            => 'range',
		'priority'        => 90,
		'section'         => 'lenscap_woo_options',
		'label'           => esc_html__( 'Featured Product Background Image Opacity', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the opacity of the Featured Product header background image.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => .05,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Featured Product blur radius
	 */
	$wp_customize->add_setting( 'lenscap_blur_radius_woo', array(
		'default'           => '20',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_blur_radius_woo', array(
		'type'            => 'range',
		'priority'        => 90,
		'section'         => 'lenscap_woo_options',
		'label'           => esc_html__( 'Featured Product Background Image Blur', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the blur effect on the Featured Product header background image.', 'lenscap' ),
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
	$wp_customize->add_setting('lenscap_hero_text_opacity_woo', array(
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
		new Customize_Alpha_Color_Control( $wp_customize, 'alpha_color_control_woo', array(
				'label'        => esc_html__( 'Featured Product Accent Color', 'lenscap' ),
				'section'      => 'lenscap_woo_options',
				'settings'     => 'lenscap_hero_text_opacity_woo',
				'show_opacity' => true,
				'priority'     => 80,
				'description'  => esc_html__( 'Change the background color of the text area and carousel navigation in the Featured Product header.', 'lenscap' ),
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
	 * Featured Product Background Color
	 */
	$wp_customize->add_setting( 'lenscap_featured_bg_color_woo', array(
		'default'           => '#272c30',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lenscap_featured_bg_color_woo', array(
		'label'       => esc_html__( 'Featured Product Background Color', 'lenscap' ),
		'section'     => 'lenscap_woo_options',
		'settings'    => 'lenscap_featured_bg_color_woo',
		'description' => esc_html__( 'Change the background color of the Featured Product header. Lower the Background Image Opacity setting to see the background color.', 'lenscap' ),
		'priority'    => 85
	) ) );


	/**
	 * Featured Product Height
	 */
	$wp_customize->add_setting( 'lenscap_hero_height_woo', array(
		'default'           => '5',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'lenscap_sanitize_range',
	) );

	$wp_customize->add_control( 'lenscap_hero_height_woo', array(
		'type'            => 'range',
		'priority'        => 90,
		'section'         => 'lenscap_woo_options',
		'label'           => esc_html__( 'Featured Product Height', 'lenscap' ),
		'description'     => esc_html__( 'Adjust the height of the Featured Product header.', 'lenscap' ),
		'input_attrs' => array(
			'min'   => 5,
			'max'   => 15,
			'step'  => .25,
			'style' => 'width: 100%',
		),
	) );
}


/**
 * Adjust header height based on theme option
 */
function lenscap_css_output_woo() {

	// Hero settings
	$text_bg_color = esc_html( get_theme_mod( 'lenscap_hero_text_opacity_woo', '.6' ) );
	$hero_height   = esc_html( get_theme_mod( 'lenscap_hero_height_woo', '5' ) );
	$hero_bg_color = esc_html( get_theme_mod( 'lenscap_featured_bg_color_woo', '#272c30' ) );
	$hero_position = esc_html( get_theme_mod( 'lenscap_featured_position_woo', 'none' ) );
	$hero_width    = esc_html( get_theme_mod( 'lenscap_hero_width_woo', '47.5' ) );
	$hero_blur     = esc_html( get_theme_mod( 'lenscap_blur_radius_woo', '0' ) . 'px' );
	$hero_opacity  = esc_html( get_theme_mod( 'lenscap_hero_opacity_woo', '.3' ) );

	// Check for styles before outputting
	if ( $text_bg_color || $hero_height || $hero_bg_color || $hero_position || $hero_width ) {

	wp_enqueue_style( 'lenscap-style', get_stylesheet_uri() );

	$lenscap_custom_css = "

	.featured-content-woo .featured-content-posts .post .grid-text,
	.featured-content-woo .hero-pager-wrap,
	.featured-content-woo .slide-navs a,
	.featured-content-woo .featured-content-title,
	.featured-content-woo .featured-content-nav {
		background: $text_bg_color;
	}

	.featured-content-woo #hero-pager .pager-tip {
		border-bottom-color: $text_bg_color;
	}

	.featured-content-woo {
		background: $hero_bg_color;
	}

	.featured-content-woo .entry-content {
		float: $hero_position;
		width: $hero_width%;
	}

	.featured-content-woo .cover-image {
		opacity: $hero_opacity;
	}

	.featured-content-woo .featured-content-posts .post .container {
		padding-top: $hero_height%;
		padding-bottom: $hero_height%;
	}
	";
	wp_add_inline_style( 'lenscap-style', $lenscap_custom_css );
} }
add_action( 'wp_enqueue_scripts', 'lenscap_css_output_woo' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lenscap_customize_preview_js_woo() {
	wp_enqueue_script( 'lenscap_customizer_woo', get_template_directory_uri() . '/woocommerce/customizer-woo.js', array( 'customize-preview' ), '20161021', true );
}
add_action( 'customize_preview_init', 'lenscap_customize_preview_js_woo' );