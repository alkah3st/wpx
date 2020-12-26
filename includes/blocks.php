<?php
/**
 * Register Blocks
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */

if (function_exists('acf_register_block')) {

	/************************************************
	 * Custom Block
	 */

	// register the block
	acf_register_block(array(
		'name'				=> 'custom-block',
		'title'				=> __('Custom Block'),
		'description'		=> __('A sample custom block.'),
		'enqueue_script'	=> assets_url() . '/js/blocks/custom-block.js',
		'render_template'	=> WPX_THEME_PATH."partials/blocks/custom-block.php",
		'category'			=> 'wpx',
		'align' 			=> 'wide',
		'mode'				=> 'edit',
		'icon'				=> 'excerpt-view',
		'keywords'			=> array( 'custom'),
		'supports'			=> array(
			'align'=>true,
			'multiple'=>true,
			'mode'=>true
		)
	));

	// allow the block
	add_action( 'allowed_block_types', function($allowed_blocks) {
		@$allowed_blocks[] = 'acf/custom-block';
		return $allowed_blocks;
	} );


	/***********************************************/

}