<?php
/**
* API: Archive
* 
* @package WordPress
* @subpackage WPX_Theme
* @since WPX Theme 0.1.0
*/

// filter settings
$page = isset($_POST['wpx_page']) ? $_POST['wpx_page'] : 0;
$filters = isset($_POST['wpx_terms']) ? $_POST['wpx_terms'] : false;
$cpts = isset($_POST['wpx_cpts']) ? $_POST['wpx_cpts'] : false;
$loop = isset($_POST['wpx_loop']) ? $_POST['wpx_loop'] : false;
$post_count = isset($_POST['wpx_count']) ? $_POST['wpx_count'] : false;
$orderby = isset($_POST['wpx_orderby']) ? $_POST['wpx_orderby'] : false;
$order = isset($_POST['wpx_order']) ? $_POST['wpx_order'] : false;

// set up parameters
$parameters = array(
	'posts_per_page'=> $post_count,
	'post_type'=>$cpts
);

// do we have paging?
if ($page) {
	$parameters['paged'] = (int)$page;
}

// apply any taxonomies
$taxonomy_domain = false;

// set order or orderby
if ($order) { $parameters['order'] = $order; }

if ($filters) {

	foreach($filters as $taxonomy=>$terms) {
		if ($taxonomy == 'year') {
			$parameters['year'] = $terms;
		} else {
			$taxonomy_domain[] = array($taxonomy, $terms);
		}
	}

	if ($taxonomy_domain) {

		if (count($taxonomy_domain) > 1) {
			$parameters['tax_query']['relation'] = 'AND';
		}

		foreach($taxonomy_domain as $taxonomy) {

			$parameters['tax_query'][] = array(
				'taxonomy' => $taxonomy[0],
				'field'=>'slug',
				'include_children'=>true,
				'terms' => $taxonomy[1],
				'operator'=> 'AND'
			);

		}
	}

}

$stream = new WP_Query($parameters);

if ( $stream->have_posts() ) {

	while ( $stream->have_posts() ) {
		
		$stream->the_post();

		global $post;

		$total = $stream->max_num_pages;

		if ($loop == 'post') {
			// include(WPX_THEME_PATH.'/partials/loop/loop-'.$loop.'.php');
		} else {
			// include(WPX_THEME_PATH.'/partials/loop/loop-stories.php');
		}

	}

}

if (WP_DEBUG == true) :
	echo '<script>';
	echo 'console.log('.json_encode($parameters).');';
	echo '</script>';
endif;