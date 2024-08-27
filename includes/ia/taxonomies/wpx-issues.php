<?php
/**
 * Issues
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/
$args = array(
	'label' => 'Issues',
	'labels' => array(
		'name'=> 'Issues',
		'singular_name'=>'Issue',
		'menu_name'=>'Issues',
		'all_items'=>'All Issues',
		'edit_item'=>'Edit Issue',
		'view_item'=>'View Issue',
		'update_item'=>'Update Issue',
		'add_new_item'=>'Add Issue',
		'new_item_name'=>'New Issue',
		'parent_item'=>'Parent Issue',
		'parent_item_colon'=>'Parent Issue:',
		'search_items'=>'Search Issues',
		'popular_items'=>'Popular Issues',
		'separate_items_with_commas'=>'Separate Issues with commas',
		'add_or_remove_items'=>'Add or remove Issues',
		'choose_from_most_used'=>'Choose from the most used Issues',
		'not_found'=>'No Issues found.'
	),
	'public'=>true,
	'show_in_rest'=>true,
	'rewrite'=>array('slug'=>'articles','with_front'=>false),
	'show_ui'=>true,
	'show_in_nav_menus'=>true,
	'show_tagcloud'=>false,
	'show_admin_column'=>true,
	'hierarchical'=>true
);
register_taxonomy( 'wpx-issues', array('wpx-articles'), $args );

?>