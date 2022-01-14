<?php
/**
 * Filters
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Templates;

/**
 * Remove "Archive:"" from Archive Titles
 */
 add_filter( 'get_the_archive_title', function ($title) {
	if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tax() ) { //for custom post types
			$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
		} elseif (is_post_type_archive()) {
			$title = post_type_archive_title( '', false );
		}
	return $title;
});

/**
 * Add Body Classes
 */
function add_body_classes($classes) {

	global $post;
	global $wp;
	$template = $wp->query_vars;

	// allows slug-based classes
	if ($post) {
		$classes[] = 'slug'.'-'.$post->post_name;
	}

	return $classes;

}
add_filter('body_class', '\WPX\Templates\add_body_classes');


/**
 * Example ACF Menu Field
 */
function nav_menu_icons( $items, $args ) {
	
	// loop
	foreach( $items as &$item ) {
		
		// vars
		$icon = get_field('icon', $item);
		
		
		// append icon
		if( $icon ) {
			
			$item->title = '<i class="icon-'.$icon.'"></i>'.$item->title;
			
		}
		
	}
	
	
	// return
	return $items;
	
}
// add_filter('wp_nav_menu_objects', '\WPX\Templates\nav_menu_icons', 10, 2);
