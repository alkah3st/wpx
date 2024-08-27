<?php
/**
 * Plugins
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Plugins;

/**
 * WP SEO in Dev
 */
if (WP_ENVIRONMENT_TYPE == 'development') {
	add_filter( 'yoast_seo_development_mode', '__return_true' );
}

/**
 * Adds Google Map Key for ACF
 */
function my_acf_google_map_api( $api ){
	$api['key'] = WPX_GMAPS_API;
	return $api;
}
// add_filter('acf/fields/google_map/api', '\WPX\Plugins\my_acf_google_map_api');


/**
 * Force Yoast to bottom
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', '\WPX\Plugins\yoasttobottom');