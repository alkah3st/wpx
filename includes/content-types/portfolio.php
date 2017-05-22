<?php
/**
 * Portfolio
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/
$args = array(
	'label' => 'Portfolio',
	'labels' => array(
		'name'=> 'Portfolio',
		'singular_name'=>'Portfolio',
		'menu_name'=>'Portfolio',
		'name_admin_bar'=>'Portfolio',
		'all_items'=>'Portfolio',
		'add_new'=>'Add New',
		'add_name_item'=>'Add New Portfolio',
		'edit_item'=>'Edit Portfolio',
		'new_item'=>'New Portfolio',
		'view_item'=>'View Portfolio',
		'search_items'=>'Search Portfolio',
		'not_found'=>'No Portfolio posts found',
		'not_found_in_trash'=>'No Portfolio posts found in Trash.',
		'parent_item_colon'=>'Parent Portfolio'
	),
	'public'=>true,
	'exclude_from_search'=>false,
	'show_ui'=>true,
	'has_archive'=>true,
	'hierarchical'=>true,
	'show_in_nav_menus'=>true,
	'show_in_menu'=>true,
	'show_in_admin_bar'=>true,
	'menu_position'=>28.08,
	'menu_icon'=>'dashicons-portfolio',
	'supports'=>array(
		'title',
		'author',
		'editor',
		'thumbnail',
		'excerpt',
		'revisions',
		'page-attributes'
	),
	'taxonomies'=>array('industries')
);

register_post_type( 'portfolio', $args );

?>