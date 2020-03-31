<?php
/**
 * Loops
 */
namespace WPX\Loops;

/**
 * Example Custom WP_Query
 * (includes object caching)
 */
function my_custom_query() {

	global $wp_query;

	$term = $wp_query->queried_object;

	$custom_query = wp_cache_get('wpx_queries_custom');

	if ($custom_query === false) :

		$custom_query = new \WP_Query(array(
			'posts_per_page'=> 500,
			'order'=>'ASC',
			'no_found_rows' => true,
			'post_type'=>array('post'),
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => 'uncategorized',
				),
			),
		));

		wp_cache_set( 'wpx_queries_custom', $custom_query);

	endif;

	if ( $custom_query->have_posts() ) :

		while ( $custom_query->have_posts() ) :

			$custom_query->the_post();

			global $post; 

			// include(WPX_THEME_PATH.'partials/loops/loop-custom.php');

		endwhile; 

	else :

		echo 'No posts found.';

	endif;

	wp_reset_postdata();

}