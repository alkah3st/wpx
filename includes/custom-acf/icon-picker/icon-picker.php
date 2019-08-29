<?php

if (class_exists('acf')) {

	class wpx_icon_picker extends acf_field {
		
		
		/*
		*  __construct
		*
		*  This function will setup the field type data
		*
		*  @type	function
		*  @date	5/03/2014
		*  @since	5.0.0
		*
		*  @param	n/a
		*  @return	n/a
		*/
		
		function __construct() {
			
			/*
			*  name (string) Single word, no spaces. Underscores allowed
			*/
			
			$this->name = 'wpx-icon-picker';
			
			
			/*
			*  label (string) Multiple words, can include spaces, visible when selecting a field type
			*/
			
			$this->label = 'Icon Picker';
			
			
			/*
			*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			*/
			
			$this->category = 'content';

			// do not delete!
	    	parent::__construct();
	    	
		}
		
		
		/*
		*  render_field_settings()
		*
		*  Create extra settings for your field. These are visible when editing a field
		*
		*  @type	action
		*  @since	3.6
		*  @date	23/01/13
		*
		*  @param	$field (array) the $field being edited
		*  @return	n/a
		*/
		
		function render_field_settings( $field ) {
			
			/*
			*  acf_render_field_setting
			*
			*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
			*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
			*
			*  More than one setting can be added by copy/paste the above code.
			*  Please note that you must also have a matching $defaults value for the field name (font_size)
			*/
			
			acf_render_field_setting( $field, array(
				'label'			=> 'Icon',
				'instructions'	=> 'Select an icon',
				'type'			=> 'text',
				'name'			=> 'icon'
			));

		}
		
		
		
		/*
		*  render_field()
		*
		*  Create the HTML interface for your field
		*
		*  @param	$field (array) the $field being rendered
		*
		*  @type	action
		*  @since	3.6
		*  @date	23/01/13
		*
		*  @param	$field (array) the $field being edited
		*  @return	n/a
		*/
		
		function render_field( $field ) {
			
			// parse the icons in fontello.json
			$fontello_json = json_decode(file_get_contents(get_template_directory().'/assets/fontello.json'), true);

			$icon_names = array();

			if ($fontello_json) :

				foreach($fontello_json['glyphs'] as $glyph) :
					$icon_names[] = $glyph['css'];
				endforeach;

			endif;

			if ($icon_names) :
				sort($icon_names);
			?>
			<div class="wpx-acf-icon-picker">
				<select name="<?php echo $field['name'] ?>">
					<option value="">Choose an Icon</option>
					<?php foreach($icon_names as $icon) : ?>
						<option <?php if ( $icon == esc_attr($field['value'])) : ?>selected="selected"<?php endif; ?> value="<?php echo $icon; ?>"><i class="icon-<?php echo $icon; ?>"></i> <?php echo $icon; ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<?php if (isset($field['value'])) : ?><p class="wpx-acf-icon-picker-selected"><em>Selected Icon:</em>&nbsp;&nbsp;<i class="icon-<?php echo esc_attr($field['value']); ?>"></i></p><?php endif; ?>

			<?php
			endif;
		}
		
			
		/*
		*  input_admin_enqueue_scripts()
		*
		*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
		*  Use this action to add CSS + JavaScript to assist your render_field() action.
		*
		*  @type	action (admin_enqueue_scripts)
		*  @since	3.6
		*  @date	23/01/13
		*
		*  @param	n/a
		*  @return	n/a
		*/

		function input_admin_enqueue_scripts() {

			wp_register_script('acf-icon-picker-chosen-js', get_template_directory_uri()."/includes/custom-acf/icon-picker/select2.min.js", array('acf-input','jquery'), null);
			wp_enqueue_script('acf-icon-picker-chosen-js');

			wp_register_script('acf-icon-picker-js', get_template_directory_uri()."/includes/custom-acf/icon-picker/icon-picker.js", array('acf-input','jquery'), null);
			wp_enqueue_script('acf-icon-picker-js');

			wp_register_style('acf-icon-picker-chosen-css', get_template_directory_uri()."/includes/custom-acf/icon-picker/select2.min.css", array('acf-input'), null);
			wp_enqueue_style('acf-icon-picker-chosen-css');

			wp_register_style('acf-icon-picker-css', get_template_directory_uri()."/includes/custom-acf/icon-picker/icon-picker.css", array('acf-input'), null);
			wp_enqueue_style('acf-icon-picker-css');

			wp_register_style('acf-icon-picker-fontello', get_template_directory_uri()."/assets/styles/fontello.css", array('acf-input'), null);
			wp_enqueue_style('acf-icon-picker-fontello');

		}

	}


	// initialize
	new wpx_icon_picker();

}