<?php
/**
 * ACF Selector: Brand Colors
 * 
 */
if (class_exists('acf')) {

	class wpx_brand_colors extends acf_field {
		
		
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
			
			$this->name = 'wpx-brand-colors';
			
			
			/*
			*  label (string) Multiple words, can include spaces, visible when selecting a field type
			*/
			
			$this->label = 'Brand Colors';
			
			
			/*
			*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			*/
			
			$this->category = 'jquery';

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
				'label'			=> 'Color',
				'instructions'	=> 'Select a color.',
				'type'			=> 'text',
				'name'			=> 'brand_colors'
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

			// get the brand colors
			$brand_colors = wpx_color_palette();
			
			/*
			*  Create a simple text input using the 'font_size' setting.
			*/
			if ($brand_colors) :
				sort($brand_colors);
			?>
			<div class="acf-brand-colors">

				<select name="<?php echo esc_attr($field['name']) ?>">
					<?php foreach($brand_colors as $color) : ?>
							<option value="<?php echo $color['slug']; ?>" <?php if ($field['value'] == $color['slug']) : ?>selected="selected"<?php endif; ?> style="color: <?php if ($color['color'] == "#FFFFFF") : echo '#000000'; else : echo $color['color']; endif; ?> !important"><?php echo $color['name']; ?> (<?php echo $color['color']; ?>)</option>
					<?php endforeach; ?>
				</select>

				<div class="color-selected" style="margin-top: 10px; width: 100px; height: 10px; background-color: <?php echo $field['value']; ?>"></div>

			</div>

			<?php
			endif;
		}

	}

	// initialize
	new wpx_brand_colors();

}