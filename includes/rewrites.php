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
 * Example Rewrites for Permalinks
 */
function custom_permalinks( $post_link, $post ){
	
	if ( is_object( $post ) && $post->post_type == 'wpx-watch' ){
		$terms = wp_get_object_terms( $post->ID, 'wpx-channels' );
		if( $terms ){
			$post_link = str_replace( '%channels%' , $terms[0]->slug , $post_link );
		} else {
			$post_link = str_replace( '%channels%' , 'channel', $post_link );
		}
	}

	if ( is_object( $post ) && $post->post_type == 'wpx-sheets' ){
		$user_id = $post->post_author;
		if( $user_id ){
			$post_link = str_replace( '%user_id%' , $user_id , $post_link );
		} else {
			$post_link = str_replace( '%user_id%' , 1, $post_link );
		}
	}

	return $post_link;
}
// add_filter( 'post_type_link', '\WPX\Rewrites\custom_permalinks', 1, 2 );


/**
* Custom Template Redirects
**/
function custom_uac_pages($template) {

	global $wp;
	global $wp_query;

	$template_vars = $wp->query_vars;

	// color map (only local)
	if ( array_key_exists( 'wpx_local', $template_vars ) && 'color-map' == $template_vars['wpx_local'] ) {
		return WPX_THEME_PATH.'/templates/api/color-map.php';
	}

	return $template;

}
add_action( 'template_include', '\WPX\Rewrites\custom_uac_pages' );

/**
 * Search Within a Taxonomy
 * 
 * Supports searching with tax_query args.
 *
 * $query = new WP_Query( array(
 *  'search_tax_query' => true,
 *  's' => $keywords,
 *  'tax_query' => array( array(
 *      'taxonomy' => 'country',
 *      'field' => 'id',
 *      'terms' => $country,
 *  ) ),
 * ) );
 */
class WP_Query_Taxonomy_Search {
	public function __construct() {
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
	}

	public function pre_get_posts( $q ) {
		if ( is_admin() ) return;

		$wp_query_search_tax_query = filter_var( 
			$q->get( 'search_tax_query' ), 
			FILTER_VALIDATE_BOOLEAN 
		);

		// WP_Query has 'tax_query', 's' and custom 'search_tax_query' argument passed
		if ( $wp_query_search_tax_query && $q->get( 'tax_query' ) && $q->get( 's' ) ) {
			add_filter( 'posts_groupby', array( $this, 'posts_groupby' ), 10, 1 );
		}
	}

	public function posts_groupby( $groupby ) {
		return '';
	}
}

new WP_Query_Taxonomy_Search();

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
*/
function custom_rewrites() {

	add_rewrite_tag( '%api_id%', '([^/]*)' );
	add_rewrite_rule( '^api/([^/]*)/?', 'index.php?api_id=$matches[1]', 'top' );
	add_rewrite_rule( '^wpx-local/([^/]*)/?','index.php?wpx_local=$matches[1]','top');

}
add_action('init', '\WPX\Rewrites\custom_rewrites', 10);