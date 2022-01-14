<?php
/**
 * Dashboard
 *
 * Filters to WP Dashboard UI.
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since WPX Theme 0.1.0
 */
namespace WPX\Dashboard;

/**
 * Disable Specific Blocks in Gutenberg
 * @param  [type] $allowed_blocks [description]
 * @return [type]                 [description]
 */
function remove_default_blocks($allowed_blocks){
	// Get all registered blocks
	$registered_blocks =\ WP_Block_Type_Registry::get_instance()->get_all_registered();

	// Disable default Blocks you want to remove individually
	unset($registered_blocks['core/calendar']);
	unset($registered_blocks['core/legacy-widget']);
	unset($registered_blocks['core/rss']);
	unset($registered_blocks['core/archives']);
	unset($registered_blocks['core/categories']);
	unset($registered_blocks['core/latest-comments']);
	unset($registered_blocks['core/latest-posts']);
	unset($registered_blocks['core/social-links']);
	unset($registered_blocks['core/search']);
	unset($registered_blocks['core/tag-cloud']);


	// Get keys from array
	$registered_blocks = array_keys($registered_blocks);

	// Merge allowed core blocks with plugins blocks
	return $registered_blocks;
}

add_filter('allowed_block_types', '\WPX\Filters\remove_default_blocks');

/**
 * Remove Editor Styles Inline CSS
 */
function remove_guten_wrapper_styles( $settings ) {
	unset($settings['styles'][0]);
	return $settings;
}
add_filter( 'block_editor_settings_all' , '\WPX\Dashboard\remove_guten_wrapper_styles' );

/**
 * Remove Customizer
 */
add_action( 'admin_menu', function () {
	global $submenu;
	global $menu;
	

	// change appearance to sidebar
	foreach ( $menu as $index => $menu_item ) {
		if ($menu_item[0] == 'NinjaTables Pro') {
			$menu[$index][0] = 'Tables';
		}
	}

	// remove all other theme options
	if ( isset( $submenu[ 'themes.php' ] ) ) {
		foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
			foreach ($menu_item as $value) {
				if (strpos($value,'customize') !== false) {
					//unset( $submenu[ 'themes.php' ][ $index ] );
				}
			}
		}
	}
});

/**
 * Disable Image Compression
 */
add_filter( 'jpeg_quality', function( $arg ) {
	return 100;
});

/**
 * Adds Contextual Help to Featured Image Metabox
 */
function block_featured_image() {
	wp_enqueue_script('wpx-featured-image', assets_url(). '/js/blocks/featured-image.js');
}
add_action( 'enqueue_block_editor_assets', '\WPX\Dashboard\block_featured_image' );

/**
 * Remove WP Version #
 */
function no_version_number() {
	remove_filter( 'update_footer', 'core_update_footer' ); 
}

add_action( 'admin_menu', '\WPX\Dashboard\no_version_number' );

/**
 * Remove Tags Widget
 */
function remove_tags() {
	remove_meta_box( 'tagsdiv-post_tag','post','normal' ); // Tags Metabo
}
add_action( 'admin_menu', '\WPX\Dashboard\remove_tags' );

/**
 * Remove Tags Menu
 */
function remove_tags_menu() {
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
add_action('admin_menu', '\WPX\Dashboard\remove_tags_menu');


/**
 * Set Featured Image Col Width
 */
function post_col_image_width() {
	echo '<style type="text/css">';
	echo '.column-featured_image { text-align: left; width:100px !important; overflow:hidden }';
	echo '</style>';
}
add_action('admin_head', '\WPX\Dashboard\post_col_image_width');

/**
 * Posts Columns: Data
 */
function post_cols_data( $column, $post_id ) {
	
	$post_object = get_post($post_id);

	switch ( $column ) {
		case 'id':
			$sheet_id = get_field('sheet_id', $post_id);
			if ($sheet_id) {
				echo $sheet_id;
			} else {
				echo $post_id;
			}
			echo '<style type="text/css">';
			echo ' .column-id { width: 100px !important;} ';
			echo '</style>';
			break;
		case 'featured_image':
			the_post_thumbnail(array(80,80));
			break;
		}
}
add_action( 'manage_pages_custom_column' , '\WPX\Dashboard\post_cols_data', 10, 2 ); 
add_action( 'manage_posts_custom_column' , '\WPX\Dashboard\post_cols_data', 10, 2 ); 

/**
 * Post
 */
function post_cols( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'featured_image' => 'Image',
		'title' => 'Title',
		'categories' => 'Categories',
		'tags' => 'Tags',
		'comments' => '<span class="vers"><div title="Comments" class="comment-grey-bubble"></div></span>',
		'author' => 'Author',
		'date' => 'Date'
	 );
	return $columns;
}
add_filter('manage_post_posts_columns' , '\WPX\Dashboard\post_cols');