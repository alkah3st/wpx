<?php
/**
 * Sidebars
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since WPX Theme 0.1.0
 */
namespace WPX\Sidebars;

/**
 * All sidebars must be registered here.
 */
function register_sidebars() {

	$sidebars = array();

	$sidebars['page'] = array(
		'name'          => __( 'Page', 'wpx' ),
		'id'            => 'page',
		'description'   => 'Sidebar used across the site for Pages.',
		'class'         => '',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget'  => '</section>',
	);

	if (class_exists('acf')) {

		// look for any Pages that have "Create Sidebar" checked
		$all_pages = new \WP_Query(array(
			'post_type'=>"page",
			'posts_per_page'=>-1,
			'no_found_rows'=>true,
			'update_post_term_cache'=>false
		));

		if ( $all_pages->have_posts() ) :
			while ( $all_pages->have_posts() ) :
				$all_pages->the_post();
				global $post;
				$has_sidebar = get_field("field_56648d683aa4d", $post->ID);
				if ($has_sidebar) {
					$sidebars[$post->post_name] = array(
						'name'          => __( get_the_title($post->ID), 'wpx' ),
						'id'            => $post->post_name,
						'description'   => 'Sidebar unique to the '.get_the_title($post->ID).' page.',
						'class'         => '',
						'before_widget' => '<section id="%1$s" class="widget tinymce %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h3>'
					);
				}
			endwhile;
		endif;

		wp_reset_postdata();

	}

	foreach ( (array) $sidebars as $sidebar ) {
		register_sidebar( $sidebar );
	}

}

add_action( 'widgets_init', '\WPX\Sidebars\register_sidebars' );