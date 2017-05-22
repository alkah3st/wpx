<?php
/**
 * Setup
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */

/**
* Constants
*/
define( 'WPX_THEME_URL', get_bloginfo('template_url') );
define( 'WPX_THEME_PATH', dirname( __FILE__ ) . '/' );
define( 'WPX_DOMAIN', get_site_url() );
define( 'WPX_SITE_NAME', get_bloginfo('name'));
define( 'WPX_GA_ID', false);
define( 'WPX_ADDTHIS_ID', false);

/**
 * Functions
*/
require_once(WPX_THEME_PATH."includes/actions.php");
require_once(WPX_THEME_PATH."includes/filters.php");
require_once(WPX_THEME_PATH."includes/sidebars.php");
require_once(WPX_THEME_PATH."includes/enqueue.php");
require_once(WPX_THEME_PATH."includes/rewrites.php");

/**
 * Widgets
*/
require_once(WPX_THEME_PATH."includes/widgets/categories.php");

/**
 * CPTs & Taxonomies
 */
function wpx_architecture() {

	// include taxonomies
	require_once(WPX_THEME_PATH."includes/taxonomies/industries.php");

	// include cpts
	require_once(WPX_THEME_PATH."includes/content-types/portfolio.php");

	// header/footer settings
	if( function_exists('acf_add_options_page') ) {
		
		// add parent
		$parent = acf_add_options_page(array(
			'page_title' 	=> 'Theme Settings',
			'menu_title' 	=> 'Options',
			'redirect' 		=> false,
			'icon_url' => 'dashicons-analytics',
			'position' => 78
		));

		// add sub page
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Sitewide Settings',
			'menu_title' 	=> 'Sitewide',
			'parent_slug' 	=> $parent['menu_slug'],
		));

		// add sub page
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Home Page Settings',
			'menu_title' 	=> 'Home',
			'parent_slug' 	=> $parent['menu_slug'],
		));

	}


}
add_action( 'init', 'wpx_architecture', 5);

/**
 * Theme Setup
 */
function wpx_setup() {

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails', array('post','page') );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// enable excerpt meta box for Pages
	add_post_type_support('page', 'excerpt');

	// hide version #
	remove_action('wp_head', 'wp_generator');

	// nav menus
	register_nav_menus( array(
		'primary' => 'Primary Navigation'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('image', 'video', 'link', 'gallery','audio') );

	// image crops
	set_post_thumbnail_size( 640, 480, true );
	add_image_size( 'custom-image-size', 850, 400, true );

}
add_action( 'after_setup_theme', 'wpx_setup', 0 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpx_content_width() {

	$content_width = 990;

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'after_setup_theme', 'wpx_content_width', 0 );

/**
* Pre Get Posts
*/
function wpx_pre_get_posts( $wp_query ) {
	if ( $wp_query->is_feed() ) {
		$wp_query->set( 'post_type', array( 'post', 'page') );
		return $wp_query;
	}
}
add_action( 'pre_get_posts', 'wpx_pre_get_posts' );

/**
 * Assets Path
 */
function assets_url() {
	return WPX_THEME_URL.'/assets';
}