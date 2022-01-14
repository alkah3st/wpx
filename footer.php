<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
?>


			</div>

		</div>

		<script>var SITE_ROOT = '<?php echo WPX_DOMAIN; ?>';</script>
		<script>var SITE_ASSETS = '<?php echo assets_url(); ?>';</script>
		<script>var SITE_THEME = '<?php echo WPX_THEME_URL; ?>';</script>

		<script>
			var addthis_config = {
				ui_cobrand: "<?php echo WPX_SITE_NAME; ?>",
				ui_use_addressbook: true,
				ui_click: true,
				pubid: '<?php echo WPX_ADDTHIS_ID; ?>',
				data_track_addressbar: false,
				data_track_clickback: true,
				data_ga_property: "<?php echo WPX_GA_ID; ?>"
			}
		</script>

		<?php wp_footer(); ?>

	</div>

</body>