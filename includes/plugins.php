<?php
/**
 * Plugins
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Plugins;

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
// add_action( 'wp_enqueue_scripts', '\WPX\Plugins\remove_recaptcha_cform7', 1 );

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
//add_action( 'wpcf7_mail_sent', '\WPX\Plugins\cf7_action_wpcf7_mail_sent', 10, 1 ); 

/**
 * WP SEO in Dev
 */
if (WP_ENVIRONMENT_TYPE == 'development') {
	add_filter( 'yoast_seo_development_mode', '__return_true' );
}

/**
 * Adds Google Map Key for ACF
 */
function my_acf_google_map_api( $api ){
	$api['key'] = WPX_GMAPS_API;
	return $api;
}
add_filter('acf/fields/google_map/api', '\WPX\Plugins\my_acf_google_map_api');


/**
 * Force Yoast to bottom
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', '\WPX\Plugins\yoasttobottom');