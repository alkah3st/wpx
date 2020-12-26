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
 * Isolate reCAPTCHA in CF7
 * (So that it only displays on a specific page.)
 * @return [type] [description]
 */
function remove_recaptcha_cform7() {
	global $post;
	if (isset($post)) {
		$contact_page = get_field('global_contact_page','options');
		// if this is the contact page or the page has a contact form 7 shortcode
		if ($contact_page->ID == $post->ID || has_shortcode( $post->post_content, 'contact-form-7' )) {
			// do nothing
			return false;
		} else {
			// there is no wpcf7 form on this page so remove all the wpcf7 scripts
			remove_action('wp_enqueue_scripts', 'wpcf7_do_enqueue_scripts');
			remove_action('wp_enqueue_scripts', 'wpcf7_recaptcha_enqueue_scripts');
		}
	}
}
// add_action( 'wp_enqueue_scripts', '\WPX\Actions\remove_recaptcha_cform7', 1 );

/**
 * CF7: Adds the Lead to Mailchimp on Submit
 */
function cf7_action_wpcf7_mail_sent( $contact_form ) { 

	require_once(WPX_THEME_PATH."/includes/libraries/mailchimp.php");

	$api_key = get_field('mailchimp_api_key', 'options');
	$list_id = get_field('mailchimp_list_id', 'options');
	$which_contact_form = get_field('contact_form_id', 'options');

	$submission = \WPCF7_Submission::get_instance();
	
	if ( $submission ) {
		$posted_data = $submission->get_posted_data();
	}
	
	$contact_form_id = $contact_form->id(); 
	
	if ( $which_contact_form == $contact_form_id ) { 

		if ( $submission ) {
			$posted_data = $submission->get_posted_data();
		}

		$target_data = array(
			'EMAIL' => $posted_data['email'],
			'FNAME' => $posted_data['first_name'],
			'LNAME' => $posted_data['last_name'],
			'COMPANY' => $posted_data['company'],
			'INTEREST' => $posted_data['subject'][0],
			'WEBSITE' => $posted_data['url'],
			'CONSENT' => $posted_data['consent'],
		);

		// new MC instance
		$MailChimp = new \MailChimp($api_key);

		// get list
		$result = $MailChimp->get('lists');

		// construct new subscriber
		$result = $MailChimp->post("lists/$list_id/members", array(
			'email_address' => $target_data['EMAIL'],
			'status' => 'subscribed'
		));

		// add subscriber
		$subscriber_hash = $MailChimp->subscriberHash($target_data['EMAIL']);

		// pass in subscriber
		$result = $MailChimp->patch("lists/$list_id/members/$subscriber_hash", array(
			'merge_fields' => array(
				'FNAME'=> ( $target_data['FNAME'] ? $target_data['FNAME'] : false),
				'LNAME'=> ( $target_data['LNAME'] ? $target_data['LNAME'] : false),
				'WEBSITE'=> ( $target_data['WEBSITE'] ? $target_data['WEBSITE'] : false),
				'INTEREST'=> ( $target_data['INTEREST'] ? $target_data['INTEREST'] : false),
				'COMPANY'=> ( $target_data['COMPANY'] ? $target_data['COMPANY'] : false),
				'CONSENT'=> ( $target_data['CONSENT'] ? 1 : false)
			)
		));

	}

}
//add_action( 'wpcf7_mail_sent', '\WPX\Actions\cf7_action_wpcf7_mail_sent', 10, 1 ); 

/**
 * Remove Tags Widget
 */
function remove_tags() {
	remove_meta_box( 'tagsdiv-post_tag','post','normal' ); // Tags Metabo
}
add_action( 'admin_menu', '\WPX\Actions\remove_tags' );

/**
 * Remove Tags Menu
 */
function remove_tags_menu() {
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
add_action('admin_menu', '\WPX\Actions\remove_tags_menu');

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
	add_filter( 'tiny_mce_plugins', '\WPX\Actions\disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', '\WPX\Actions\disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', '\WPX\Actions\disable_emojis' );

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
 * Adds Contextual Help to Featured Image Metabox
 */
function block_featured_image() {
	wp_enqueue_script('wpx-featured-image', assets_url(). '/js/blocks/featured-image.js');
}
add_action( 'enqueue_block_editor_assets', '\WPX\Actions\block_featured_image' );

/**
 * Adds a "Custom Blocks" Category
 */
function custom_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'wpx',
				'title' => __( 'Custom Blocks', 'wpx' ),
				'icon'  => 'layout',
			),
		)
	);
}
add_filter( 'block_categories', '\WPX\Actions\custom_block_category', 10, 2 );

/**
 * Register All Blocks
 */
function block_register_blocks() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {

		include_once(WPX_THEME_PATH.'includes/blocks.php');

	}
	
}
add_action('acf/init', '\WPX\Actions\block_register_blocks');

/**
 * Remove DNS prefetch
 */
function  remove_dns_prefetch () {
	remove_action( 'wp_head', 'wp_resource_hints', 2, 99 ); 
} 
add_action( 'init', '\WPX\Actions\remove_dns_prefetch' ); 

/**
 * Disable Core Widgets
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