<?php
/**
 * Front End Assets
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Enqueue;

/**
* Main Asset Queue
*/
function enqueue_assets() {

	// some plugins need jquery, enqueued in the header
	// so we let that happen with 2.2.4
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', assets_url().'/js/jquery.js', false, '2.2.4', false);

	// the following are enqueued into css min via gulp
	wp_deregister_style( 'dashicons' ); 
	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library-theme' );
	wp_deregister_style( 'contact-form-7' );

	// we enqueue assets based on the build status, with cache busting
	if (wp_get_environment_type() === 'development' || wp_get_environment_type() === 'local') {
		wp_enqueue_script( 'wpx.js', assets_url().'/js/app.js', false, null, true);
		wp_enqueue_style( 'wpx.styles', assets_url().'/styles/screen.css', false, null, 'screen');
	} else {
		wp_enqueue_script( 'wpx.js', assets_url().'/js/app.min.js', false, filemtime( get_template_directory().'/assets/js/app.min.js' ), true);
		wp_enqueue_style( 'wpx.styles', assets_url().'/styles/screen.min.css', false, filemtime( get_template_directory().'/assets/styles/screen.min.css' ), 'screen');
	}

}
add_action( 'wp_enqueue_scripts', '\WPX\Enqueue\enqueue_assets' );

/**
 * Adds Custom JS to Dashboard
 */
function add_dashboard_js($hook) {
	wp_enqueue_script('wpx-dashboard', WPX_THEME_URL. '/assets/js/dashboard.js');
}

add_action('admin_enqueue_scripts', '\WPX\Enqueue\add_dashboard_js');

/**
 * Enqueue Theme Styles to Gutenberg
 */
function gutenberg_styles() {
	if (WP_DEBUG === true) {
		wp_enqueue_style( 'wpx-gutenberg', assets_url().'/styles/gutenberg.css', false, null, false);
	} else {
		wp_enqueue_style( 'wpx-gutenberg-min', assets_url().'/styles/gutenberg.min.css', false, null, false);
	}
}
add_action( 'enqueue_block_editor_assets', '\WPX\Enqueue\gutenberg_styles' );

/**
 * Apply Custom JS to Gutenberg
 */
function gutenberg_default_js() {
	wp_enqueue_script( 'wpx-editor', get_stylesheet_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', '\WPX\Enqueue\gutenberg_default_js' );

/**
 * Append Vendor Libraries to Gutenberg Blocks
 */
function gutenberg_js() {
	wp_enqueue_script('wpx-gutenberg-throttle', assets_url().'/js/vendor/jquery.throttle.js', false, null, false);
	wp_enqueue_script('wpx-gutenberg-slick', assets_url().'/js/vendor/slick.js', false, null, false);
}
add_action( 'enqueue_block_editor_assets', '\WPX\Enqueue\gutenberg_js' );

/**
* Google Analytics
*/
function enqueue_ga() {
	if (WPX_GA_ID) : ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo WPX_GA_ID; ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo WPX_GA_ID; ?>');
	</script>
	<?php endif;
}
add_action('wp_head', '\WPX\Enqueue\enqueue_ga');