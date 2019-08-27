<?php
/**
 * Setup
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */

/**
* Constants
*/
define( 'WPX_THEME_URL', get_bloginfo('template_url') );
define( 'WPX_THEME_PATH', dirname( __FILE__ ) . '/' );
define( 'WPX_DOMAIN', get_site_url() );
define( 'WPX_SITE_NAME', get_bloginfo('name'));
define( 'WPX_GA_ID', false);
define( 'WPX_ADDTHIS_ID', false);

/**
 * Functions
*/
require_once(WPX_THEME_PATH."includes/actions.php");
require_once(WPX_THEME_PATH."includes/filters.php");
require_once(WPX_THEME_PATH."includes/sidebars.php");
require_once(WPX_THEME_PATH."includes/enqueue.php");
require_once(WPX_THEME_PATH."includes/rewrites.php");
require_once(WPX_THEME_PATH."includes/utility.php");
require_once(WPX_THEME_PATH."includes/loops.php");
require_once(WPX_THEME_PATH."includes/blocks.php");

/**
 * Custom ACF Fields
 */
require_once(WPX_THEME_PATH."includes/custom-acf/brand-colors/brand-colors.php");
require_once(WPX_THEME_PATH."includes/custom-acf/icon-picker/icon-picker.php");

/**
 * Widgets
*/
require_once(WPX_THEME_PATH."includes/widgets/ve.php");

/**
 * CPTs & Taxonomies
 */
function wpx_architecture() {

	// include taxonomies
	require_once(WPX_THEME_PATH."includes/taxonomies/issues.php");

	// include cpts
	require_once(WPX_THEME_PATH."includes/content-types/articles.php");
	require_once(WPX_THEME_PATH."includes/content-types/jobs.php");

	// header/footer settings
	if( function_exists('acf_add_options_page') ) {
		
		// add parent
		$parent = acf_add_options_page(array(
			'page_title' 	=> 'Theme Settings',
			'menu_title' 	=> 'Options',
			'redirect' 		=> false,
			'icon_url' => 'dashicons-analytics',
			'position' => 78
		));

		// add sub page
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Sitewide Settings',
			'menu_title' 	=> 'Sitewide',
			'parent_slug' 	=> $parent['menu_slug'],
		));

		// add sub page
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Home Page Settings',
			'menu_title' 	=> 'Home',
			'parent_slug' 	=> $parent['menu_slug'],
		));

	}

}
// the 0, 1 forces init to happen before widgets_init
add_action( 'init', 'wpx_architecture', 0, 1);

/**
 * Theme Setup
 */
function wpx_setup() {

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails', array('post','page') );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// enable excerpt meta box for Pages
	add_post_type_support('page', 'excerpt');

	// hide version #
	remove_action('wp_head', 'wp_generator');

	// nav menus
	register_nav_menus( array(
		'primary' => 'Primary Navigation'
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	// add_editor_style( 'style-editor.css' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Small', 'twentynineteen' ),
				'shortName' => __( 'S', 'twentynineteen' ),
				'size'      => 19.5,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'twentynineteen' ),
				'shortName' => __( 'M', 'twentynineteen' ),
				'size'      => 22,
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'twentynineteen' ),
				'shortName' => __( 'L', 'twentynineteen' ),
				'size'      => 36.5,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Huge', 'twentynineteen' ),
				'shortName' => __( 'XL', 'twentynineteen' ),
				'size'      => 49.5,
				'slug'      => 'huge',
			),
		)
	);

	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Primary', 'twentynineteen' ),
				'slug'  => 'primary',
				'color' => '#0073aa',
			),
			array(
				'name'  => __( 'Secondary', 'twentynineteen' ),
				'slug'  => 'secondary',
				'color' => '#00A0D2',
			),
			array(
				'name'  => __( 'Dark Gray', 'twentynineteen' ),
				'slug'  => 'dark-gray',
				'color' => '#111',
			),
			array(
				'name'  => __( 'Light Gray', 'twentynineteen' ),
				'slug'  => 'light-gray',
				'color' => '#767676',
			),
			array(
				'name'  => __( 'White', 'twentynineteen' ),
				'slug'  => 'white',
				'color' => '#FFF',
			),
		)
	);

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// image crops
	set_post_thumbnail_size( 640, 480, true );
	add_image_size( 'custom-image-size', 850, 400, true );

}
add_action( 'after_setup_theme', 'wpx_setup', 0 );

/**
* Pre Get Posts
*/
function wpx_pre_get_posts( $wp_query ) {

	// add pages and posts to /feed/
	if ( $wp_query->is_feed() ) {
		$wp_query->set( 'post_type', array( 'post', 'page') );
		return $wp_query;
	}
}
add_action( 'pre_get_posts', 'wpx_pre_get_posts' );

/**
 * Assets Path
 */
function assets_url() {
	return WPX_THEME_URL.'/assets';
}

/**
 * Custom Comment Form
 */
function wpx_comment_form( $order ) {
	if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {

		comment_form(
			array(
				'logged_in_as' => null,
				'title_reply'  => null,
			)
		);
	}
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		array(
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		)
	);

	$authors = array();
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) array(
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	);

	return $discussion;
}

function discussion_avatars_list( $comment_authors ) {
	if ( empty( $comment_authors ) ) {
		return;
	}
	echo '<ol class="discussion-avatar-list">', "\n";
	foreach ( $comment_authors as $id_or_email ) {
		printf(
			"<li>%s</li>\n",
			get_user_avatar_markup( $id_or_email )
		);
	}
	echo '</ol><!-- .discussion-avatar-list -->', "\n";
}

function get_user_avatar_markup( $id_or_email = null ) {

	if ( ! isset( $id_or_email ) ) {
		$id_or_email = get_current_user_id();
	}

	return sprintf( '<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar( $id_or_email, 60 ) );
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}