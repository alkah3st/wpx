<?php

if (class_exists('acf')) {

	class wpx_image_selector extends acf_field {
		
		
		function __construct() {
			
			$this->name = 'wpx-image-selector';
			$this->label = 'Image Selector';
			$this->category = 'choice';
			parent::__construct();
			
		}
		
		
		function render_field_settings( $field ) {
			
			acf_render_field_setting( $field, array(
				'label'			=> 'Image',
				'instructions'	=> 'Select an Image',
				'type'			=> 'text',
				'name'			=> 'image_filename'
			));

			acf_render_field_setting($field, array(
				'label'	=> __('Image Path'),
				'instructions' => "Enter a relative file path (the root being the theme) for image folder.",
				'type'	=>	'text',
				'name'	=>	'image_path',
			));

			acf_render_field_setting($field, array(
				'label'	=> __('URL Path'),
				'instructions' => "Enter a relative file path (the root being the theme) for image folder.",
				'type'	=>	'text',
				'name'	=>	'url_path',
			));


		}
		
		function render_field( $field ) {

			$images = array_diff(scandir(esc_attr(WPX_THEME_PATH.$field['image_path'])), array('.', '..'));

			if ($images) :

			?>

				<div class="acf-image-selector-wrap">
					
					<input type="hidden" class="acf-image-selector-field" value="<?php echo $field['value']; ?>" name="<?php echo esc_attr($field['name']) ?>">

					<div class="acf-image-selector-wrap-options">

						<?php 
							foreach($images as $image) : 
								$fullpath = assets_url().$field['url_path'].$image;
						?>

						<div class="acf-image-selector-option <?php if ($fullpath == $field['value']) : ?>selected<?php endif; ?>">
							<img data-value="<?php echo $fullpath; ?>" src="<?php echo $fullpath; ?>" alt="<?php echo esc_attr($image); ?>">
						</div>

						<?php endforeach; ?>

					</div>

				</div>

			<?php

			endif;
		}
		
		function input_admin_enqueue_scripts() {

			wp_register_style('acf-image-selector-css', get_template_directory_uri()."/includes/custom-acf/image-selector/image-selector.css", false, null);
			wp_enqueue_style('acf-image-selector-css');

			wp_register_script('acf-image-selector-js', get_template_directory_uri()."/includes/custom-acf/image-selector/image-selector.js", array('jquery'), null);
			wp_enqueue_script('acf-image-selector-js');

		}

	}

	new wpx_image_selector();

}