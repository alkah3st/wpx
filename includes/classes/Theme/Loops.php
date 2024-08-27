<?php
/**
 * Loops
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Classes\UI;

class Loops {

	function get_latest_posts() {

		$parameters = array(
			'posts_per_page'=>9,
			'post_type'=>'post',
			'orderby'=>'date',
			'order'=>'DESC'
		);
		
		$loop_params = array (
			'query_params' => $parameters,
			'cache_id' => \WPX\Helper\serialize_cache_id($parameters),
			'relevanssi'=> false,
			'cache_group' => 'wpx-loops',
			'format' => 'objects',
		);

		$results = \WPX\Helper\loop($loop_params);

		if ($results) {

			return $results;

		} else {

			return false;
		}

	}

	function get_posts_in_category($term=false, $excluded_post=false) {

		$parameters = array(
			'posts_per_page'=>3,
			'post_type'=>'post',
			'orderby'=>'date',
			'order'=>'DESC'
		);

		if ($excluded_post) {
			$parameters['post__not_in'] = array($excluded_post->ID);
		}

		if ($term) {

			$parameters['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $term->term_id,
					'operator'=>'IN'
				),
			);

		}
		
		$loop_params = array (
			'query_params' => $parameters,
			'cache_id' => \WPX\Helper\serialize_cache_id($parameters),
			'relevanssi'=> false,
			'cache_group' => 'wpx-loops',
			'format' => 'objects',
		);

		$results = \WPX\Helper\loop($loop_params);

		if ($results) {

			return $results;

		} else {

			return false;
		}

	}

}