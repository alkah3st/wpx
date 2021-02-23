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
 * Add API Endpoints
 */
function prefix_add_api_endpoints() {
	add_rewrite_tag( '%api_id%', '([^/]*)' );
	add_rewrite_rule( '^api/([^/]*)/?', 'index.php?api_id=$matches[1]', 'top' );
}
add_action( 'init', '\WPX\Rewrites\prefix_add_api_endpoints' );

/**
* Custom Template Redirects
**/
function custom_template_redirects($template) {
	
	global $wp;
	global $wp_query;

	$template_vars = $wp->query_vars;

	// example "user/account" page without an existing page in WP
	if ( array_key_exists( 'wpx_user', $template_vars ) && 'account' == $template_vars['wpx_user'] ) {
		return WPX_THEME_PATH.'/templates/user/account.php';
	}

	// color map (only local)
	if ( array_key_exists( 'wpx_local', $template_vars ) && 'color-map' == $template_vars['wpx_local'] ) {
		return WPX_THEME_PATH.'/templates/color-map.php';
	}

	return $template;

}
add_action( 'template_include', '\WPX\Rewrites\custom_template_redirects' );

/**
* Custom Endpoints
**/
function custom_endpoints() {
	global $wp, $wp_rewrite;

	// subsections
	$wp->add_query_var( 'wpx_user' );
	$wp->add_query_var( 'wpx_local' );

}
add_action( 'init', '\WPX\Rewrites\custom_endpoints' );

/**
* Add CPTs to Rewrite Rules
*/
function custom_rewrites() {

	// api
	add_rewrite_rule( '^user/([^/]*)/?','index.php?wpx_user=$matches[1]','top');
	add_rewrite_rule( '^wpx-local/([^/]*)/?','index.php?wpx_local=$matches[1]','top');

}
add_action('init', '\WPX\Rewrites\custom_rewrites', 10);