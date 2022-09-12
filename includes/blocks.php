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
 * Disable Specific Blocks in Gutenberg
 * @param  [type] $allowed_blocks [description]
 * @return [type]                 [description]
 */
function remove_default_blocks($allowed_blocks){
	// Get all registered blocks
	$registered_blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();

	// Disable default Blocks you want to remove individually
	// unset($registered_blocks['core/calendar']);
	// unset($registered_blocks['core/legacy-widget']);
	// unset($registered_blocks['core/rss']);
	// unset($registered_blocks['core/archives']);
	// unset($registered_blocks['core/categories']);
	// unset($registered_blocks['core/latest-comments']);
	// unset($registered_blocks['core/latest-posts']);
	// unset($registered_blocks['core/social-links']);
	// unset($registered_blocks['core/search']);
	// unset($registered_blocks['core/tag-cloud']);

	// Get keys from array
	$registered_blocks = array_keys($registered_blocks);

	// Merge allowed core blocks with plugins blocks
	return $registered_blocks;
}

add_filter('allowed_block_types_all', '\WPX\Dashboard\remove_default_blocks');

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
add_filter( 'block_categories_all', '\WPX\Blocks\custom_block_category', 10, 2 );

/**
 * Register Blocks
 */
function acf_blocks_register() {

	if( function_exists('acf_register_block_type') ) {

		// sliced slider
		acf_register_block(array(
			'name'				=> 'custom-block',
			'title'				=> __('Custom Block'),
			'description'		=> __('This is a custom block.'),
			'render_template'	=> WPX_THEME_PATH."/templates/blocks/sliced-slider.php",
			'category'			=> 'wpx',
			'enqueue_assets'    => function() {
				if (is_admin()) {
					wp_enqueue_script( 'init-custom-block', get_template_directory_uri() . '/assets/js/blocks/custom-block.js', array('block-custom-block'), null, true );
					wp_enqueue_script( 'block-custom-block', get_template_directory_uri() . '/assets/js/modules/blocks/custom-block.js', array('jquery','wpx-app-init','wpx-app-utils',), null, true );
				}
			},
			'align' 			=> 'wide',
			'mode'				=> 'edit',
			'icon'				=> 'grid',
			'keywords'			=> array('block','custom'),
			'supports'			=> array(
				'align'=>false,
				'multiple'=>true,
				'mode'=>true
			)
		));

	}

}

add_action('acf/init', '\WPX\Blocks\acf_blocks_register');