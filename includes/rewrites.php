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
function custom_template_pathing($template) {

	global $wp;
	global $wp_query;

	$template_vars = $wp->query_vars;

	// color map (only local)
	if ( array_key_exists( 'wpx_local', $template_vars ) && 'color-map' == $template_vars['wpx_local'] ) {
		return WPX_THEME_PATH.'/templates/color-map.php';
	}

	return $template;

}
add_action( 'template_include', '\WPX\Rewrites\custom_template_pathing' );

/**
* Custom Endpoints
**/
function custom_endpoints() {
	global $wp, $wp_rewrite;

	// special templates
	$wp->add_query_var( 'wpx_local' );

}
add_action( 'init', '\WPX\Rewrites\custom_endpoints' );

/**
* Add CPTs to Rewrite Rules
* Handles APIs under /templates/ as well as color list.
*/
function custom_rewrites() {

	add_rewrite_tag( '%api_id%', '([^/]*)' );
	add_rewrite_rule( '^api/([^/]*)/?', 'index.php?api_id=$matches[1]', 'top' );
	add_rewrite_rule( '^wpx-local/([^/]*)/?','index.php?wpx_local=$matches[1]','top');

}
add_action('init', '\WPX\Rewrites\custom_rewrites', 10);

/**
 * Custom Permalink Rules
 * Rules for creating /cpt/taxonomy/post-name/ patterns.
 * (This example uses wpx-articles with wpx-issues as the tax.)
 */
function add_rewrite_rules( $rules ) {
	$new = array();
	$new['articles/([^/]+)/(.+)/?$'] = 'index.php?wpx-articles=$matches[2]';
	$new['articles/(.+)/?$'] = 'index.php?wpx-issues=$matches[1]';

	return array_merge( $new, $rules );
}
add_filter( 'rewrite_rules_array', 'WPX\Rewrites\add_rewrite_rules' );

/**
 * Example Rewrites for Permalinks
 */
function custom_permalinks( $post_link, $post ){
	
	if ( is_object( $post ) && $post->post_type == 'wpx-articles' ){
		$terms = wp_get_object_terms( $post->ID, 'wpx-issues' );
		if( $terms ){
			$post_link = str_replace( '%issues%' , $terms[0]->slug , $post_link );
		} else {
			$post_link = str_replace( '%issues%' , 'default', $post_link );
		}
	}

	return $post_link;
}
add_filter( 'post_type_link', '\WPX\Rewrites\custom_permalinks', 1, 2 );