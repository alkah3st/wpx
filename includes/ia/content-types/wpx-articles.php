<?php
/**
 * Articles
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/
$args = array(
	'label' => 'Articles',
	'labels' => array(
		'name'=> 'Articles',
		'singular_name'=>'Article',
		'menu_name'=>'Magazine',
		'name_admin_bar'=>'Articles',
		'all_items'=>'Articles',
		'add_new'=>'Add New',
		'add_name_item'=>'Add New Article',
		'edit_item'=>'Edit Article',
		'new_item'=>'New Article',
		'view_item'=>'View Article',
		'search_items'=>'Search Articles',
		'not_found'=>'No Articles found',
		'not_found_in_trash'=>'No Articles found in Trash.',
		'parent_item_colon'=>'Parent Article'
	),
	'public'=>true,
	'publicly_queryable' =>true,
	'exclude_from_search'=>false,
	'rewrite'=>array('slug'=>'articles/%issues%','with_front'=>false),
	'show_ui'=>true,
	'has_archive'=>'articles',
	'hierarchical'=>false,
	'show_in_nav_menus'=>true,
	'show_in_menu'=>true,
	'show_in_admin_bar'=>true,
	'menu_icon'=>'dashicons-book-alt',
	'show_in_rest'=>true,
	'supports'=>array(
		'title',
		'author',
		'editor',
		'thumbnail',
		'excerpt',
		'revisions',
		'page-attributes'
	),
	'taxonomies'=>array('wpx-issues')
);

register_post_type( 'wpx-articles', $args );

?>