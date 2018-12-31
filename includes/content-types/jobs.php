<?php
/**
 * Jobs
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/
$args = array(
	'label' => 'Jobs',
	'labels' => array(
		'name'=> 'Jobs',
		'singular_name'=>'Job',
		'menu_name'=>'Jobs',
		'name_admin_bar'=>'Jobs',
		'all_items'=>'Jobs',
		'add_new'=>'Add New',
		'add_name_item'=>'Add New Job',
		'edit_item'=>'Edit Job',
		'new_item'=>'New Job',
		'view_item'=>'View Job',
		'search_items'=>'Search Jobs',
		'not_found'=>'No Jobs found',
		'not_found_in_trash'=>'No Jobs found in Trash.',
		'parent_item_colon'=>'Parent Job'
	),
	'public'=>true,
	'exclude_from_search'=>false,
	'rewrite'=>array('slug'=>'jobs'),
	'show_ui'=>true,
	'hierarchical'=>true,
	'show_in_nav_menus'=>true,
	'show_in_menu'=>true,
	'show_in_admin_bar'=>true,
	'menu_icon'=>'dashicons-businessman',
	'supports'=>array(
		'title',
		'author',
		'editor',
		'thumbnail',
		'excerpt',
		'revisions',
		'page-attributes'
	),
	'taxonomies'=>array('wpx-regions','wpx-impact-areas')
);

register_post_type( 'wpx-jobs', $args );

?>