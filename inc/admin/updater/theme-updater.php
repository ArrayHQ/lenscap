<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'Array_Theme_Updater_Admin' ) ) {
	include( get_template_directory() . '/inc/admin/updater/theme-updater-admin.php' );
}

// The theme version to use in the updater
define( 'LENSCAP_SL_THEME_VERSION', wp_get_theme( 'lenscap' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Lenscap WordPress Theme', 'lenscap' ),
		'theme_slug'     => 'lenscap',
		'version'        => LENSCAP_SL_THEME_VERSION,
		'author'         => __( 'Array', 'lenscap' ),
		'download_id'    => '126422',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'lenscap' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'lenscap' ),
		'license-key'               => __( 'Enter your license key', 'lenscap' ),
		'license-action'            => __( 'License Action', 'lenscap' ),
		'deactivate-license'        => __( 'Deactivate License', 'lenscap' ),
		'activate-license'          => __( 'Activate License', 'lenscap' ),
		'save-license'              => __( 'Save License', 'lenscap' ),
		'status-unknown'            => __( 'License status is unknown.', 'lenscap' ),
		'renew'                     => __( 'Renew?', 'lenscap' ),
		'unlimited'                 => __( 'unlimited', 'lenscap' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'lenscap' ),
		'expires%s'                 => __( 'Your license for Lenscap expires %s.', 'lenscap' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'lenscap' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'lenscap' ),
		'license-key-expired'       => __( 'License key has expired.', 'lenscap' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'lenscap' ),
		'license-is-inactive'       => __( 'License is inactive.', 'lenscap' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'lenscap' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'lenscap' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'lenscap' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'lenscap' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'lenscap' )
	)

);