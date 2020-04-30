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

			<style>
				<?php foreach($brand_colors as $i=>$color) : ?>
					.icon-color-<?php echo $color['slug']; ?> {
						background-color: <?php echo $color['color']; ?>;
						display: inline-block;
						width: 10px;
						height: 10px;
						border: 1px solid black;
					}
				<?php endforeach; ?>
			</style>

			<script>
				jQuery( document ).ready(function() {
					var selection = jQuery('#acf-color-picker<?php echo $random_id; ?>');
					jQuery(selection).select2({
						data: [
						<?php 
							foreach($brand_colors as $i=>$color) : 
						?>
						{
							id: '<?php echo $color['slug']; ?>',
							text: '<span class="icon-color-<?php echo $color['slug']; ?>"></span> <?php echo $color['name']; ?> (<?php echo $color['color']; ?>)'
							<?php if ( $color['slug'] == esc_attr($field['value'])) : ?>, selected: true<?php endif; ?>
						}, 
						<?php endforeach; ?>
						],
						width: 'resolve',
						allowClear: true,
						placeholder: 'Select an Icon',
						escapeMarkup: function (markup) { return markup; }
					});
				});
			</script>

			<div class="acf-color-picker-wrap">
				<select style="width: 100%; font-size: 40px;" id="acf-color-picker<?php echo $random_id; ?>" name="<?php echo esc_attr($field['name']) ?>"></select>
			</div>

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

			wp_register_script('acf-icon-picker-select2-js', get_template_directory_uri()."/includes/custom-acf/select2.js", array('jquery'), null);
			wp_enqueue_script('acf-icon-picker-select2-js');

			wp_register_style('acf-icon-picker-select2-css', get_template_directory_uri()."/includes/custom-acf/select2.min.css", false, null);
			wp_enqueue_style('acf-icon-picker-select2-css');

			wp_register_style('acf-icon-picker-fontello', get_template_directory_uri()."/assets/styles/fontello.css", false, null);
			wp_enqueue_style('acf-icon-picker-fontello');

		}

	}

	// initialize
	new wpx_brand_colors();

}