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
	wp_deregister_script( 'hoverintent-js' );
	wp_deregister_script( 'regenerator-runtime' );
	wp_deregister_script( 'wp-polyfill' );
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
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', '\WPX\Enqueue\disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', '\WPX\Enqueue\disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', '\WPX\Enqueue\disable_emojis' );

/**
 * Remove DNS prefetch
 */
function  remove_dns_prefetch() {
	remove_action( 'wp_head', 'wp_resource_hints', 2, 99 ); 
} 
add_action( 'init', '\WPX\Enqueue\remove_dns_prefetch' ); 

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Adds Custom JS to Dashboard
 */
function add_dashboard_js($hook) {
	global $pagenow;
	if ( $pagenow !== 'widgets.php' ) {
		wp_enqueue_script('wpx-dashboard', WPX_THEME_URL. '/assets/js/dashboard.js', array('jquery', 'wpx-init', 'wpx-utils'));
	}
}

add_action('admin_enqueue_scripts', '\WPX\Enqueue\add_dashboard_js');

/**
 * Adds CSS to Dashboard
 */
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets/styles/dashboard.css');
	wp_enqueue_style( 'wpx.osr-fontello', get_template_directory_uri()."/assets/styles/fontello.css", false, null, 'screen');
}

add_action('admin_enqueue_scripts', '\WPX\Enqueue\admin_style');

/**
 * Append Vendor Libraries to Gutenberg Blocks
 */
function gutenberg_assets() {

	// js
	wp_enqueue_script( 'wpx-gutenberg-enquire', assets_url().'/js/vendor/enquire.js', false, null, false);
	wp_enqueue_script( 'wpx-gutenberg-throttle', assets_url().'/js/vendor/jquery.throttle.js', false, null, false);
	wp_enqueue_script( 'wpx-gutenberg-isotope', assets_url().'/js/vendor/jquery.isotope.js', false, null, false);
	wp_enqueue_script( 'wpx-gutenberg-slick', assets_url().'/js/vendor/slick.js', false, null, false);
	wp_enqueue_script( 'wpx-app-init', get_stylesheet_directory_uri() . '/assets/js/app.init.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'wpx-app-utils', get_stylesheet_directory_uri() . '/assets/js/app.utils.js', array( 'jquery' ), null, false );

	// css
	if (WP_ENVIRONMENT_TYPE !== 'production') {
		wp_enqueue_style( 'wpx-gutenberg', assets_url().'/styles/gutenberg.css', false, null, false);
	} else {
		wp_enqueue_style( 'wpx-gutenberg-min', assets_url().'/styles/gutenberg.min.css', false, null, false);
	}

}
add_action( 'enqueue_block_editor_assets', '\WPX\Enqueue\gutenberg_assets' );

/**
 * Remove Editor Styles from Gutenberg
 */
function remove_editor_styles($editor_settings, $post) {
	unset($editor_settings['styles'][0]);
	return $editor_settings;
}

add_filter('block_editor_settings_all', '\WPX\Enqueue\remove_editor_styles', 2, 10);

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

/**
 * Color Sass File
 *
 * Writes the color array to a file
 */
function get_color_sass($color_array) {

	$uncache_mode = (WP_ENVIRONMENT_TYPE == 'development' ? true : false);

	if ($uncache_mode) {
		$hours = 0;
	} else {
		$hours = 7200;
	}
	
	$file = WPX_THEME_PATH.'/assets/styles/sass/utility/colors.scss';

	$current_time = time(); 
	$expire_time = $hours * 60 * 60; 
	$file_time = filemtime($file);

	if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
		return file_get_contents($file);
	} else {

		$output = false;
		$color_set = false;

		foreach($color_array as $color) {
			$color_set[] = array('class'=>$color['slug'], 'hex'=>$color['color']);
		}

		if ($color_set) {

			$output .= '/**'."\n";
			$output .= '* colors'."\n";
			$output .= '*/'."\n";
			$output .= '$colors: ('."\n";
			foreach($color_set as $color) : 
				$output .= '"'.$color["class"].'":'.$color["hex"].','."\n";
			endforeach;
			$output .= ');';

			$content = $output;

		} else {

			return false;

		}

		file_put_contents($file, $content);

		return $content;
	}
}