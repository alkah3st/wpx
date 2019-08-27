<?php
/**
 * Filters
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Filters;

/**
 * Changes comment form default fields.
 */
function comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', '\WPX\Filters\comment_form_defaults' );

/**
 * Add Body Classes
 */
function add_body_classes($classes) {

	global $post;

	// allows slug-based classes
	if ($post) {
		$classes[] = 'slug'.'-'.$post->post_name;
	}

	return $classes;

}
add_filter('body_class', '\WPX\Filters\add_body_classes');

/**
 * Force Yoast to bottom
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', '\WPX\Filters\yoasttobottom');

/**
 * Adds Google Map Key for ACF
 */
function my_acf_init(){
	acf_update_setting('google_api_key', 'YOUR KEY HERE');
}
// add_filter('acf/init', '\WPX\Filters\my_acf_init');

/**
 * Sample Rewrite Rules (Terms under CPT)
 *
 * @param array $rules Existing rewrite rules
 * @return array
 */
function add_rewrite_rules( $rules ) {
  $new = array();
  $new['magazine/([^/]+)/(.+)/?$'] = 'index.php?wpx-articles=$matches[2]';
  $new['magazine/(.+)/?$'] = 'index.php?wpx-issues=$matches[1]';

  return array_merge( $new, $rules ); // Ensure our rules come first
}
// add_filter( 'rewrite_rules_array', '\WPX\Filters\add_rewrite_rules' );

/**
 * Sample Rewrite Rules (for Permalink)
 * @param  [type] $post_link [description]
 * @param  [type] $post      [description]
 * @return [type]            [description]
 */
function custom_permalinks( $post_link, $post ){
	if ( is_object( $post ) && $post->post_type == 'wpx-articles' ){
		$terms = wp_get_object_terms( $post->ID, 'wpx-issues' );
		if( $terms ){
			return str_replace( '%issue%' , $terms[0]->slug , $post_link );
		}
	}
	return $post_link;
}
// add_filter( 'post_type_link', '\WPX\Filters\custom_permalinks', 1, 2 );