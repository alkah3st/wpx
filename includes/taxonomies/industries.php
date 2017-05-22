<?php
/**
 * Industries
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/
$args = array(
	'label' => 'Industries',
	'labels' => array(
		'name'=> 'Industries',
		'singular_name'=>'Industry',
		'menu_name'=>'Industries',
		'all_items'=>'All Industries',
		'edit_item'=>'Edit Industry',
		'view_item'=>'View Industry',
		'update_item'=>'Update Industry',
		'add_new_item'=>'Add Industry',
		'new_item_name'=>'New Industry',
		'parent_item'=>'Parent Industry',
		'parent_item_colon'=>'Parent Industry:',
		'search_items'=>'Search Industries',
		'popular_items'=>'Popular Industries',
		'separate_items_with_commas'=>'Separate Industries with commas',
		'add_or_remove_items'=>'Add or remove Industries',
		'choose_from_most_used'=>'Choose from the most used Industries',
		'not_found'=>'No Industries found.'
	),
	'public'=>true,
	'show_ui'=>true,
	'show_in_nav_menus'=>false,
	'show_tagcloud'=>false,
	'show_admin_column'=>true,
	'hierarchical'=>true
);
register_taxonomy( 'industries', array('portfolio'), $args );

?>