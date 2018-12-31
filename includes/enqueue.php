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

	if (WP_DEBUG == true) {

		// we enqueue jquery with WP because many plugins rely on it being in the header
		wp_deregister_script('jquery' );
		wp_enqueue_style( 'wpx.styles.src', assets_url().'/styles/screen.css', false, null, false);

	} else {

		wp_deregister_script('jquery');
		wp_enqueue_style( 'wpx.styles.min', assets_url().'/styles/screen.min.css', false, null, false);
		wp_enqueue_script( 'wpx.script.min', assets_url().'/js/app.min.js', false, null, true);

	}

}
add_action( 'wp_enqueue_scripts', '\WPX\Enqueue\enqueue_assets' );

/**
* AddThis Script
*/
function enqueue_addthis() { ?>
	<?php if (WPX_ADDTHIS_ID) : ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo WPX_ADDTHIS_ID; ?>"></script><?php endif; ?>
<?php }
add_action('wp_footer', '\WPX\Enqueue\enqueue_addthis');

/**
* Google Analytics
*/
function enqueue_ga() {
	if (WPX_GA_ID) : ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-3696276-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo WPX_GA_ID; ?>');
	</script>
	<?php
	endif;
}
add_action('wp_head', '\WPX\Enqueue\enqueue_ga');