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
			$brand_colors = wpx_brand_colors();
			
			/*
			*  Create a simple text input using the 'font_size' setting.
			*/
			if ($brand_colors) :
				sort($brand_colors);
			?>
			<div class="acf-brand-colors">

				<select name="<?php echo esc_attr($field['name']) ?>">
					<?php foreach($brand_colors as $color) : ?>
							<option value="<?php echo $color['hex']; ?>" <?php if ($field['value'] == $color['hex']) : ?>selected="selected"<?php endif; ?> style="color: <?php echo $color['hex']; ?> !important"><?php echo $color['label']; ?> (<?php echo $color['hex']; ?>)</option>
					<?php endforeach; ?>
				</select>

				<div class="color-selected" style="margin-top: 10px; width: 100px; height: 10px; background-color: <?php echo $field['value']; ?>"></div>

			</div>

			<?php
			endif;
		}

	}

	/**
	 * Establishes brand colors
	 */
	function wpx_brand_colors() {

		// Red = name displayed in ACF to user
		// #a83232 = hex applied as data attribute
		// crimson = class name basis

		$brand_colors = array(
			array('label'=>'Red', 'hex'=>'#a83232', 'name'=>'crimson'),
			array('label'=>'Blue', 'hex'=>'#3432a8', 'name'=>'midnight'),
			array('label'=>'Green', 'hex'=>'#3aa832', 'name'=>'forest'),
		);

		return $brand_colors;

	}

	/**
	 * Search brand colors by Key/Column
	 * Used internally by get_button_class() to find a matching key
	 * in the colors multidimensional array.
	 */
	function wpx_get_brand_colors($key, $column) {

		$colors = acf_brand_colors();

		if ($colors) {
			$match = array_search( $key, array_column($colors, $column));
			return $colors[$match];
		} else {
			return false;
		}

	}

	/**
	 * Render Button Color Class
	 * This will render the proper class, as defined in the button block
	 * based on the hex value saved in ACF.
	 */
	function wpx_button_class($hex) {
		$color = wpx_get_brand_colors($hex, 'hex');
		if ($color) {
			return 'button button-'.$color['name'];
		} else {
			return false;
		}
	}

	// initialize
	new wpx_brand_colors();

}