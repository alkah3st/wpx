<?php
/**
 * ACF Selector: Brand Colors
 * 
 */
if (class_exists('acf')) {

	function acf_brand_colors_head() { 

		$brand_colors = wpx_color_palette();

		if ($brand_colors) :
			sort($brand_colors); ?>
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
		<?php endif; 

	}
	add_action('admin_head', 'acf_brand_colors_head');

	function acf_brand_colors_footer() { 
		$brand_colors = wpx_color_palette();
		if ($brand_colors) : ?>
			<script>
				jQuery( document ).ready(function() {
					if (typeof acf !== 'undefined') {
						acf.addAction('append', function( $el ){
							$el.find('.acf-color-picker').select2({width: 'resolve',allowClear: true,placeholder: 'Select a Color',escapeMarkup: function (markup) { return markup; }});
						});
					}
				});
			</script>
		<?php endif; 
	}
	add_action('admin_head', 'acf_brand_colors_footer');

	class wpx_brand_colors extends acf_field {
		
		
		function __construct() {
			
			$this->name = 'wpx-brand-colors';
			
			$this->label = 'Brand Colors';

			$this->category = 'jquery';

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

			$brand_colors = wpx_color_palette();
			
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

			<?php
			endif;
		}

		function input_admin_enqueue_scripts() {

			wp_register_script('acf-icon-picker-select2-js', get_template_directory_uri()."/includes/custom-acf/select2.js", array('jquery'), null);
			wp_enqueue_script('acf-icon-picker-select2-js');

			wp_register_style('acf-icon-picker-select2-css', get_template_directory_uri()."/includes/custom-acf/select2.min.css", false, null);
			wp_enqueue_style('acf-icon-picker-select2-css');

			wp_register_style('acf-icon-picker-fontello', get_template_directory_uri()."/assets/styles/fontello.css", false, null);
			wp_enqueue_style('acf-icon-picker-fontello');

		}

	}

	new wpx_brand_colors();

}