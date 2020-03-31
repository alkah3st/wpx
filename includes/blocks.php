<?php
/**
 * Blocks
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Blocks;

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function gutenberg_styles() {
	if (WP_DEBUG === true) {
		wp_enqueue_style( 'wpx-gutenberg', assets_url().'/styles/gutenberg.css', false, null, false);
	} else {
		wp_enqueue_style( 'wpx-gutenberg-min', assets_url().'/styles/gutenberg.min.css', false, null, false);
	}
}
add_action( 'enqueue_block_editor_assets', '\WPX\Blocks\gutenberg_styles' );

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
add_filter( 'block_categories', '\WPX\Blocks\custom_block_category', 10, 2 );

/**
 * Core & Plugin Blocks
 *
 * This is the complete list of blocks available in core,
 * so that they can be disabled on a case-by-case basis.
 */
function allowed_block_types( $allowed_blocks ) {
	return array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/subhead',
		'core/gallery',
		'core/list',
		'core/quote',
		'core/audio',
		'core/cover',
		'core/file',
		'core/video',
		'core/table',
		'core/code',
		'core/verse',
		'core/freeform', // classic editor
		'core/html',
		'core/media-text',
		'core/preformatted',
		'core/pullquote',
		'core/button',
		'core/columns',
		'core/more',
		'core/nextpage',
		'core/separator',
		'core/spacer',
		'core/shortcode',
		'core/archives',
		'core/categories',
		'core/latest-comments',
		'core/latest-posts',
		'core/embed',
		'core-embed/twitter',
		'core-embed/youtube',
		'core-embed/facebook',
		'core-embed/instagram',
		'core-embed/wordpress',
		'core-embed/soundcloud',
		'core-embed/spotify',
		'core-embed/flickr',
		'core-embed/vimeo',
		'core-embed/animoto',
		'core-embed/cloudup',
		'core-embed/collegehumor',
		'core-embed/dailymotion',
		'core-embed/funnyordie',
		'core-embed/hulu',
		'core-embed/imgur',
		'core-embed/issuu',
		'core-embed/kickstarter',
		'core-embed/meetup-com',
		'core-embed/mixcloudv',
		'core-embed/photobucket',
		'core-embed/polldaddy',
		'core-embed/reddit',
		'core-embed/reverbnation',
		'core-embed/screencast',
		'core-embed/speaker-deck',
		'core-embed/mixcloud',
		'core-embed/scribd',
		'core-embed/slideshare',
		'core-embed/smugmug',
		'core-embed/speaker',
		'core-embed/ted',
		'core-embed/tumblr',
		'core-embed/videopress',
		'core-embed/wordpress-tv',
		'yoast/how-to-block', // yoast
		'yoast/faq-block', // yoast
		'ninja-forms/form', // ninja forms
	);
}
// add_filter( 'allowed_block_types', 'WPX\Blocks\allowed_block_types' );

/**
 * Register All Blocks
 */
function block_register_blocks() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {

		include_once(WPX_THEME_PATH.'includes/blocks/blocks.php');

	}
	
}
add_action('acf/init', '\WPX\Blocks\block_register_blocks');