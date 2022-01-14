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
define( 'WPX_GMAPS_API', false);

/**
 * Classes
*/
function wpx_autoloader($class) {
	$namespace = 'WPX\Classes';
 
	if (strpos($class, $namespace) !== 0) {
		return;
	}
 
	$class = str_replace($namespace, '', $class);
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
 
	$directory = get_template_directory();
	$path = $directory . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class;
 
	if (file_exists($path)) {
		require_once($path);
	}
}

spl_autoload_register('wpx_autoloader');

// kick off any filters on init
// $theme = new \WPX\Classes\Theme\Globals();
// $theme->filters();

/**
 * Utility Functions
 */
require_once(WPX_THEME_PATH."/includes/functions/helper.php");
require_once(WPX_THEME_PATH."/includes/functions/ui.php");

/**
 * Filters/Actions
*/
require_once(WPX_THEME_PATH."/includes/blocks.php");
require_once(WPX_THEME_PATH."/includes/comments.php");
require_once(WPX_THEME_PATH."/includes/dashboard.php");
require_once(WPX_THEME_PATH."/includes/enqueue.php");
require_once(WPX_THEME_PATH."/includes/feed.php");
require_once(WPX_THEME_PATH."/includes/plugins.php");
require_once(WPX_THEME_PATH."/includes/rewrites.php");
require_once(WPX_THEME_PATH."/includes/schema.php");
require_once(WPX_THEME_PATH."/includes/templates.php");

/**
 * Custom ACF Fields
 */
require_once(WPX_THEME_PATH."/includes/custom-acf/brand-colors/brand-colors.php");
require_once(WPX_THEME_PATH."/includes/custom-acf/icon-picker/icon-picker.php");
require_once(WPX_THEME_PATH."/includes/custom-acf/image-selector/image-selector.php");

/**
 * Custom ACF Fields
 */
require_once(WPX_THEME_PATH."includes/custom-acf/brand-colors/brand-colors.php");
require_once(WPX_THEME_PATH."includes/custom-acf/icon-picker/icon-picker.php");
require_once(WPX_THEME_PATH."includes/custom-acf/image-selector/image-selector.php");

/**
 * APIs
 */
require_once(WPX_THEME_PATH."templates/api/sample.php");

/**
 * Widgets
*/
require_once(WPX_THEME_PATH."includes/widgets/ve.php");

/**
 * CPTs & Taxonomies
 */
function wpx_architecture() {

	// include taxonomies
	require_once(WPX_THEME_PATH."includes/taxonomies/issues.php");

	// include cpts
	require_once(WPX_THEME_PATH."includes/content-types/articles.php");
	require_once(WPX_THEME_PATH."includes/content-types/jobs.php");

	// header/footer settings
	if( function_exists('acf_add_options_page') ) {
		
		// add parent
		$parent = acf_add_options_page(array(
			'page_title' 	=> 'Options',
			'menu_title' 	=> 'Options',
			'redirect' 		=> false,
			'icon_url' => 'dashicons-analytics',
			'position' => 78
		));

		// add sub page
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Header',
			'menu_title' 	=> 'Header',
			'parent_slug' 	=> $parent['menu_slug'],
		));

	}

	// alter Gutenberg UI with JS
	wp_register_script('wpx-block-script', get_stylesheet_directory_uri() .'/assets/js/ui.js',  array( 'wp-blocks', 'wp-edit-post' ));

	// register block editor script
	register_block_type( 'cc/ma-block-files', array('editor_script' => 'wpx-block-script') );

}
// the 0, 1 forces init to happen before widgets_init
add_action( 'init', 'wpx_architecture', 0, 1);

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

	// remove block patterns
	remove_theme_support( 'core-block-patterns' );

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

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Small', 'twentynineteen' ),
				'shortName' => __( 'S', 'twentynineteen' ),
				'size'      => 16,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'twentynineteen' ),
				'shortName' => __( 'M', 'twentynineteen' ),
				'size'      => 18,
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'twentynineteen' ),
				'shortName' => __( 'L', 'twentynineteen' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Huge', 'twentynineteen' ),
				'shortName' => __( 'XL', 'twentynineteen' ),
				'size'      => 30,
				'slug'      => 'huge',
			),
		)
	);

	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		wpx_color_palette()
	);

	// prevent maximum upload limit
	add_filter( 'big_image_size_threshold', '__return_false' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// image crops
	set_post_thumbnail_size( 1200, 675, true ); // rec social sharing size
	add_image_size( 'carousel-bg', 1024, 768, true );
	add_image_size( 'carousel-mobile', 300, 450, true);
	add_image_size( 'carousel-tablet', 600, 900, true);

}
add_action( 'after_setup_theme', 'wpx_setup', 0 );

/**
 * Color Map Array
 */
function wpx_color_array() {

	$color_map = array(
		array(
			'name'  => 'Black',
			'slug'  => 'black',
			'color' => '#000000',
		),
		array(
			'name'  => 'White',
			'slug'  => 'white',
			'color' => '#FFFFFF',
		)
	);

	return $color_map;

}

/**
 * Theme Color Palette
 */
function wpx_color_palette() {

	$color_map = wpx_color_array();

	// return the set to WP
	return $color_map;

}

/**
 * Triggered by Visiting /wpx-color-map/
 */
function wpx_update_color_map() {

	$color_map = wpx_color_array();

	// write the set to a file for SASS
	\WPX\Enqueue\get_color_sass($color_map);

}

/**
* Pre Get Posts
* (Specify Feed CPTs)
*/
function wpx_pre_get_posts( $wp_query ) {

	// add pages and posts to /feed/
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

/**
 * Writes Errors to DEBUG Log
 */
if ( ! function_exists('write_log')) {
	function write_log ( $log )  {
		if (wp_get_environment_type() === 'development' || wp_get_environment_type() === 'local') {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}