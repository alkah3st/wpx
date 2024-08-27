<?php
/**
 * Helper
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Helper;

/**
 * Get Tax Colors
 */
function get_term_color($taxonomy) {

	switch ($taxonomy) {
		case 'wpx-analysis-cats':
			return 'teal';
			break;
		case 'wpx-briefs-cats':
			return 'blue';
			break;
		case 'wpx-companies-cats':
			return 'black';
			break;
		case 'wpx-oodacons-cats':
			return 'sky';
			break;
		case 'category':
			return 'purple';
			break;
		default:
			return 'navy';
	}

}

/**
 * Get Primary Taxomomy
 */
function get_primary_tax($content_type) {

	switch ($content_type) {
		case 'wpx-analysis':
			return 'wpx-analysis-cats';
			break;
		case 'wpx-briefs':
			return 'wpx-briefs-cats';
			break;
		case 'wpx-companies':
			return 'wpx-companies-cats';
			break;
		case 'wpx-oodacons':
			return 'wpx-oodacons-cats';
			break;
		case 'wpx-oodacasts':
			return 'wpx-oodacasts-cats';
			break;
		default:
			return 'category';
	}

}

/**
 * Sort by Last Name
 */
function posts_orderby_lastname($orderby_statement) {
	$orderby_statement = "RIGHT(post_title, LOCATE(' ', CONCAT(REVERSE(post_title), ' ')) - 1) ASC";
	return $orderby_statement;
}

/**
 * Inject Classes into Custom Block
 */
function wpx_custom_block_classes( $block_content, $block ) {

	// Check if it's an ACF block
	if ( isset( $block['blockName'] ) && strpos( $block['blockName'], 'acf/' ) === 0 ) {

		$id = !empty($block['attrs']['metadata']['name']) ? sanitize_title($block['attrs']['metadata']['name']) : false;
		if( !empty($block['attrs']['anchor']) ) { $id = esc_attr($block['attrs']['anchor']); }

		// Build the class array
		$classes = array();
		$classes[] = !empty($block['attrs']['alignText']) ? 'text-align-' . $block['attrs']['alignText'] : false;
		$classes[] = !empty($block['attrs']['alignContent']) ? 'inner-align-' . $block['attrs']['alignContent'] : false;
		$classes[] = !empty($block['attrs']['fullHeight']) ? 'has-full-height' : false;
		$classes[] = !empty($block['attrs']['gradient']) ? 'has-' . $block['attrs']['gradient'] . '-gradient-background' : false;
		$classes[] = !empty($block['attrs']['backgroundColor']) ? 'has-' . $block['attrs']['backgroundColor'] . '-background-color' : false;
		$classes[] = !empty($block['attrs']['textColor']) ? 'has-' . $block['attrs']['textColor'] . '-color' : false;
		$classes[] = 'wpx-custom-block';
		$classes[] = 'block-'.str_replace('acf/', '', $block['blockName']);

		// Remove empty values
		$valid_classes = array_filter( $classes );

		// Inject the custom class into the block content
		if ( !empty( $valid_classes ) ) {
			// Ensure the block content contains the wrapper class and inject the new ones
			$block_content = preg_replace(
				'/class="/',
				'class="' . esc_attr( implode( ' ', $valid_classes ) ) . ' ',
				$block_content,
				1
			);
		}

		// Inject the custom ID into the block content
		if ( !empty( $id ) ) {
			// Ensure the block content contains the wrapper tag and inject the new ID
			$block_content = preg_replace(
				'/<([a-z0-9\-]+)([^>]*)>/',
				'<$1$2 id="' . $id . '">',
				$block_content,
				1
			);
		}

	}

	return $block_content;
}

add_filter( 'render_block', '\WPX\Helper\wpx_custom_block_classes', 10, 2 );

/**
 * Serialize for Cache
 *
 * We convert a set of params or other data into a string
 * so that this can be used as a unique ID for caching.
 * Identifier adds additional uniqueness.
 */
function serialize_cache_id($unique_data, $identifier=false) {

	$hash = md5($identifier.serialize($unique_data));

	return $hash;

}


/**
 * Record to Error Log
 */
if ( ! function_exists('write_log')) {
	function write_log ( $log )  {
		if ( is_array( $log ) || is_object( $log ) ) {
			ob_start();
			var_dump( $log );
			$contents = ob_get_contents();
			ob_end_clean(); 
			error_log( $contents );
		} else {
			error_log( $log );
		}
	}
}

/**
 * Loop
 * 
 * Renders a custom wp_query and
 * returns as object or as a query
 */
function loop($params) {

	$defaults = array (
		'query_params' => false,
		'cache_id' => false,
		'relevanssi'=>false,
		'cache_group' => false,
		'format' => 'objects',
	);

	$args = wp_parse_args( $params, $defaults );

	$custom_query = ($args['cache_group'] ? wp_cache_get($args['cache_id'], $args['cache_group']) : false);

	if ($custom_query === false) :

		$custom_query = new \WP_Query($args['query_params']);

		// apply relevanssi
		if (function_exists('relevanssi_do_query') && $args['relevanssi'] = true) {
			$custom_query = new \WP_Query();
			$custom_query->parse_query($args['query_params']);
			relevanssi_do_query($custom_query);
		} else {
			$custom_query = new \WP_Query($args['query_params']);
		}

		if ( ! is_wp_error( $custom_query ) && $custom_query->have_posts() ) {

			wp_cache_set( $args['cache_id'], $custom_query, $args['cache_group']);

		}

	endif;

	if ($args['format'] == 'objects') {

		$posts_found = false;

		if ($custom_query->have_posts()) {

			while($custom_query->have_posts()) {
				
				$custom_query->the_post();

				global $post;

				$posts_found[] = $post;

			}
		}

		wp_reset_postdata();

		return $posts_found;

	} else {

		wp_reset_postdata();

		return $custom_query;

	}

}

/**
 * Is Ancestor Of
 */
function is_ancestor_of($post=false) {

	if (!$post) global $post;

	$ancestors = get_post_ancestors($post->ID);

	// if this post is a page, and it's either the page itself, a parent, or ancestor
	if(is_page() && (is_page($post->ID) || $post->post_parent == $post->ID || in_array($post->ID, $ancestors))) {
		return true;
	} else {
		return false;
	}

}

/**
 * Get Mixed Terms
 */
function get_mixed_terms($post_id, $post_type) {

	$terms = wp_get_object_terms( $post_id, get_object_taxonomies($post_type) );

	if ($terms) {

		return $terms;

	} else {

		return false;
	}

}


