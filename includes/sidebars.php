<?php
/**
 * Sidebars
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
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

	foreach ( (array) $sidebars as $sidebar ) {
		register_sidebar( $sidebar );
	}

}
add_action( 'widgets_init', '\WPX\Sidebars\register_sidebars' );