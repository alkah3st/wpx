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
 * Disable Default Dashboard Widgets
 */
function dashboard_sidebar_widgets() {
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Text' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'Akismet_Widget' );
}
add_action( 'widgets_init', '\WPX\Actions\dashboard_sidebar_widgets' );

/**
 * Remove Visual Editor
 *
 * Removes the default Visual Editor for certain templates.
 */
function remove_editor_init() {
	// If not in the admin, return.
	if ( ! is_admin() ) {
		return;
	}

	// Get the post ID on edit post with filter_input super global inspection.
	$current_post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );

	// Get the post ID on update post with filter_input super global inspection.
	$update_post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT );

	// Check to see if the post ID is set, else return.
	if ( isset( $current_post_id ) ) {
		$post_id = absint( $current_post_id );
	} else if ( isset( $update_post_id ) ) {
		$post_id = absint( $update_post_id );
	} else {
		return;
	}

	// Don't do anything unless there is a post_id.
	if ( isset( $post_id ) ) {
		// Get the template of the current post.
		$template_file = get_post_meta( $post_id, '_wp_page_template', true );
		/* Example of removing page editor for page-your-template.php template.
		if ($template_file == 'default') {
			remove_post_type_support( 'page', 'editor' );
		}
		*/
	}
}
add_action( 'init', '\WPX\Actions\remove_editor_init' );