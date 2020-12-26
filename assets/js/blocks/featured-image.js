/**
 * Adds Contextual Help to Core
 * Featured Image Block
 */

var el = wp.element.createElement;

function wrapPostFeaturedImage( OriginalComponent ) { 
	return function( props ) {
			return (
					el(
							wp.element.Fragment,
							{}, 
							'',
							el(
									OriginalComponent,
									props
							),
							'The featured image is used in various blocks to show a square thumbnail representing the post. It is also used in social media sharing (you can override this with the Yoast SEO panel). The image should be at least 1200x675 pixels.'
					)
			);
	} 
} 

wp.hooks.addFilter( 
	'editor.PostFeaturedImage', 
	'wpx/wrap-post-featured-image', 
	wrapPostFeaturedImage
);