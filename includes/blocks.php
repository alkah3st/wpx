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
 * Append Classes to Custom Block Interior
 */
function custom_block_classes($extra_classes=false) {

	$classes = 'wpx-custom-block '.$extra_classes;

	echo $classes;

}

/**
 * Disable Specific Blocks
 * (in the js/blacklist.js)
 */
function disable_specific_blocks() {

	wp_enqueue_script( 'wpx-disable-core-blocks', assets_url().'/js/blacklist.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ), null, false);

}

add_action( 'enqueue_block_editor_assets', '\WPX\Blocks\disable_specific_blocks' );

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

		/* Note that supports can use any options here: https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/ */

		/*
		acf_register_block(array(
			'name'				=> 'archive',
			'title'				=> __('Archive'),
			'description'		=> __('Displays an archive of filterable posts.'),
			'render_template'	=> WPX_THEME_PATH."/templates/blocks/archive.php",
			'category'			=> 'wpx',
			'align' 			=> 'wide',
			'icon'				=> 'grid-view',
			'keywords'			=> array('archive'),
			'mode'			=> 'edit',
			'supports'		=> [
				'align'	=> false,
				'anchor'=> true,
				'customClassName'=> true,
				'mode'=>false,
				'multiple'=>false,
				'align_text'=>false,
				'full_height'=>false,
				'align_content'=>false,
				'renaming'=>true,
				'spacing'=>array(
					'margin'=>true,
					'padding'=>true,
					'blockGap'=>true,
				)
			]
		));
		*/

		// custom block
		acf_register_block(array(
			'name'				=> 'custom-block',
			'title'				=> __('Custom Block'),
			'description'		=> __('This is a custom block.'),
			'render_template'	=> WPX_THEME_PATH."/templates/blocks/custom-block.php",
			'category'			=> 'wpx',
			//'post_types'		=>	array('post','page'),
			'enqueue_assets'    => function() {
				if (is_admin()) {
					wp_enqueue_script( 'init-custom-block', get_template_directory_uri() . '/assets/js/blocks/custom-block.js', array('block-custom-block'), null, true );
					wp_enqueue_script( 'block-custom-block', get_template_directory_uri() . '/assets/js/modules/blocks/custom-block.js', array('jquery','wpx-app-init','wpx-app-utils',), null, true );
				}
			},
			'icon'				=> 'grid-view',
			'mode'				=> 'auto',
			'keywords'			=> array('block','custom'),
			'supports'			=> array(
				'align'=>true,
				'multiple'=>true,
				'anchor'=>true,
				'mode'=>true,
				'renaming'=>true,
				'background'=>array(
					'backgroundImage'=>true,
					'backgroundSize'=>true
				),
				'dimensions'=>array(
					"aspectRatio"=>true,
					"minHeight"=>true,
				),
				'shadow'=>true,
				'position'=>array(
					'sticky'=>true
				),
				'spacing'=>array(
					'margin'=>true,
					'padding'=>true,
				),
				'color'=>array(
					'background'=>true,
					'gradients'=>true,
					'text'=>true
				)
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'wpx_preview_image' => assets_url().'/images/gutenberg/custom-block.png',
					)
				)
			)
		));

	}

}

add_action('acf/init', '\WPX\Blocks\acf_blocks_register');