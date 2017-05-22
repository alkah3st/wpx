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
 * Remove Yoast SEO Columns
 */
function remove_seo_columns( $columns ) {
	// remove the Yoast SEO columns
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );
	return $columns;
}
add_filter ( 'manage_edit-post_columns', '\WPX\Filters\remove_seo_columns' );


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