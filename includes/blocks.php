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
	 wp_enqueue_style( 'wpx-gutenberg-styles', get_theme_file_uri( '/assets/styles/gutenberg.min.css' ), false, null, 'all' );
}
add_action( 'enqueue_block_editor_assets', '\WPX\Blocks\gutenberg_styles' );

/**
 * Adds New ("wpx") Category to Blocks
 */
function custom_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'test',
				'title' => __( 'Custom Blocks', 'wpx' ),
				'icon'  => 'layout',
			),
		)
	);
}
add_filter( 'block_categories', '\WPX\Blocks\custom_block_category', 10, 2 );

/**
 * Allowed Blocks
 *
 * This is the complete list of blocks available in core,
 * plus the custom ones defined here, and those added by Yoast & Ninja Forms.
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
		'acf/custom-block', // custom block
		'yoast/how-to-block', // yoast
		'yoast/faq-block', // yoast
		'ninja-forms/form', // ninja forms
	);
}
add_filter( 'allowed_block_types', 'WPX\Blocks\allowed_block_types' );

/**
 * CTA Blocks
 */
function block_custom_block() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'custom-block',
			'title'				=> __('Custom Block'),
			'description'		=> __('A sample custom block.'),
			'render_template'	=> WPX_THEME_PATH."partials/blocks/custom-block.php",
			'category'			=> 'test',
			'align' 			=> 'wide',
			'mode'				=> 'edit',
			'icon'				=> 'excerpt-view',
			'keywords'			=> array( 'custom'),
			'supports'			=> array(
				'align'=>false,
				'multiple'=>true,
				'mode'=>true
			)
		));
	}
	
}
add_action('acf/init', '\WPX\Blocks\block_custom_block');