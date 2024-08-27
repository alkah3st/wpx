<?php
/**
 * ACF: Color Palette
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
if( !class_exists('ACF') ) return;

class acf_field_color_palette extends acf_field {

	function __construct() {
		// Set the field type's label
		$this->name = 'wpx_color_palette';
		$this->label = __('Color Palette');
		$this->category = 'basic';
		$this->defaults = array(
			'brand_colors' => '',
		);

		// Initialize field
		parent::__construct();
	}

	function render_field_settings( $field ) {
		
		acf_render_field_setting( $field, array(
			'label'			=> 'Color',
			'instructions'	=> 'Select a color.',
			'type'			=> 'text',
			'name'			=> 'brand_colors'
		));

	}

	function render_field( $field ) {

		$brand_colors = $this->get_color_palette();
		
		$random_id = rand(1, 9999);
		
		if ($brand_colors) :
			sort($brand_colors);
		?>

		<script>
			jQuery( document ).ready(function() {
				function initializeColorPicker<?php echo $random_id; ?>() {
					var selection = jQuery('#acf-color-picker<?php echo $random_id; ?>');
					jQuery(selection).select2({
						data: [
						{
							id: false,
							text: 'Choose a Color'
							<?php if (!$field['value']) : ?>, selected: true<?php endif; ?>
						}, 
						<?php 
							foreach($brand_colors as $i=>$color) :
						?>
						{
							id: '<?php echo $color['slug']; ?>',
							text: '<span style="background-color: <?php echo $color['color']; ?>" class="wpx-color-picker"></span> <?php echo $color['name']; ?> (<?php echo $color['color']; ?>)'
							<?php if ( $color['slug'] == esc_attr($field['value'])) : ?>, selected: true<?php endif; ?>
						}, 
						<?php endforeach; ?>
						],
						width: 'resolve',
						allowClear: true,
						placeholder: 'Select a Color',
						escapeMarkup: function (markup) { return markup; }
					});
				}
				initializeColorPicker<?php echo $random_id; ?>();
			});
		</script>

		<div class="acf-color-picker-wrap">
			<select style="width: 100%; font-size: 40px;" class="acf-color-picker" id="acf-color-picker<?php echo $random_id; ?>" name="<?php echo esc_attr($field['name']) ?>"></select>
		</div>

		<style>
			.wpx-color-picker {
				display: inline-block;
				width: 10px;
				height: 10px;
				border: 1px solid black;
			}
		</style>

		<?php
		endif;
	}

	function get_color_palette() {

		$theme_json = wp_get_global_settings();
		
		return isset($theme_json['color']['palette']['theme']) ? $theme_json['color']['palette']['theme'] : [];
	}
}

new acf_field_color_palette();

function enqueue_acf_color_palette_scripts() {

	wp_register_script('acf-icon-picker-select2-js', get_template_directory_uri()."/includes/custom-acf/select2.js", array('jquery'), null);
	wp_enqueue_script('acf-icon-picker-select2-js');

	wp_register_style('acf-icon-picker-select2-css', get_template_directory_uri()."/includes/custom-acf/select2.min.css", false, null);
	wp_enqueue_style('acf-icon-picker-select2-css');

	wp_register_style('acf-icon-picker-fontello', get_template_directory_uri()."/assets/styles/fontello.css", false, null);
	wp_enqueue_style('acf-icon-picker-fontello');

}
add_action('acf/input/admin_enqueue_scripts', 'enqueue_acf_color_palette_scripts');

?>