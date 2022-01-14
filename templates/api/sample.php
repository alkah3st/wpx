<?php
/**
* API: Map Markers
* 
* @package WordPress
* @subpackage WPX_Theme
* @since WPX Theme 0.1.0
*/
namespace WPX\API\Example;

function api_response() {

	global $wp_query;

	$api_id = $wp_query->get( 'api_id' );

	if ($api_id == 'example') {

		// gather data
		$data  = array(
			'format' => !empty($_POST['wpx_format']) ? $_POST['wpx_format'] : false,
			'orderby' => !empty($_POST['wpx_orderby']) ? $_POST['wpx_orderby'] : false,
			'author' => !empty($_POST['wpx_author']) ? (int)$_POST['wpx_author'] : false,
			'search' => !empty($_POST['wpx_search']) ? (int)$_POST['wpx_search'] : false,
			'tax_terms' => !empty($_POST['wpx_terms']) ? $_POST['wpx_terms'] : false,
			'search' => !empty($_POST['wpx_search']) ? $_POST['wpx_search'] : false,
			'paged' => !empty($_POST['wpx_paged']) ? (int)$_POST['wpx_paged'] : false,
			'count' => !empty($_POST['wpx_count']) ? (int)$_POST['wpx_count'] : false,
			'cpts' => !empty($_POST['wpx_cpts']) ? $_POST['wpx_cpts'] : false,
			'order' => !empty($_POST['wpx_order']) ? $_POST['wpx_order'] : false,
			'sort' => !empty($_POST['wpx_sort']) ? $_POST['wpx_sort'] : false,
			'persistent_terms' => !empty($_POST['wpx_persistent_terms']) ? $_POST['wpx_persistent_terms'] : false,
			'exclusions' => !empty($_POST['wpx_exclusions']) ? $_POST['wpx_exclusions'] : false,
			'meta_sort' => !empty($_POST['wpx_meta_sort']) ? $_POST['wpx_meta_sort'] : false,
			'parents_only' => !empty($_POST['wpx_parents_only']) ? $_POST['wpx_parents_only'] : false
		);

		// handle booleans
		foreach($data as $i=>$datum) {
			if ($datum === "false" || $datum == '') {
				$data[$i] = filter_var($datum, FILTER_VALIDATE_BOOLEAN);
			}
		}

		// merge like-term arrays
		// (we are not counting uniques until now)
		$term_set = false;
		if ($data['tax_terms']) {
			foreach($data['tax_terms'] as $term_array) {
				$taxonomy = $term_array[0];
				$term = $term_array[1];
				// select2 dropdowns that are multi-term selectors
				// will return an array; all others return a string
				if (is_string($term)) {
					$term_set[$taxonomy][] = $term;
				} else {
					$term_set[$taxonomy] = $term;
				}
			}
		}

		// base parameters
		$parameters = array(
			'posts_per_page'=>intval($data['count']),
			'post_type'=>$data['cpts'],
		);

		// if exclusions
		if ($data['exclusions']) {
			$parameters['posts__not_in'] = explode(',',$data['exclusions']);
		}

		// if paged
		if ($data['paged']) {
			$parameters['paged'] = intval($data['paged']);
		}

		// if implicit order
		if ($data['order']) {
			$parameters['order'] = $data['order'];
		}

		// if parents only
		if ($data['parents_only']) {
			$parameters['post_parent'] = 0;
		}

		// if implicit sort
		if ($data['orderby']) {
			$parameters['orderby'] = $data['orderby'];
		}

		// if author
		if ($data['author']) {
			$parameters['author'] = $data['author'];
		}

		// if search
		if ($data['search']) {
			$parameters['s'] = $data['search'];
		}

		// if a meta sort order
		if ($data['meta_sort']) {

			// sort by meta key
			$parameters['meta_key'] = $data['meta_sort'];
			$parameters['orderby'] = 'meta_value';

			// if numeric sort
			if ($data['sort'] == 'numeric' ) {
				// it's more intuitive for DESC and ASC to reverse
				if ($data['order'] == 'DESC') {
					$parameters['order'] = 'ASC';
				} else {
					$parameters['order'] = 'DESC';
				}
				// also instruct this is numeric
				$parameters['orderby'] = 'meta_value_num';
			}

		}

		// if tax terms
		if ($term_set) {
			if (count($term_set) > 1) {
				$parameters['tax_query']['relation'] = 'AND';
			}
			foreach($term_set as $taxonomy=>$terms) {
				$parameters['tax_query'][] = array(
					'taxonomy'=>$taxonomy,
					'field'=>'term_id',
					'terms'=>$terms,
					'operator'=>'AND'
				);
			}
		}

		// instantiate the query
		$stream = new \WP_Query();
		$stream->parse_query($parameters);

		// apply relevanssi
		if (function_exists('relevanssi_do_query')) {
			relevanssi_do_query($stream);
		}

		if ( $stream->have_posts()) {

			while ( $stream->have_posts() ) {
				
				$stream->the_post();

				global $post;

				// output

			}

			wp_pagenavi(array('query'=>$stream));

		} else {

			echo 'No posts found.';
		}

		if (WP_ENVIRONMENT_TYPE == 'development' || WP_ENVIRONMENT_TYPE == 'staging') :
			echo '<script>';
			echo 'console.log('.json_encode($parameters).');';
			echo '</script>';
		endif;

		exit;

	}

}
add_action( 'template_redirect', '\WPX\API\Example\api_response' );