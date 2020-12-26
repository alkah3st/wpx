<?php
/**
 * Custom Functions
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Custom;

/**
 * Parse Block Fields
 */
function get_block_fields($post, $block_id) {

	$blocks  = parse_blocks($post->post_content);
	$collect = array();

	foreach($blocks as $block) {

		if (!isset($block['attrs']['id'])) continue;

		if ($block['attrs']['id'] == $block_id) {

			acf_setup_meta( $block['attrs']['data'], $block['attrs']['id'], true );
			 
			$fields = get_fields();

			$collect[$block['attrs']['id']] = $fields;

			acf_reset_meta( $block['attrs']['id'] );

			return $collect;

		} else {

			continue;
		}

	}

}

/**
 * Search Within a Taxonomy
 * 
 * Support search with tax_query args
 *
 * $query = new WP_Query( array(
 *  'search_tax_query' => true,
 *  's' => $keywords,
 *  'tax_query' => array( array(
 *      'taxonomy' => 'country',
 *      'field' => 'id',
 *      'terms' => $country,
 *  ) ),
 * ) );
 */
class WP_Query_Taxonomy_Search {
	public function __construct() {
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
	}

	public function pre_get_posts( $q ) {
		if ( is_admin() ) return;

		$wp_query_search_tax_query = filter_var( 
			$q->get( 'search_tax_query' ), 
			FILTER_VALIDATE_BOOLEAN 
		);

		// WP_Query has 'tax_query', 's' and custom 'search_tax_query' argument passed
		if ( $wp_query_search_tax_query && $q->get( 'tax_query' ) && $q->get( 's' ) ) {
			add_filter( 'posts_groupby', array( $this, 'posts_groupby' ), 10, 1 );
		}
	}

	public function posts_groupby( $groupby ) {
		return '';
	}
}

new WP_Query_Taxonomy_Search();

/**
 * Color Sass File
 *
 * Writes the color array to a file
 */
function get_color_sass($color_array) {

	$uncache_mode = (WP_ENVIRONMENT_TYPE == 'development' ? true : false);

	if ($uncache_mode) {
		$hours = 0;
	} else {
		$hours = 7200;
	}
	
	$file = WPX_THEME_PATH.'assets/styles/sass/utility/colors.scss';

	$current_time = time(); 
	$expire_time = $hours * 60 * 60; 
	$file_time = filemtime($file);

	if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
		return file_get_contents($file);
	} else {

		$output = false;
		$color_set = false;

		foreach($color_array as $color) {
			$color_set[] = array('class'=>$color['slug'], 'hex'=>$color['color']);
		}

		if ($color_set) {

			$output .= '/**'."\n";
			$output .= '* colors'."\n";
			$output .= '*/'."\n";
			$output .= '$colors: ('."\n";
			foreach($color_set as $color) : 
				$output .= '"'.$color["class"].'":'.$color["hex"].','."\n";
			endforeach;
			$output .= ');';

			$content = $output;

		} else {

			return false;

		}

		file_put_contents($file, $content);

		return $content;
	}
}