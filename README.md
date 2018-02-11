# WordPress Extend
> A boilerplate theme for WordPress, developed by DQuinn.net.

WordPress Extend (WPX) is a stripped down boilerplate for building brochureware with WordPress. WPX is meant to work with the plugin WPX Utility, which contains helper functions for use with the theme, and Advanced Custom Fields, for creating custom meta boxes in the Dashboard.

<!-- toc -->

- [Features](#features)
- [Installation](#installation)
- [Theme Organization](#theme-organization)
  * [Default WordPress Templates](#default-wordpress-templates)
  * [Hook Organization](#hook-organization)
  * [Available Global Paths](#available-global-paths)
- [Image Assets](#image-assets)
  * [Inline Images](#inline-images)
  * [Inline Retina Images](#inline-retina-images)
  * [Retina Sprites](#retina-sprites)
  * [Retina Background Images](#retina-background-images)
- [Icon Fonts](#icon-fonts)
- [Semantic HTML](#semantic-html)
  * [Semantic Heading Levels](#semantic-heading-levels)
- [Styles](#styles)
  * [SASS Globbing](#sass-globbing)
  * [Writing Selectors](#writing-selectors)
    + [Types of Selector-Objects](#types-of-selector-objects)
  * [Sass Variables](#sass-variables)
  * [Viewport Font Sizes](#viewport-font-sizes)
  * [Context Mixin & Responsive Layouts](#context-mixin--responsive-layouts)
  * [Setting Breakpoints](#setting-breakpoints)
  * [The minmax() mixin](#the-minmax-mixin)
- [Enquire (Breakpoints in JS)](#enquire-breakpoints-in-js)
- [Forcing Matching Heights](#forcing-matching-heights)
- [Javascript Methodology](#javascript-methodology)
  * [Build vs. Debug Mode](#build-vs-debug-mode)
  * [Writing Custom JS Modules](#writing-custom-js-modules)
  * [Concerning JS & Gulp](#concerning-js--gulp)
- [Gulp Build Script](#gulp-build-script)
  * [Prep Fonts](#prep-fonts)
  * [Generate Sprites](#generate-sprites)
  * [Watch with Livereload](#watch-with-livereload)
- [About Yarn](#about-yarn)

<!-- tocstop -->

## Features

* Install with WPX Utility, a plugin that contains helper functions for use with the theme;
* Ready for use with Advanced Custom Fields
* Stripped-down, unopinionated WP templates 
* PHP namespacing for hooks and functions;
* Includes Gulp-powered build script for the front end;
	* Simple, CSS framework-free globbed Sass;
	* Simple, JS framework-free jQuery objects;
	* Includes dynamic icon fonts;
	* Includes inline retina images and retina background images;
* Yarn integration for managing JS dependencies

## Installation

1. Download and install the latest version of WordPress from [WordPress.org](https://wordpress.org/download/).

2. Download and activate the [WPX Utility plugin](https://github.com/alkah3st/wpx-utility).

3. Download and activate the WPX Theme in your ```/wp-content/themes/``` folder. Then cd into ```/assets/``` and run:

Then, install Yarn: [https://yarnpkg.com/lang/en/docs/install/](https://yarnpkg.com/lang/en/docs/install/). Run the following command in terminal:

```
yarn install
```

This will create a ```/node_modules/``` folder in the ```/assets/``` folder of the theme. 

After following the instructions under [Icon Fonts](#icon-fonts), run the following Gulp task:

```
gulp fontello
```

To generate your retina sprites and custom icon font, you can run:

 ```gulp sprites```.

You can then run ```gulp``` (which will trigger ```gulp watch```) or ```gulp build``` if you are prepping the codebase for production.

## Theme Organization

### Default WordPress Templates

Keep default WordPress templates, such as ```page.php``` and ```index.php``` in the root of the theme. The header and footer of the site are in header.php and footer.php, in the theme root. The rest of the theme is organized as follows:

* ```acf-json```, for Advanced Custom Field's JSON templates;
* ```assets```, for front-end files;
* ```includes```, for hook logic;
* ```partials```, for chunks of code to be included in other files;
* ```templates```, for WordPress page templates

### Hook Organization

Hook logic is organized in ```/includes/```, under the hook file that makes the most sense:

- **actions.php** is for any action hooks
- **filters.php** is for any filter hooks
- **rewrites.php** is for any URL rewriting hooks
- **enqueue.php** is for any header/footer injection
- **sidebar.php** is for any sidebar registration
- **utility.php** is for custom functions that are not hooks

Each of these is namespaced, for example, to call a function defined in ```\WPX\Actions\```, you would write:

```\WPX\Actions\myfunction();```

All of the hook files are loaded via the default ```functions.php``` file in the theme root, as well as any theme initialization logic.

### Available Global Paths

For convenience. you can get several root URIs/paths rendered in any template like so:

**assets root URI:**

	// assets_url();

	<img src="<?php echo assets_url(); ?>/images/my-image.jpg" alt="My image">

**domain root URI:**

	// WPX_DOMAIN

	<a href="<?php echo WPX_DOMAIN; ?>">Home</a>

**theme root URI**

	// WPX_THEME_URL 

	<img src="<?php echo WPX_THEME_URL; ?>/favicon.png" alt="Favicon">

**theme root path**

	// WPX_THEME_PATH 

	C:/your/file/path/website/

## Image Assets

### Inline Images

Drop inline images into ```/assets/images/```. Their retina counterparts should be suffixed with ```@2x.png```.

* Drop sprites and retina sprites in ```/assets/images/sprites/```. Retina sprites should be suffixed ```@2x.png``` and be double the pixel size of the non-retina sprites. 
* Drop backgrounds in ```/assets/images/bgs/```. Retina backgrounds should be suffixed ```@2x.png``` and be double the pixel size of non-retina backgrounds.

### Inline Retina Images

The boilerplate loads [Dense](http://dense.rah.pw/), so you can render a retina-capable inline images in the templates by adding the data-2x attribute to any image tag that also has a ```retina``` class. 

The value of the data-2x attribute is the path to the retina image:

```<img src="<?php echo assets_url(); ?>/images/logo-main.png" class="retina" data-2x="<?php echo assets_url(); ?>/images/logo-main@2x.png">```

For more information refer to the [Dense documentation](http://dense.rah.pw/)

### Retina Sprites

You can drop images you want combined into a single sprite in ```/images/sprites/```. They must be PNGs.

You should drop *both* a retina and non-retina version in this folder. 

For example, if you have an icon that's 100x100 pixels, you would drop icon.png and icon@2x.png into this folder, and they'll automatically be combined into a retina sprite when you run: gulp setup.

* Keep the filename brief, using hyphens for spaces, with ```@2x.png``` suffix.

* You must put both a retina and non-retina image for each pair. If you don't have a retina image for something, just make a copy of the non-retina, double the size, and name it appropriately for the time being.
* ```gulp-spritesmith``` will fail if retina sprites do not exist, or they are the incorrect sizes. If you do not want to use sprites, just remove the "sprites" task from the ```gulp``` and ```gulp build``` tasks.

* You have to run ```gulp``` task manually whenever you add new images; ```gulp watch``` won't re-create sprites to save on compile time. (However ```gulp build``` will.)

Use a sprite in your Sass like so:

	.myicon {
		@include retina-sprite($icon-group); // where the files involved were named "icon.png" and "icon@2x.png". Notice the suffix "-group"
	}

This will render the following CSS:

	@media (-webkit-min-device-pixel-ratio: 2), not all, (min-resolution: 192dpi) {
		.myicon {
    		background-image: url(../images/spritesheet@2x.png);
    		background-size: 91px 91px;
		}
	}

	.myicon {
    	background-image: url(../images/spritesheet.png);
    	background-position: 0px 0px;
    	width: 91px;
    	height: 91px;
	}

### Retina Background Images

You may have a situation where you need to render a repeating background and provide a retina version of the background in your CSS. This theme has a mixin built in for this. 

Simply drop the retina and non-retina background image into ```/assets/images/bgs/```, for example ```background.png``` and ```background@2x.jpg```.

You can then call the background like so in the SASS:
	
	.mybackground {
		@include bg-retina("background", "jpg", 800px, 517px);
		width: 800px;
		height: 517px;
	}

This will render the following CSS:

	@media only screen and (-webkit-min-device-pixel-ratio: 2), 
	not all, not all, not all, not all, only screen and (min-resolution: 192dpi), 
	only screen and (min-resolution: 2dppx)
	.background-example {
    	background-image: url(../images/bgs/background@2x.jpg);
    	background-size: 800px 517px;
	}

	.mybackground {
		background-image: url("../images/bgs/background.jpg");
		width: 800px;
		height: 517px;
	}

## Icon Fonts

If you want to render an icon font (like arrows or social icons), you can use the Fontello vector font generated by the build script. 

* Go to Fontello.com, select the icons you want to include in your project, then in the big red button labeled "Download Webfont" choose "Get Config Only" in the dropdown. (The down arrow lets you choose "Get Config Only.")

* This will generate a ```config.json``` file. Rename this to ```fontello.json``` and replace the one in the ```/assets/``` folder with it.

* You can now run ```gulp fontello``` and the font will be automagically generated.

To render an icon in your templates, you can use this markup:

```<i class="icon-facebook"></i>```

The classname is defined in the ```fontello.json```, and you can set the class name prior to exporting from Fontello.com using Fontello's web interface.

If you need to add new icons after exporting, just re-import the ```fontello.json``` into Fontello.com. (Click the little wrench icon in the web interface.) This will make all the icons you imported selected in the web interface, then you can select more an export the json file again.

## Semantic HTML

HTML should be written semantically in HTML5. That means use ```<div>``` elements if the element has no semantic meaning, but ```<section>``` elements when the element represents a break in the document outline. 

For example:

	<section class="my-articles"> <--! has semantic meaning, is a "section" of the document for Recent Articles -->

		<h1 class="screenreader">Recent Articles</h1>

		<div class="wrapper"> <--! has no meaning, is just a wrapper -->

			<article class="article">

				<h1><a href="#">Title of Article</a></h1>

			</article>

			...

		</div>

	</section> 

### Semantic Heading Levels

**Don't forget H1s.** Whenever you open a sectioning element (```<section>```, ```<article>```, see [W3C.org on Sectioning Elements](https://www.w3.org/TR/html5/sections.html), make sure there is at least one ```<h1>``` somewhere in it.

**Screenreader Class.** You can use ```class="screenreader"``` if you do not want to display the ```<h1>``` to the user. This class is defined in ```base.scss``` to hide the element in a screenreader-friendly way. All sectioning elements must have at least one ```<h1>``` inside them to be considered meaningful sections.

**About Heading Levels.** Each sectioning element resets the heading levels. That is, a ```<section>``` element can have ```<h1>``` - ```<h6>``` and an ```<article>``` inside of the ```<section>``` can also have ```<h1>``` - ```<h6>```:

	<section>

		<h1>Recent Posts</h1>

		<h2>Category: Potatoes</h2>

		<article>
			<h1>Why Potatoes are Great</h1>
			<h2>Dylan Thomas</h2>
		</article>

		<article>
			<h1>How to Make Salty Potatoes</h1>
			<h2>Jim Michelson</h2>
		</article>

	</section>

Keep in mind that the document itself has its own heading levels distinct from any sections:

	<body>

		<h1>Title of the Page Itself</h1>

		<h2>My Subtitle for the Page</h2>

		<section>
			<h1>My Special Section</h1>
			<h2>My Subtitle for the Section</h2>
		</section>

Use the Chrome extension [HTML5 Outliner](https://chrome.google.com/webstore/detail/html5-outliner/afoibpobokebhgfnknfndkgemglggomo?hl=en) to see the semantic meaning in your pages.

## Styles

WPX does not include a CSS Framework. **Do not introduce a CSS framework (such as Bootstrap, etc) or a CSS grid-based framework to the codebase. Additional mixins are welcome, but remember to keep things simple and not add unnecessary complexity to the project.** Only [normalize.css](https://necolas.github.io/normalize.css/) is included in the vendor files, as well as a handful of useful mixins.

Some quick ground rules for CSS:

- Write everything in lowercase and use hyphens to separate words;
- Use tabs for spaces;
- Do not write vendor prefixes for CSS3 properties in your CSS. The build script will handle this automatically. So write ```border-radius: 10px``` and not ```-webkit-border-radius: 10px```;
- Do not use IDs, except to target elements with Javascript.
- Don't use em font sizes (see below for the desired methodology)
- When defining line-height, use fixed values like 1, 1.5 and not 32px unless you are vertically-centering an element

### SASS Globbing

All the SASS files for the project are in ```/styles/sass/``` folder, organized like so:

	globals
		- base.scss // for global styles
		- forms.scss // styles related to form elements
		- tinymce.scss // all styles output by Visual Editor
	modules // module-based styles
		- footer.scss
		- header.scss...
	utility // variables, fonts, mixins
	vendor // sass from third parties


**Globals.** In ```base.scss``` we includes selectors that can be used anywhere in the website, such as element overrides, global classes, and structural selectors that are not context dependent.

**Forms.** Under ```forms.scss``` we include selectors pertaining to any forms or form elements used throughout the website.

**TinyMCE.** The WordPress Visual Editor uses TinyMCE, which can output a limited subset of markup that the user may have entered into the Visual Editor. Wherever in the templates of the site I might output the contents of a Visual Edior, I need to ensure that all outputted markup is styled consistently. In this case I will wrap the output with a ```.tinymce``` class. This SASS file styles the outputted markup in isolation.

**Modules.** You can break down other contextual groups of selectors into individual SASS files under ```/modules/```, in whatever way makes sense for the project. (More on the reasoning behind this later in this guide). Typically a discreet bundle of contextual selectors, such as a primary navigation, is a good candidate for a separate .scss file in ```/modules/```.

**Utility.** There are four SASS partials included in the ```/utility/``` folder: mixins, for SASS mixins; ```normalize.scss``` (which contains the CSS reset); ```sprites.scss``` (described later in this document: this file is generated by the build script); and ```variables.scss```, which is where you should define all SASS variables. 

**Vendor**. The ```/vendor/``` folder is meant for including any SASS partials or CSS provided by third party plugins, and will get compiled with everything else. The styles in ```/vendor/icons/``` are generated by the built script.

### Writing Selectors

Above all else, we want to adhere to DRY principles (Do Not Repeat Yourself), keep things simple, and make things easy to understand. It's OK to repeat selectors if it means you can better isolate a module to make it re-usable throughout the site. At the same time, don't pursue modularity at the cost of sanity: we are building brochureware, not Facebook. For these reasons, avoid BEM or Atomic CSS methodologies.

Some quick ground rules for SASS:

- Do not nest selectors more than 3 levels deep;
- Avoid complicated SASS abstractions and/or calculations;
- Put mixins immediately after an opening selector, then all properties of the selector, then pseudo element selectors, then state modifiers, then nested selectors.

#### Types of Selector-Objects

Let's establish some specific guidelines about writing nested selectors, in the spirit of SMACSS. Since we can nest selectors with SASS, the goal is to categorize our nested selectors into "selector objects" and use them with purpose. Any selector object you write should fit into one of these categories:

**Global Objects.** These are selector objects that are meant to be used anywhere in the site, independent of context. Global objects may not have a lot of nested selectors, if any at all. You shouldn't have a lot of these, and you shouldn't treat them like state modifiers (see below), otherwise you'll end up with Atomic CSS (which we do not like). A ```.button``` is a good example of a global object:

	.button {
		@include font-size(14px);
		background-color: $yellow;
		display: inline-block;
		padding: 12px 0;
		border-radius: 30px;
		color: $black;
		text-align: center;
		min-width: 270px;
		text-transform: uppercase;
		font-weight: 600;
		letter-spacing: 2px;
		border: 3px solid transparent;
		text-decoration: none !important;

		// pseudo class
		&:hover {
			...
		}

		// state modifier
		.is-outline {
			.. // an alternate look/feel 
		}

	}

As you can see, this selector is an object unto itself: you could place it anywhere in the site and it doesn't rely on any properties outside of itself to be presentable. Makes sense to drop something like this into ```base.scss```.

**Module Objects**. Probably the most common type of selector object you will write. They're generally self-contained, and may have a great deal of nested selectors. Like global objects, modules are also generally context-independent, but they are less likely to be nested inside of other selector objects. The difference between global objects and module objects is really a matter of complexity. 

	[data-module="related"] {

		// special context
		&.in-sidebar {
			... styles that alter this module specifically by context
			... here we can break the rule of 3, because:
			... .module-related.in-sidebar .related-inner .related-description is still 3 deep
		}

		.related-inner {

			.related-description {
				...
			}

		}

		.related-title {
			...
		}

		// this module alters the look of the global .button object
		.button {
			... // styles that alter the button specifically for this module
		}

	}

The module object's naming pattern is best expressed as: 

	data attribute module & name ([data-module="related"])
		> name + context (.related-inner)
			> name + context (.related-description)

The topmost selector is represented by a data attribute ```[data-module="module-name"]```, and nested selectors should be prefixed with the module's unique name.

Whenever you make a new module, puts its styles into a corresponding file ```related.scss``` in the ```/assets/styles/sass/modules/``` folder.

**Layout Objects.** Layout objects are used for just that: elements that serve a strictly structural purpose (as opposed to functional purpose) in layouts. Their types include headers, footers, wrappers, sections, asides, sidebars, and navs. Layout objects, unlike global or module objects, are very unlikely to be nested inside one another.

	.header-main {

		.header-main-outer {

			.header-main-inner {
				...
			}

		}

	}

	// or 

	.sidebar {

		// indicating an alternative context
		&.in-left-rail {
			...
		}

		&.in-right-rail {
			...
		}

		// this module is affected by special styles when it appears
		// inside a sidebar layout object
		.module-widget {
			...
		}

	}

The naming pattern for layout objects should borrow from a fixed list of predefined layout types (such as the list enumerated above), where the topmost selector and nested selectors are prefixed with the layout type: 

	layout type + context (.header-main)
		> layout type + context + secondary context (.header-main-outer) 
			> layout type + context + tertiary context (.header-main-inner)

The right place for most layout objects is in ```base.scss```, though if you have a lot of them, it might make sense to organize them into the ```/modules/``` folder in partials like ```footer.scss``` and ```header.scss``` for example.

**State Modifier Objects.** These are selectors that are meant to be used inside of other objects, and usually represent states triggered by Javascript or context-specific modifiers to the presentation of a module/layout. If you intend to define a state modifier object globally (meaning it can be used anywhere, independent of context), it's wise to suffix all properties in the object !important. It is preferable to constraint state modifier objects to modules or layouts. Avoid defining lots of global state modifiers, as that will lead down the path to Atomic CSS (which we do not like).

	.is-error {
		color: red !important;
		border: 1px solid $red !important;
	} 

	.is-aligned-left {
		float: left;
	}

### Sass Variables

You will find all the variables in ```/assets/styles/sass/partials/utility/variables.scss```. 

Mainly these are colors, fonts, and a variable for the global context (the max-width of the site, see below). 

Try to standardize your colors and fonts using variables. Do not litter your partials with hex values or font declarations.

### Viewport Font Sizes

Use the @font-size mixin to render fonts in viewport-sizes. This allows fonts to scale responsively. Always specify your sizes in pixels, and they will get converted.

		h1 {
			@include font-size($size: 16px, $min: 14px, $max: 22px, $fallback: 16px);
		}

At a minimum, you can just specify the starting size and the minimum size. The starting size will get used as both the fallback and the maximum size:

		h1 {
			@include font-size(16px, 14px);
		}

This will render a default size, a minimum size, a maximum size, and a fallback:

		@media (min-width: 1375px) {
			font-size: 22px;
		}

		h1 {
			font-size: 16px; // this will default to $size if you set no $fallback
			font-size: 1.6vw;
		}

How does it know what to consider a "maximum" viewport? There is a $viewport_ultrawide variable in ```/styles/sass/utility/variables.scss``` that you can modify, it is set to 1600px by default.

### Context Mixin & Responsive Layouts

I tend to standardize my "context" in a responsive design. Context in this sense means the maximum width of the content area that the designer intended. Usually this is something near 1200 pixels.

So if my ```$context``` is 1200 pixels (the max width of the site), and I have a container with two divs inside it that are 700 pixels and 500 pixels wide, I need to convert these widths to percentages:

		.container {
			@include context();

			.page {
				width: percentage(700px / $context);
			}

			.sidebar {
				width: percentage(500px / $context);
			}
		}

This will render the following:

		.container {
			max-width: 1200px;
			margin: 0 auto;
			width: 95%;

			.page {
				width 58.33333333333333%;
			}

			.sidebar {
				width: 41.66666666666667%;
			}
		}

For the most part, all layout elements should be styled with fluid widths, and you should utilize break points to adjust the rhythm of that scaling when the design looks awkward at any given viewport. This implies defining breakpoints per selector object, rather than globally across the site. More on this below.

### Setting Breakpoints

If it makes sense to introduce a breakpoint for the primary navigation module (```/assets/styles/sass/modules/primary-nav.scss```) at 800 pixels, 570 pixels, and 400 pixels, we should do that specifically for that module, even if the main content area only needs to break at 1000 pixels and 500 pixels.

You can define breakpoints by using the @include breakpoint(); mixin. There are several predefined viewports (you will find the viewports in ```/assets/styles/sass/utility/variables.scss```), and they are: $viewport_ultrawide, $viewport_desktop, $viewport_tablet, $viewport_phablet, and $viewport_mobile. These variables should be adjusted to better suit your design, and you are encouraged to define viewports as needed, directly into the function, if the prefdefined viewports are unsuitable in a particular context: @include breakpoint(548px).

		.sidebar {
			width: percentage(500px / $context);

			@include breakpoint-mobile("mobile") {
				width: 100%;
			}
		}

Results in:

		.sidebar {
			width: 41.66666666666667%;

			@media only screen and (max-width: 500px) {
				.sidebar {
					width: 100%;
				}
			}
		}

The exception here would be things like icons and squares, that aren't meant to scale at all. 

### The minmax() mixin

The ```@include minmax()``` is very useful for setting rhythmic margins and paddings. If you want to set a responsive top and bottom margin or padding that scales with the viewport and also has a minimum and maximum size, this is the mixin for you:

		.sidebar {
			@include minmax(margin, 8%, 8%);
		}

This will result in the margin maxing out at a fixed pixel size for when exceeding the $viewport_desktop width set in ```/styles/sass/utility/variables.scss``` (assuming this was 1200):

		.sidebar {
			margin-top: 8%;
			margin-bottom: 8%;
		}

		@media only screen and (max-width: 1200px) {
			.sidebar {
				margin-top: 80px;
				margin-bottom: 80px;
			}
		}

Below that viewport size, the percentage gets used, up until we hit the minimum viewport size, which is by default $viewport_mobile:

		@media only screen and (max-width: 800px) {
			.sidebar {
				margin-top: 80px;
				margin-bottom: 80px;
			}
		}

If you wanted to set a different "minimum" for the margin/padding, you could do this:

		.sidebar {
			@include minmax(margin, 8%, 8%);

			@include breakpoint($viewport_mobile) {
				@include minmax(margin, 2.5%, 2.5%);
			}
		}

Which would result in:

		.sidebar {
			margin-top: 8%;
			margin-bottom: 8%;
		}

		@media only screen and (max-width: 1200px) {
			.sidebar {
				margin-top: 80px;
				margin-bottom: 80px;
			}
		}

		@media only screen and (max-width: 800px) {
			.sidebar {
				margin-top: 25px;
				margin-bottom: 25px;
			}
		}

You can also tweak the min and max breakpoint from the initial parameters:

```@mixin minmax($style, $percent-top: auto, $percent-bottom : auto, $max-breakpoint: $viewport_desktop, $min-breakpoint: $viewport_mobile)```

## Enquire (Breakpoints in JS)

There may be situations where you need to trigger Javascript at specific breakpoints. For this, I use Enquire, which is already installed. You should define a set of Enquire breakpoints for each module in which it applies. For example, the layout.js module has a set defined for you (at arbitrary breakpoints);

		/*
		bind layouts
		 */
		bindBreakpoints: function() {

			enquire
			.register("screen and (min-width: 801px)", {

				// desktop
				match: function() {},

				// tablet
				unmatch: function() {}

			})
			.register("screen and (max-width: 800px)", {

				// tablet
				match: function() {},

				// desktop
				unmatch: function() {}

			})
			.register("screen and (max-width: 600px)", {

				// mobile
				match: function() {},

				// tablet
				unmatch: function() {}
			});

		}

Enquire triggers as the viewport scales, as well as once on initial load.

## Forcing Matching Heights

If you need to force a set of elements be the same height, there is some JS in place to help you.

Assume each article has a background color, so the elements needs to be the same height inside the ```.articles-inner``` parent:

	<section data-module="articles" class="module">

		<h1 class="screenreader">Latest News</h1>

		<div class="articles-inner">

			<div class="articles-box">
				<h1>A Really Long Title for this Article</h1>
				<time datetime="01/01/2017">January 1, 2017</time>
				<p>This is a description of the article.</p>
			</div>
		
			<div class="articles-box">
				<h1>A Short Title</h1>
				<time datetime="01/01/2017">January 1, 2017</time>
				<p>Now these articles have different heights.</p>
			</div>
	
			<div class="articles-box">
				<h1>A Really Long Title for this Article</h1>
				<time datetime="01/01/2017">January 1, 2017</time>
				<p>This is a description of the article.</p>
			</div>

		</div>

	</section> 

To enforce equal heights, simply add a ```.eq-parent``` class to the parent, and a ```.eq``` class to each child:

	<section data-module="articles" class="module">

		<h1 class="screenreader">Latest News</h1>

		<div class="articles-inner eq-parent">

			<div class="article-box eq">
				<h1>A Really Long Title for this Article</h1>
				<time datetime="01/01/2017">January 1, 2017</time>
				<p>This is a description of the article.</p>
			</div>
		
			<div class="article-box eq">
				<h1>A Short Title</h1>
				<time datetime="01/01/2017">January 1, 2017</time>
				<p>Now these articles have different heights.</p>
			</div>
	
			<div class="article-box eq">
				<h1>A Really Long Title for this Article</h1>
				<time datetime="01/01/2017">January 1, 2017</time>
				<p>This is a description of the article.</p>
			</div>

		</div>

	</section> 
 
## Javascript Methodology

My JS setup does not use any frameworks and is not written in ECMA2016. This is because the vast majority of projects we are building are brochureware, and not dynamic web apps. (If the project is a dynamic web app, you will need to reconsider the build script to accommodate a framework of your choice.)

- We are running jQuery 3.3.1, meaning IE8 and lower is not supported. 
- Each custom script is considered a "module" and all modules run simultaneously on all pages of the site. Target modules by dropping a data-target['my-module'] on the element, instead of a class or ID, unless you can anticipate that there will only ever be one rendered on a page. I know data attributes are technically slower to select than classes, but this will not be an issue in performance for the size sites we are dealing with. Also, I do not subscribe to the separation-of-concerns issue here--that data attributes are not intended to be used this way--because neither are classes, and this makes it easy to see, at a glance, that a module has JS functions attached to it, whereas using classes this not apparent. 
- Modules are loaded after all libraries from Yarn and third-party vendor scripts are globbed.

### Build vs. Debug Mode

When ```WP_DEBUG``` in the ```wp-config.php``` is set to true, we are in "non-build mode." When it is false, we are in "build mode."

The significance of this is that in non-build mode, all JS scripts are enumerated in the ```footer.php```, following this order:

1. Dependency libraries from package.json (you can add libraries with ```yarn add mylibrary --save```)
2. Vendor libraries (for manually dropping vendor files that cannot be loaded with Yarn)
3. ```app.init.js``` (this declares the global WPX object for modules)
4. Module scripts (your custom scripts)

This looks like the following in the ```footer.php``` file:

	<?php if (WP_DEBUG == true) : ?>
		
		<!-- yarn:js -->
		<script src="<?php echo assets_url(); ?>/js/libraries.js"></script>
		<!-- endinject-->
		<!-- inject:vendor:js -->
		<script src="<?php echo assets_url(); ?>/js/vendor/jquery.imagesloaded.js"></script>
		<script src="<?php echo assets_url(); ?>/js/vendor/jquery.matchheight.js"></script>
		<!-- endinject -->
		<!-- inject:init:js -->
		<script src="<?php echo assets_url(); ?>/js/app.init.js"></script>
		<!-- endinject -->
		<!-- inject:modules:js -->
		<script src="<?php echo assets_url(); ?>/js/modules/layout.js"></script>
		<script src="<?php echo assets_url(); ?>/js/modules/utility.js"></script>
		<!-- endinject -->
	
	<?php endif; ?>

The scripts that are globbed into libraries.js are the ones you add through Yarn in your package.json. By default, these are the dependencies WPX loads:

	"dependencies": {
		"enquire.js": "https://github.com/WickyNilliams/enquire.js/",
		"fitvids.1.1.0": "^1.1.0",
		"dense": "https://github.com/gocom/dense",
		"jquery": "^3.3.1",
		"jquery-validation": "^1.17.0",
		"slick-carousel": "^1.8.1"
	},

You can delete ones you don't want from the package.json, and add new ones with the above yarn command. Notice that you can also put in a git repo to resolve libraries that misbehave. Additionally, if you need to add a library that isn't on Yarn, just drop the .js file into the ```/vendor/``` folder.

In build mode, only ```app.min.js```, generated by running ```gulp build```, is referenced in the footer via an enqueue hook in WordPress.

### Writing Custom JS Modules

In ```/js/modules/``` you will find each custom JS module. You can create as many as you like, just remember that they all run simultaneously and in the order they are named. You can artificially control their load order by naming them appropriately but the assumption is that they are being written in such a way that they are not interdependent on each other. Therefore it is not wise to build synchronous relationships between modules; assume they are running asynchronously, all after jQuery is ready. 

Here is what an empty module would look like:

	jQuery(document).ready(function($) {

		'use strict';

		WPX.Utility = {
	
			someVariable: false,
			$someElement: $('.my-element'),

			init: function() {
	
				// bind onclicks here
				this.bindEvents();
				
				// fire an arbitrary function
				this.myFunction();

			},
	
			/** 
			 * bind all events
			*/
			bindEvents: function() {
				
				...

			},

			myFunction: function() {
				
				WPX.Utility.$someElement.addClass('yay');
				WPX.Utility.someVariable = 10;

			}
	
		};
	
		WPX.Utility.init(); // each module needs a unique name

	});

Tips:

- You can target functions inside modules globally by calling ```WPX.myModule.myFunction();```
- You can hook onto specific templates in WordPress by checking the body class, for example, or test for the existence of elements on the page: ```if ($('#my-element').length) { ... }```

### Concerning JS & Gulp

When you run ```gulp```, the build script will:

1) Compile all your sprites in ```/images/sprites/``` into spritesheet.png and spritesheet@2x.png, and create the relevant scss files in ```/styles/sass/utility/sprites/```;  
2) Load the fontello.config json to fetch the icon fonts, as well as update the scss related to those icon fonts;
3) Compile the scss in the ```/styles/sass/``` folder into css  
4) Retrieve all the dependencies in package.json and compile them into ```js/libraries.js```   
5) Update the ```footer.php``` file with a script tag to these libraries, all vendor libraries in the ```/js/vendor/``` folder, the ```/js/app.init.js``` file, and then all your ```/js/modules/```.  
6) ```jshint``` your ```/js/modules/```  
7) Run ```gulp watch```.  

When you run ```gulp build```, the build script will:

1) Do steps 1 - 3 in ```gulp``` above  
4) Uglify your css
5) ```jshint``` your ```/js/modules/```
6) Compile the ```/js/libraries.js``` file with ```/js/vendor/*.js```, ```/js/app.init.js``` and ```/js/modules/*.js``` in that order and uglify them, then generate an ```app.min.js``` containing the uglified JS  
7) Minify all images in ```/images/``` 

*Keep in mind that you should not allow WP to inject JS into the theme using the enqueue, and if you must, make sure it loads these scripts in the footer, and does not pull in dependencies like jQuery, etc.*

(The ```<?php wp_footer(); ?>``` tag is loaded before all our scripts.)

## Gulp Build Script

The gulp build script is already written for you and ready to go.

### Prep Fonts

After you haved updated the Fontello [Icon Fonts](#icon-fonts), you then need to run the following Gulp command:

```gulp fontello```

### Generate Sprites

If you are using [Retina Sprites](#retina-sprites), whenever you add more sprites to ```/images/sprites/``` you need to run the following Gulp command:

```gulp sprites```

As a result, Gulp will merge your sprites together into a retina and non-retina sprite sheet in ```/images/spritesheet.png``` and ```/images/spritesheet@2x.png``` and then update the ```/styles/sass/utility/sprites.scss``` with the newly available mixins.

### Watch with Livereload

When you're developing, you'll want Gulp to listen for when you save any SASS or JS files, so that the browser reloads the styles, or refreshes the page in the event that you altered JS. This will also refresh the page is PHP files are saved.

```gulp watch``` (or just ```gulp```)

*The difference between ```gulp watch``` vs. ```gulp``` is that ```gulp watch``` will not check for new icon font files or sprites.*

- If a scss file is changed, it will compile your scss into sass
- If a JS file is changed, it will retrieves all the dependencies in package.json and compile them into ```js/libraries.js```, then update the ```footer.php``` and jshint your modules.
- If a php file is changed, it will reload the page. Livereload listens for changed .php files in theme root, ```/templates/```, and ```/partials/```  

Make sure you have the Chrome extension [Livereload](https://goo.gl/b1wkQu) installed. You need to run ```gulp watch``` first, then click the Livereload icon in your browser to enable live reloading.

## About Yarn

I am using Yarn only to pull JS dependencies listed in package.json into the ```/node_modules/``` folder. 

Yarn lets you pull scripts from a central repository in the web and install specific versions from the command line. For example, instead of going to the jQuery website and downloading it manually, you can run:

```yarn add jquery --save```

And Yarn will add jquery to the list of package.json dependencies, pull down the latest version of jQuery and put it in the ```/node_modules/``` folder. The build script will pluck out the relevant files via the package.json listing.

You can find libraries for just about everything here: [Yarn Search](https://yarnpkg.com/en/packages).