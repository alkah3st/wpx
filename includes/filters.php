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

// Disable WordPress image compression
add_filter( 'jpeg_quality', function( $arg ) {
	return 100;
});

/**
 * Adds Google Map Key for ACF
 */
function my_acf_google_map_api( $api ){
	$api['key'] = WPX_GMAPS_API;
	return $api;
}
add_filter('acf/fields/google_map/api', '\WPX\Filters\my_acf_google_map_api');

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
 * Don't Count Trackbacks
 */
function exclude_trackbacks( $count ) {
	global $id;
	$comments = get_approved_comments($id);
	$comment_count = 0;
	foreach($comments as $comment){
		if($comment->comment_type == ""){
			$comment_count++;
		}
	}
	return $comment_count;
}

add_filter('get_comments_number', '\WPX\Filters\exclude_trackbacks', 0);

/**
 * Change Comment Field Order
 */
function comment_field_order( $fields ) {
	$comment_field = $fields['comment'];
	$author_field = $fields['author'];
	$email_field = $fields['email'];
	$url_field = $fields['url'];
	unset( $fields['comment'] );
	unset( $fields['author'] );
	unset( $fields['email'] );
	unset( $fields['url'] );
	// the order of fields is the order below, change it as needed:
	$fields['author'] = $author_field;
	$fields['email'] = $email_field;
	$fields['url'] = $url_field;
	$fields['comment'] = $comment_field;
	// done ordering, now return the fields:
	return $fields;
}
add_filter( 'comment_form_fields', '\WPX\Filters\comment_field_order' );

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
 * Disable Specific Blocks in Gutenberg
 * @param  [type] $allowed_blocks [description]
 * @return [type]                 [description]
 */
function remove_default_blocks($allowed_blocks){
	// Get all registered blocks
	$registered_blocks =\ WP_Block_Type_Registry::get_instance()->get_all_registered();

	// Disable default Blocks you want to remove individually
	unset($registered_blocks['core/calendar']);
	unset($registered_blocks['core/legacy-widget']);
	unset($registered_blocks['core/rss']);
	unset($registered_blocks['core/archives']);
	unset($registered_blocks['core/categories']);
	unset($registered_blocks['core/latest-comments']);
	unset($registered_blocks['core/latest-posts']);
	unset($registered_blocks['core/social-links']);
	unset($registered_blocks['core/search']);
	unset($registered_blocks['core/tag-cloud']);


	// Get keys from array
	$registered_blocks = array_keys($registered_blocks);

	// Merge allowed core blocks with plugins blocks
	return $registered_blocks;
}

add_filter('allowed_block_types', '\WPX\Filters\remove_default_blocks');

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