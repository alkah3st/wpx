<?php
/**
* API: Archive
* 
* @package WordPress
* @subpackage WPX_Theme
* @since WPX Theme 0.1.0
*/
namespace WPX\API\Archive;

function get_api_response() {

	global $wp_query;

	$api_id = $wp_query->get( 'api_id' );

	if ($api_id == 'archive') {

		// filter settings
		$loop = !empty($_POST['wpx_loop']) ? $_POST['wpx_loop'] : false;
		$tax_terms = !empty($_POST['wpx_terms']) ? $_POST['wpx_terms'] : false;
		$search = !empty($_POST['wpx_search']) ? $_POST['wpx_search'] : false;
		$paged = !empty($_POST['wpx_paged']) ? $_POST['wpx_paged'] : false;
		$count = !empty($_POST['wpx_count']) ? $_POST['wpx_count'] : false;
		$cpts = !empty($_POST['wpx_cpts']) ? $_POST['wpx_cpts'] : false;
		$order = !empty($_POST['wpx_order']) ? $_POST['wpx_order'] : false;
		$loop = !empty($_POST['wpx_loop']) ? $_POST['wpx_loop'] : false;
		$az = !empty($_POST['wpx_az']) ? $_POST['wpx_az'] : false;

		// base parameters
		$parameters = array(
			'posts_per_page'=> intval($count),
			'post_type'=>$cpts,
			'post_parent'=>0 // excludes wpx-locations that are children
		);

		// if paged
		if ($paged) {
			$parameters['paged'] = $paged;
		}

		// if implicit order
		if ($order) {
			$parameters['orderby'] = $order;
		}

		// if search
		if ($search) {
			$parameters['s'] = $search;
		}

		// if az; override order to be alpha based
		if ($az) {

			// get the next letter for between comparison
			$current_letter = $az;
			$next_letter = ++$current_letter; 
			if (strlen($next_letter) > 1) { // if you go beyond z or Z reset to a or A
				$next_letter = $next_letter[0];
			}

			$comparison = 'BETWEEN';
			$range = ''.$az.','.$next_letter.'';

			// handle Z (between does not work)
			if ($az == "Z") {
				$range = 'Z';
				$comparison = '>=';
			}

			// handle A
			if ($az == "A") {
				$range = 'A,B';
			}

			$parameters['orderby'] = 'meta_value';
			$parameters['meta_key'] = 'sort_title';
			$parameters['order'] = 'ASC';
			$parameters['meta_query'][] = array(
				'key'=>'sort_title',
				'value'=>$range,
				'compare'=>$comparison
			);
		}

		// if tax terms
		if ($tax_terms) {
			if (count($tax_terms) > 1) {
				$parameters['tax_query']['relation'] = 'AND';
			}
			foreach($tax_terms as $taxonomy=>$terms) {
				$parameters['tax_query'][] = array(
					'taxonomy'=>$taxonomy,
					'field'=>'slug',
					'terms'=>$terms,
					'operator'=>'IN'
				);
			}
		}

		$stream = new \WP_Query($parameters);

		if ( $stream->have_posts() && $loop) {

			while ( $stream->have_posts() ) {
				
				$stream->the_post();

				global $post;

				// do loop output

			}

			wp_pagenavi(array('query'=>$stream));

			echo '<div data-archive-number-value="'.$stream->found_posts.'"></div>';

		} else {

			echo '<p class="archive-empty">We didn\'t find any posts for that query.</p>';
		}

		if (WP_ENVIRONMENT_TYPE == 'development' || WP_ENVIRONMENT_TYPE == 'staging') :
			echo '<script>';
			echo 'console.log('.json_encode($parameters).');';
			echo '</script>';
		endif;

		exit;

	}

}
add_action( 'template_redirect', '\WPX\API\Archive\get_api_response' );