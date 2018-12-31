<?php
/**
 * Custom Rewrite Rules
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Rewrites;

/**
* Custom Template Redirects
**/
function custom_template_redirects() {
	
	global $wp;
	global $wp_query;

	$template = $wp->query_vars;

	if ( array_key_exists( 'wpx_template', $template ) && 'email' == $template['wpx_template'] ) {
		$wp_query->set( 'is_404', false );
		// include( WPX_THEME_PATH.'/templates/api/email.php' );
		exit;
	}

}
add_action( 'template_redirect', '\WPX\Rewrites\custom_template_redirects' );

/**
* Custom Endpoints
**/
function custom_endpoints() {
	global $wp, $wp_rewrite;

	// subsections
	$wp->add_query_var( 'wpx_template' );

}
add_action( 'init', '\WPX\Rewrites\custom_endpoints' );

/**
* Add CPTs to Rewrite Rules
*/
function custom_rewrites() {

	// api
	// add_rewrite_rule( '^api/([^/]*)/?','index.php?wpx_template=$matches[1]','top');

}
add_action('init', '\WPX\Rewrites\custom_rewrites', 10);