<?php
/**
 * Actions
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Actions;

/**
 * Adds Custom JS to Dashboard
 */
function add_dashboard_js($hook) {
	wp_enqueue_script('wpx-dashboard', WPX_THEME_URL. '/assets/js/dashboard.js');
}

add_action('admin_enqueue_scripts', '\WPX\Actions\add_dashboard_js');

/**
 * Adds CSS to Dashboard
 */
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets/styles/dashboard.css');
}

add_action('admin_enqueue_scripts', '\WPX\Actions\admin_style');

/**
 * Disable Widgets
 */
function unregister_default_widgets() {
	unregister_widget( 'NF_Widget' ); // Ninja Forms
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Media_Audio' );
	unregister_widget( 'WP_Widget_Media_Video' );
	unregister_widget( 'WP_Widget_Media_Image' );
	unregister_widget( 'WP_Widget_Media_Gallery' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Text' );
	unregister_widget( 'WP_Widget_Custom_HTML' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'Akismet_Widget' );
}
add_action( 'widgets_init', '\WPX\Actions\unregister_default_widgets' );