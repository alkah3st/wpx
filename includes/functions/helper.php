<?php
/**
 * Helper
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Helper;

/**
 * Record to Error Log
 */
if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
        if ( is_array( $log ) || is_object( $log ) ) {
            ob_start();
            var_dump( $log );
            $contents = ob_get_contents();
            ob_end_clean(); 
            error_log( $contents );
        } else {
            error_log( $log );
        }
    }
}

/**
 * Loop
 * 
 * Renders a custom wp_query and
 * returns as object or as a query
 */
function loop($params) {

    $defaults = array (
        'query_params' => false,
        'cache_id' => false,
        'relevanssi'=>false,
        'cache_group' => false,
        'format' => 'objects',
    );

    $args = wp_parse_args( $params, $defaults );

    $custom_query = ($args['cache_group'] ? wp_cache_get($args['cache_id'], $args['cache_group']) : false);

    if ($custom_query === false) :

        $custom_query = new \WP_Query($args['query_params']);

        // apply relevanssi
        if (function_exists('relevanssi_do_query') && $args['relevanssi'] = true) {
            $custom_query = new \WP_Query();
            $custom_query->parse_query($args['query_params']);
            relevanssi_do_query($custom_query);
        } else {
            $custom_query = new \WP_Query($args['query_params']);
        }

        if ( ! is_wp_error( $custom_query ) && $custom_query->have_posts() ) {

            wp_cache_set( $args['cache_id'], $custom_query, $args['cache_group']);

        }

    endif;

    if ($args['format'] == 'objects') {

        $posts_found = false;

        if ($custom_query->have_posts()) {

            while($custom_query->have_posts()) {
                
                $custom_query->the_post();

                global $post;

                $posts_found[] = $post;

            }
        }

        wp_reset_postdata();

        return $posts_found;

    } else {

        wp_reset_postdata();

        return $custom_query;

    }

}

/**
 * Is Ancestor Of
 */
function is_ancestor_of($post=false) {

    if (!$post) global $post;

    $ancestors = get_post_ancestors($post->ID);

    // if this post is a page, and it's either the page itself, a parent, or ancestor
    if(is_page() && (is_page($post->ID) || $post->post_parent == $post->ID || in_array($post->ID, $ancestors))) {
        return true;
    } else {
        return false;
    }

}

/**
 * Get Mixed Terms
 */
function get_mixed_terms($post_id, $post_type) {

    $terms = wp_get_object_terms( $post_id, get_object_taxonomies($post_type) );

    if ($terms) {

        return $terms;

    } else {

        return false;
    }

}


