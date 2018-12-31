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
 * Move Featured Image Metabox
 * (after Publish box)
 */
add_action('add_meta_boxes', function() {
	add_meta_box('submitdiv', __('Publish'), 'post_submit_meta_box', 'post', 'side', 'high');
	add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'post', 'side', 'high');
});

/**
 * Featured Image Instructions
 * @param [type] $content [description]
 */
function add_featured_image_instruction( $content ) {
	return $content .= "<p class='description'>The Featured Image should be at least TKxTK pixels, and it will be cropped to fit.</p>";
}
add_filter( 'admin_post_thumbnail_html', '\WPX\Filters\add_featured_image_instruction');

/**
 * Change text for the post excerpt
 *
 * @since 1.0.0
 * @param string $translated_text
 * @param string $text
 * @param string $domain
 * @return string 
 */
function change_excerpt_name( $translation, $original ) {
	if ( 'Excerpt' == $original ) {
		return 'Excerpt';
	} else {
		$pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your content that can be');
		if ($pos !== false) {
			return  'This text is used as a teaser of the post\'s content in any archive. Try to keep it to a single sentence. It\'s also used as the meta description for the post. If you need the meta description to be different than the teaser, use the Yoast SEO panel below to specify a unique meta description.';
		}
	}
	return $translation;
}
add_filter( 'gettext', '\WPX\Filters\change_excerpt_name', 10, 2 );

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
 * Stop WP from Rearranging Terms
 *
 * WP by default puts the selected term in the term metabox on top after
 * the post is saved. This prevents WP from doing that.
 * 
 */
function stop_reordering_my_categories($args) {
	$args['checked_ontop'] = false;
	return $args;
}

add_filter('wp_terms_checklist_args','\WPX\Filters\stop_reordering_my_categories');

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
 * Tell WordPress how to interpret our custom URL structure
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
add_filter( 'rewrite_rules_array', '\WPX\Filters\add_rewrite_rules' );

function custom_permalinks( $post_link, $post ){
	if ( is_object( $post ) && $post->post_type == 'wpx-articles' ){
		$terms = wp_get_object_terms( $post->ID, 'wpx-issues' );
		if( $terms ){
			return str_replace( '%issue%' , $terms[0]->slug , $post_link );
		}
	}
	return $post_link;
}
add_filter( 'post_type_link', '\WPX\Filters\custom_permalinks', 1, 2 );

/**
 * For ACF Icon Field
 */
function acf_icon_path_suffix( $path_suffix ) {
	return 'assets/fonts/icons/svg/';
}
add_filter( 'acf_icon_path_suffix', '\WPX\Filters\acf_icon_path_suffix' );