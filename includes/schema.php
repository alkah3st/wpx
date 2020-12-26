<?php
/**
 * Schema Modifications
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Schema;

if (WP_ENVIRONMENT_TYPE == 'development') {
	add_filter( 'yoast_seo_development_mode', '__return_true' );
}


/**
 * Add Social Properties to Schema
 *
 * @param array $data Schema.org Article data array.
 *
 * @return array Schema.org Article data array.
 */
function config_schema_organization( $data ) {
	// add more social profiles
	$data['sameAs'][] = 'http://medium.com/@danielquinn';
	$data['sameAs'][] = 'https://www.behance.net/djamesquinn';
	$data['sameAs'][] = 'https://github.com/alkah3st';
	$data['sameAs'][] = 'http://www.last.fm/user/djamesquinn';
	return $data;
}
// add_filter( 'wpseo_schema_organization', '\WPX\Schema\config_schema_organization' );

/**
 * Adds CPTs to Schema
 *
 * @param array                 $pieces  Graph pieces to output.
 * @param \WPSEO_Schema_Context $context Object with context variables.
 *
 * @return array Graph pieces to output.
 */
function wpx_add_portfolio_graph( $pieces, $context ) {
	$pieces[] = new \WPX\Schema\Portfolio( $context );
	return $pieces;
}
// add_filter( 'wpseo_schema_graph_pieces', '\WPX\Schema\wpx_add_portfolio_graph', 11, 2 );

// use \Yoast\WP\SEO\Generators\Schema\Article;

/**
 * Add CPT to Schema
 *
class Portfolio extends Article  {

	public $context;

	public function __construct( \WPSEO_Schema_Context $context ) {
		$this->context = $context;
	}

	public function is_needed() {
		if ( is_singular( 'wpx-portfolio' ) ) {
			return true;
		}

		return false;
	}

	public function generate() {
		global $post;
		$data = parent::generate();

		$data['@type'] = "VisualArtwork";
		$data['name'] = get_the_title($post->ID);
		$data['description'] = esc_attr(strip_tags(get_the_excerpt()));
		$data['artMedium'] = esc_attr(strip_tags(get_the_term_list( $post->ID, 'wpx-technologies', $before = '', $sep = ',', $after = '' ))); 
		$data['artForm'] = esc_attr(strip_tags(get_the_term_list( $post->ID, 'wpx-services', $before = '', $sep = ',', $after = '' ))); 

		if(have_rows('attributed_creators', $post) ) {
			while( have_rows('attributed_creators', $post) ) : the_row(); 
				$type = get_sub_field('type');
				$name = get_sub_field('name');
				$url = get_sub_field('url');
				$data['contributor'][] = array(
					"@type"=>$type,
					"name"=>$name,
					"url"=>$url,
				);
			endwhile;
		}

		return $data;

	}
}
*/