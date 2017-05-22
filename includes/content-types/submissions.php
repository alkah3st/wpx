<?php
/**
 * CPT: Submissions
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/
$args = array(
	'label' => 'Submissions',
	'labels' => array(
		'name'=> 'Submission',
		'singular_name'=>'Submission',
		'menu_name'=>'Submissions',
		'name_admin_bar'=>'Submissions',
		'all_items'=>'All Submissions',
		'add_new'=>'Add New',
		'add_name_item'=>'Add New Submission',
		'edit_item'=>'Edit Submission',
		'new_item'=>'New Submission',
		'view_item'=>'View Submission',
		'search_items'=>'Search Submissions',
		'not_found'=>'No Submissions found',
		'not_found_in_trash'=>'No Submissions found in Trash.',
		'parent_item_colon'=>'Parent Submission'
	),
	'public'=>false,
	'rewrite'=>false,
	'exclude_from_search'=>true,
	'show_ui'=>true,
	'taxonomies'=>array('wpx-submission-type'),
	'show_in_nav_menus'=>false,
	'show_in_menu'=>true,
	'show_in_admin_bar'=>false,
	'menu_icon'=>'dashicons-list-view',
	'supports'=>array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'revisions'
	)
);

register_post_type( 'wpx-submissions', $args );

?>