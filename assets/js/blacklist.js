
wp.domReady( () => {

	// console.log(wp.blocks.getBlockTypes());

	// fse
	wp.blocks.unregisterBlockType('core/archives');
	wp.blocks.unregisterBlockType('core/calendar');
	wp.blocks.unregisterBlockType('core/categories');
	wp.blocks.unregisterBlockType('core/latest-comments');
	wp.blocks.unregisterBlockType('core/latest-posts');
	wp.blocks.unregisterBlockType('core/more');
	wp.blocks.unregisterBlockType('core/nextpage');
	wp.blocks.unregisterBlockType('core/page-list');
	wp.blocks.unregisterBlockType('core/page-list-item');
	wp.blocks.unregisterBlockType('core/rss');
	wp.blocks.unregisterBlockType('core/search');
	wp.blocks.unregisterBlockType('core/social-link');
	wp.blocks.unregisterBlockType('core/social-links');
	wp.blocks.unregisterBlockType('core/tag-cloud');
	wp.blocks.unregisterBlockType('core/footnotes');
	wp.blocks.unregisterBlockType('core/navigation');
	wp.blocks.unregisterBlockType('core/navigation-link');
	wp.blocks.unregisterBlockType('core/navigation-submenu');
	wp.blocks.unregisterBlockType('core/site-logo');
	wp.blocks.unregisterBlockType('core/site-title');
	wp.blocks.unregisterBlockType('core/site-tagline');
	wp.blocks.unregisterBlockType('core/query');
	wp.blocks.unregisterBlockType('core/template-part');
	wp.blocks.unregisterBlockType('core/avatar');
	wp.blocks.unregisterBlockType('core/post-title');
	wp.blocks.unregisterBlockType('core/post-excerpt');
	wp.blocks.unregisterBlockType('core/post-featured-image');
	wp.blocks.unregisterBlockType('core/post-content');
	wp.blocks.unregisterBlockType('core/post-author');
	wp.blocks.unregisterBlockType('core/post-author-name');
	wp.blocks.unregisterBlockType('core/post-navigation-link');
	wp.blocks.unregisterBlockType('core/post-date');
	wp.blocks.unregisterBlockType('core/post-terms');
	wp.blocks.unregisterBlockType('core/post-template');
	wp.blocks.unregisterBlockType('core/query-pagination');
	wp.blocks.unregisterBlockType('core/query-pagination-next');
	wp.blocks.unregisterBlockType('core/query-pagination-numbers');
	wp.blocks.unregisterBlockType('core/query-pagination-previous');
	wp.blocks.unregisterBlockType('core/query-no-results');
	wp.blocks.unregisterBlockType('core/read-more');
	wp.blocks.unregisterBlockType('core/verse');
	wp.blocks.unregisterBlockType('core/loginout');
	wp.blocks.unregisterBlockType('core/post-comments-form');
	wp.blocks.unregisterBlockType('core/comments');
	wp.blocks.unregisterBlockType('core/comment-edit-link');
	wp.blocks.unregisterBlockType('core/comment-reply-link');
	wp.blocks.unregisterBlockType('core/comment-template');
	wp.blocks.unregisterBlockType('core/comment-author-name');
	wp.blocks.unregisterBlockType('core/comment-content');
	wp.blocks.unregisterBlockType('core/comment-date');
	wp.blocks.unregisterBlockType('core/home-link');
	wp.blocks.unregisterBlockType('core/term-description');
	wp.blocks.unregisterBlockType('core/query-title');
	wp.blocks.unregisterBlockType('core/post-author-biography');
	wp.blocks.unregisterBlockType('core/legacy-widget');
	wp.blocks.unregisterBlockType('core/widget-group');

	// plugins
	wp.blocks.unregisterBlockType('filebird/block-filebird-gallery');
	wp.blocks.unregisterBlockType('yoast/faq-block');
	wp.blocks.unregisterBlockType('yoast/how-to-block');
	wp.blocks.unregisterBlockType('yoast-seo/breadcrumbs');
	wp.blocks.unregisterBlockType('safe-svg/svg-icon');

	// restrict list of embeds
	const allowedEmbedBlocks = [
		"youtube",
		"twitter",
		"facebook",
		"instagram",
		"wordpress",
		"soundcloud",
		"spotify",
		"flickr",
		"vimeo",
		"imgur",
		"issu",
		"reddit",
		"scribd",
		"tiktok",
		"tumblr",
		"pinterest",
		"bluesky"
	];

	const blocks = wp.blocks.getBlockVariations("core/embed");
	blocks?.forEach(function (blockVariation) {
	  if (-1 === allowedEmbedBlocks.indexOf(blockVariation.name)) {
		wp.blocks.unregisterBlockVariation("core/embed", blockVariation.name);
	  }
	});

});