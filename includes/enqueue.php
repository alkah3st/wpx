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
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', false, '2.2.4', false);

	if (WP_DEBUG === true) {
		wp_enqueue_style( 'wpx-styles', assets_url().'/styles/screen.css', false, null, false);
		wp_enqueue_script( 'wpx-js', assets_url().'/js/app.js', false, null, true);
	} else {
		wp_enqueue_style( 'wpx-styles-min', assets_url().'/styles/screen.min.css', false, null, false);
		wp_enqueue_script( 'wpx-js-min', assets_url().'/js/app.min.js', false, null, true);
	}

}
add_action( 'wp_enqueue_scripts', '\WPX\Enqueue\enqueue_assets' );

/**
* AddThis Script
*/
function enqueue_addthis() {
	if (WPX_ADDTHIS_ID) : ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo WPX_ADDTHIS_ID; ?>"></script><?php endif;
}
add_action('wp_footer', '\WPX\Enqueue\enqueue_addthis');

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