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
- [Gutenberg](#gutenberg)
- [Plugin List](#plugins)

<!-- tocstop -->

## Features

* Install with WPX Utility, a plugin that contains helper functions for use with the theme;
* Ready for use with Advanced Custom Fields & Gutenberg
* Stripped-down, un-opinionated WP templates
* PHP namespacing for hooks and functions;
* Includes Gulp-powered build script for the front end;
	* Simple, CSS framework-free globbed Sass;
	* Includes dynamic icon fonts via Fontello;
	* Includes inline retina images and retina background images

## Installation

1. Download and install the latest version of WordPress from [WordPress.org](https://wordpress.org/download/).

2. Download and activate the [WPX Utility plugin](https://github.com/alkah3st/wpx-utility).

3. Download and activate the WPX Theme in your ```/wp-content/themes/``` folder. Then cd into ```/assets/``` and run:

4. In ```/wp-content/themes/wpx/assets/gulpfile.js``` put in your local environment path in the external-css task.

Run the following command in terminal:

```
npm install
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

- **blocks.php** is for including ACF Gutenberg blocks
- **comments.php** contains the HTML walker for comments
- **dashboard.php** is hooks that alter the Dashboard
- **enqueue.php** is for any FE injection of assets
- **feed.php** is for modifications to the RSS feed output
- **plugins.php** is for any hooks that interact with plugins
- **rewrites.php** is for any URL rewriting hooks
- **schema.php** is for augmenting the theme's schema markup
- **templates.php** is for hooks that alter the way WP templates/UI functions

Each of these is namespaced, for example, to call a function defined in ```\WPX\Enqueue\```, you would write:

```\WPX\Enqueue\my_function();```

All of the hook files are loaded via the default ```functions.php``` file in the theme root, as well as any theme initialization logic.

### Classes & Components

WPX autoloads the folder structure under ```/classes/``` as classes. It ships with ```/Theme/``` and ```/UI/``` as groups to create more classes related to individual modules. For example, you might create a ```Slideshow.php``` class under ```/UI/``` for a component (that is not a block) but needs its own UI and functios.

Here is an example of a class:

	<?php
	/**
	 * Example Module
	 *
	 * @package WordPress
	 * @subpackage WPX_Theme
	 * @since 0.1.0
	 * @version 1.0
	 */
	namespace WPX\Classes\UI;
	
	class ExampleModule {
	
		function __construct($params=false) {
	
			// if we wanted to set some parameters on init

			$defaults = array (
				'default_setting' => false,
			);
	
			$this->args = wp_parse_args( $params, $defaults );
	
			/**
			 * Example Calling a Method Dynamically
			 */
			
			// $variableMethod = 'string'.$variable;
			// $this->$variableMethod($post);
	
		}
		
		function exampleHeader() {
			echo "hey!";
		}
	
	}

You would invoke this class like so:

	$exampleModule = \WPX\Classes\UI\ExampleModule();
	$exampleModule->exampleHeader();

The objective is to isolate component output and their related from WP templates or the organization of other hooks in ```/includes/``` to keep things clean.

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

### Temp Images

The folder ```/assets/images/temp/``` is for image assets used during development (typically sampled from [source.unsplash.com](source.unsplash.com). The folder should not reach production.

### Favicons

I use [Real Favicon Generator](https://realfavicongenerator.net/) to generate a set of crossbrowser compatible favicons for the theme. See the ```header.php``` for example output, or visit the website. These graphics are stored in 	```/assets/images/favicons```.

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

		<h1>Recent Articles</h1>

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
- Use 4 tabs for spaces;
- Do not write vendor prefixes for CSS3 properties in your CSS. The build script will handle this automatically. So write ```border-radius: 10px``` and not ```-webkit-border-radius: 10px```;
- Do not use IDs. We target elements in JS with data attributes.
- Don't use em font sizes (see below for the desired methodology)
- When defining line-height, use fixed values like 1, 1.5 and not 32px unless you are vertically-centering an element

### SASS Globbing

All the SASS files for the project are in ```/styles/sass/``` folder, organized like so:

	globals
		- base.scss // for global styles
		- blocks.scss // all styles related to core Gutenberg blocks
		- buttons.scss // styles global buttons from Gutenberg 
		- footer.scss // styles related to the footer
		- forms.scss // styles related to form elements
		- header.scss // styles related to the header
	modules // module-based styles
		- blocks
			- custom-block.scss // an example "Custom Block" for Gutenberg
			- other-custom-block.scss ...
		- components
			- my-component.scss // for non-block modules used in the theme
		- navs
			- nav-footer.scss // for the footer nav
			- nav-mobile.scss // for the mobile nav
			- nav-primary.scss // for the primary nav
	utility // variables, fonts, mixins
		- colors.scss // generated by a function in WP (DO NOT EDIT)
		- mixins.scss // global mixins
		- normalize.scss // this is the latest normalize 
		- sprites.scss // generated via the spritemap in gulp (DO NOT EDIT)
		- tinymce.scss // styles non-block markup from Gutenberg
		- variables.scss // global variavles
	vendor // sass from third parties
		- modal.scss ... 

**Globals.** In ```base.scss``` we includes selectors that can be used anywhere in the website, such as element overrides, global classes, and structural selectors that are not context dependent.

**Gutenberg/VE Styles.** The mixin ```tinymce.scss``` contains styles to handle the non-block output of the Gutenberg editor, whereas the sheet ```blocks.scss``` contains styles to handle the core Gutenberg block output. Wherever in the templates of the site I might output the contents of a visual editor, I need to ensure that all outputted markup is styled consistently. In this case I will wrap the output with a ```.tinymce``` class. This ensures the limited set of markup that the Visual Editor can output styles the outputted markup in isolation.

**Modules (Components vs. Blocks).** You can break down other contextual groups of selectors into individual SASS files under ```/modules/```, in whatever way makes sense for the project. Typically a discreet bundle of contextual selectors, such as a block or a primary navigation, is a good candidate for a separate .scss file in ```/modules/```. Note that we make a distinction between a module that is a block (meaning, a Gutenberg block registered in the system) and a component, which is not a block, and organize the CSS separately.

**Buttons.** We make use of the button block in WP across the theme, so ```buttons.scss``` is treated separately from other blocks so that any modifications to the blocks in Gutenberg also impacts buttons elsewhere in the theme.

**Color Map Variables.** In the ```functions.php``` you will find a function called ```wpx_color_array```. Define the system-wide colors to be used in the theme in this array. In turn, the theme will generate a ```color.scss``` with your variables, for use both in the gulp build script AND in Gutenberg interface for the end user. Do not the edit the rendered file as it gets overwritten when the build script is run. (To generate a new color map, visit the URL /wpx-local/color-map/ in your install and a new .scss file will be generated.) 

**Vendor**. The ```/vendor/``` folder is meant for including any SASS partials or CSS provided by third party plugins, and will get compiled with everything else. The styles in ```/vendor/icons/``` as well as the ```sprites.scss``` and ```colors.scss``` sheet are generated by the built script. Just rename any vendor CSS to SASS and drop in this folder.  

### Writing Selectors

Above all else, we want to adhere to DRY principles (Do Not Repeat Yourself), keep things simple, and make things easy to understand. It's OK to repeat selectors if it means you can better isolate a module to make it re-usable throughout the site. At the same time, don't pursue modularity at the cost of sanity: we are building brochureware, not Facebook. For these reasons, avoid BEM or (severely) Atomic CSS methodologies.

Some quick ground rules for SASS:

- Do not nest selectors more than 3 levels deep;
- Avoid complicated SASS abstractions and/or calculations;
- Put mixins immediately after an opening selector, then all properties of the selector, then pseudo element selectors, then state modifiers, then nested selectors.

#### Types of Selector-Objects

Let's establish some specific guidelines about writing nested selectors, in the spirit of SMACSS. Since we can nest selectors with SASS, the goal is to categorize our nested selectors into "selector objects" and use them with purpose. Any selector object you write should fit into one of these categories:

**Global Objects.** These are selector objects that are meant to be used anywhere in the site, independent of context. Global objects may not have a lot of nested selectors, if any at all. You shouldn't have a lot of these, and you shouldn't treat them like state modifiers (see below), otherwise you'll end up with Atomic CSS (which we do not like). A ```.button``` is a good example of a global object:

	.button {
		@include font-size(14px, 12px);
		background-color: color('yellow');
		display: inline-block;
		padding: 12px 0;
		border-radius: 30px;
		color: color('black');
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

As you can see, this selector is an object unto itself: you could place it anywhere in the site and it doesn't rely on any properties outside of itself to be presentable.

**Module Objects**. Probably the most common type of selector object you will write. They're generally self-contained, and may have a great deal of nested selectors. Like global objects, modules are also generally context-independent, but they are less likely to be nested inside of other selector objects. The difference between global objects and module objects is really a matter of complexity. 

	.module {

		// special context
		&.in-sidebar {
			... styles that alter this module specifically by context
			... here we can break the rule of 3, because:
			... .module.in-sidebar .module-inner .module-description is still 3 deep
		}

		.module-inner {

			.module-description {
				...
			}

		}

		.module-title {
			...
		}

		// this module alters the look of the global .button object
		.button {
			... // styles that alter the button specifically for this module
		}

	}

The module object's naming pattern is best expressed as: 

	name (.module)
		> name + context (.module-inner)
			> name + context (.module-description)

The topmost selector is represented by a unique namespace ```.module```, and nested selectors should be prefixed with the module's unique name.

Whenever you make a new module, puts its styles into a corresponding file ```module.scss``` in the ```/assets/styles/sass/modules/components/``` folder (or ```/assets/styles/sass/modules/blocks/```	if the module is a Gutenberg block).

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
		.module {
			...
		}

	}

The naming pattern for layout objects should borrow from a fixed list of predefined layout types (such as the list enumerated above), where the topmost selector and nested selectors are prefixed with the layout type: 

	layout type + context (.header-main)
		> layout type + context + secondary context (.header-main-outer) 
			> layout type + context + tertiary context (.header-main-inner)

The right place for most layout objects is in ```base.scss```, though if you have a lot of them, it might make sense to organize them into a ```/structures/``` folder in partials like ```footer.scss``` and ```header.scss``` nested within ```/base/``` for example.

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

Mainly these are fonts, variables for the global context (the max-width of the site, see below), the site's margin rhythm (see below), global color declarations from Gutenberg, and viewport sizes. 

Do not litter your partials with hex values or font declarations.

### Declaring Colors

To declare a color in an element, simply use the ```color();``` function:

```

my-element {
	color: color('yellow');
}

```

The colors are declared in the functions.php and used across the theme and in Gutenberg.


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

### Breaking Out of Context

Note that there is also a ```$context-wide``` variable. While ```$context``` defines the standard page width for the flow of content, ```$context-wide``` optionally defines the size Gutenberg uses when a block is set to "wide" width, meaning it breaks out of the flow about 150%. Typically this is 1400px vs. the standard 1200px.

You can force a block or component to break out of the page context by using the ```width-wide()``` or ```explode-width()``` mixins:

    .my-block {
    	@include width-wide();
    }
    
Results in:

    .my-block {
    	width: 150%;
    	max-width: 150%;
    	margin-left: -25%;
    
    	@include breakpoint(1000px) {
    		width: 100%;
    		max-width: 100%;
    		margin-left: 0;
    	}
    }

You will want to redefine the breakpoint at which the block goes back to 100% width to suit the needs of the design.

For the ```explode-width()``` function:

    .my-block {
    	@include explode-width();
    }
    
Results in:

    .my-block {
    	width: 100vw;
    	margin-left: calc(-50vw + 50%);
    	position: relative;
    }

### Setting Breakpoints

If it makes sense to introduce a breakpoint for the primary navigation module (```/assets/styles/sass/modules/navs/nav-primary.scss```) at 800 pixels, 570 pixels, and 400 pixels, we should do that specifically for that module, even if the main content area only needs to break at 1000 pixels and 500 pixels.

You can define breakpoints by using the ```breakpoint();``` mixin. There are several predefined viewports (you will find the viewports in ```/assets/styles/sass/utility/variables.scss```), and they are: ```$viewport_ultrawide```, ```$viewport_desktop```, ```$viewport_tablet```, ```$viewport_phablet```, and ```$viewport_mobile```. These variables should be adjusted to better suit your design, and you are encouraged to define viewports as needed, directly into the function, if the prefdefined viewports are unsuitable in a particular context: @include breakpoint(548px).

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

There may be situations where you need to trigger JS at specific breakpoints. For this, I use [Enquire](https://wicky.nillia.ms/enquire.js/), which is already installed. You should define a set of Enquire breakpoints for each module in which it applies. For example, the layout.js module has a set defined for you (at arbitrary breakpoints);

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

## Javascript Methodology

The vast majority of projects we are building are brochureware, and not dynamic web apps. (If the project is a dynamic web app, you will need to reconsider the build script to accommodate a framework of your choice.)

To that end we just need a consistent way to reference elements via jQuery. We reference elements using either a data attribute ```data-target="element"``` or by controller ```data-controller="myController"```. Parent elements that are controllers contain child elements that are targets. Therefore treat data-target attributes as IDs unique to the parent data-controller. Similarly, data-controllers need to be treated as IDs unique to the page.

To reference a controller:

```WPX.Utils.ctrl('loader')``` would reference ```<div data-controller="loader"></div>```

To reference a target in a controller:

 ```WPX.Utils.target('loader','loaderSpinner')``` would reference ```<div data-target="loaderSpinner"></div>``` inside of ```<div data-controller="loader"></div>```.

Use camelCasing for the IDs inside targets and controllers. Keep in mind these utility functions cannot work with elements rendered via ajax.

- We are running jQuery 2.2.4 to support the widest variety of potential plugins in WP that may use jQuery. jQuery is the only script enqueued separately from the compiled JS in the theme, and it is loaded in the header to support maximum compatibility with plugins.

- Each custom script is considered a "module" and all modules run simultaneously on all pages of the site. 

### Build vs. Debug Mode

When ```define( 'WP_ENVIRONMENT_TYPE', 'development' );``` in the ```wp-config.php``` is set to development, we are in "non-build mode." When it is set to production, we are in "build mode." You can also use staging as a value with WP, but you'll need to modify the enqueue below to account for that.

The significance of this is that in non-build mode, all JS scripts are output in the ```footer.php``` uncompressed, following this compilation order:

1. Libraries in the js/vendor folder. We are not using a package manager here because, again, the goal is simplicity in brochureware. My experience building many, many of these types of sites is that there is no point fiddling with the tooling for something so simple. We simply drop the source files in js/vendor once, and we don't have to worry about those source files inadvertently getting updated because the build script has evolved. Since we are expecting that all module objects execute simultaneously, the order of compilation should not matter.
2. ```app.init.js``` (this declares the global WPX object for modules)
3. Module scripts (your custom scripts)

This looks like the following in the ```enqueue.php``` file of ```/includes/```:

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', assets_url().'/js/jquery.js', false, '2.2.4', false);

	wp_deregister_style( 'dashicons' ); 
	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library-theme' );
	wp_deregister_style( 'contact-form-7' );

	if (wp_get_environment_type() === 'development' || wp_get_environment_type() === 'local') {
		wp_enqueue_script( 'wpx.js', assets_url().'/js/app.js', false, filemtime( get_template_directory().'/assets/js/app.js' ), true);
		wp_enqueue_style( 'wpx.styles', assets_url().'/styles/screen.css', false, filemtime( get_template_directory().'/assets/styles/screen.css' ), 'screen');
	} else {
		wp_enqueue_script( 'wpx.js', assets_url().'/js/app.min.js', false, filemtime( get_template_directory().'/assets/js/app.min.js' ), true);
		wp_enqueue_style( 'wpx.styles', assets_url().'/styles/screen.min.css', false, filemtime( get_template_directory().'/assets/styles/screen.min.css' ), 'screen');
	}

In build mode, ```app.min.js``` is attached instead of app.js, by running ```gulp build```.

Note that we deregister a number of core styles that WP normally outputs. These styles are incorporated at build time and compiled into our global CSS to save on those queries for performance reasons. You will find in the ```gulp external``` function, we re-incorporate these styles by querying WP for them at build time. 

### Writing Custom JS Modules

In ```/js/modules/``` you will find each custom JS module. You can create as many as you like, just remember that they all run simultaneously and in the order they are named. They are being written in such a way that they are not meant to be interdependent on one another. It is not wise to build synchronous relationships between modules; assume they are running asynchronously, after jQuery is ready.

Here is what the general utility module looks like:

	jQuery(document).ready(function($) {

		'use strict';

		WPX.Utility = {
	
			$myController: WPX.Utils.ctrl('myController'),
			$myTarget: WPX.Utils.target('myController', 'myTarget'),
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

1) ```jshint``` your modules in ```/modules```  
2) Simultaneously compile the SASS into ```screen.css``` and JS into ```app.js```. (The JS compilation order is always ```/vendor/``` then ```app.init.js``` then ```/modules/```.  
3) Watch all sass files, js files, and php files for changes and refresh them with Livereload. (PHP files and JS files on save will refresh the page; only sass will hot reload.)  

When you run ```gulp build```, the build script will:

1) Do steps 1 - 3 in ```gulp``` above, though the sass and JS task will remove console logs, sourcemaps, and minify/uglify the compilation into ```screen.min.css``` and ```app.min.js``` respectively.  
2) Also simultaneously compile all your sprites in ```/images/sprites/``` into spritesheet.png and spritesheet@2x.png, and create the relevant scss files in ```/styles/sass/utility/sprites/```;  
3) Also simultaneously load the fontello.config json to fetch the icon fonts, as well as update the scss related to those icon fonts;  
4) Then minify all images and svgs in ```/images```  
5) Minify all Gutenberg-related sass files.  

**On first run, it's important to run ```gulp external``` to bring in any third party JS as well as several core WP styles so they can be incorporated into your build. You can add the external task to the build task if you want to ensure the latest is always pulled in a push to production, just keep in mind it may take a few seconds to run.**

You can also run the following tasks independently:

- ```gulp fontello``` to retrieve new files related to Fontello. Don't forget to run ```gulp``` afterwards.
- ```gulp sprites``` to generate new spritemaps. Don't forget to run ```gulp``` afterwards.

## Gulp Build Script

The gulp build script is already written for you and ready to go. See the ```package.json``` for version requirements.

### Prep Fonts

After you have updated the Fontello [Icon Fonts](#icon-fonts), you then need to run the following Gulp command:

```gulp fontello```

### Generate Sprites

If you are using [Retina Sprites](#retina-sprites), whenever you add more sprites to ```/images/sprites/``` you need to run the following Gulp command:

```gulp sprites```

As a result, Gulp will merge your sprites together into a retina and non-retina sprite sheet in ```/images/spritesheet.png``` and ```/images/spritesheet@2x.png``` and then update the ```/styles/sass/utility/sprites.scss``` with the newly available mixins.

This task is run on build.

### Compile Gutenberg Sass

When you ```watch``` with the gulp task, styles are also compiled for Gutenberg. Gulp will merge the sass files under ```styles\gutenberg``` into a single gutenberg.css that is in turn applied to the Dashboard.

You can control what styles get served to Gutenberg by editing the ```gutenberg.scss``` in the ```/assets/``` folder. All blocks by default are included, as well as the ```base.scss```, all utilities, buttons, and the core ```block.scss``` overrides. We also apply the theme's fonts (if you're using Gutenberg) and we apply the ```tinymce()``` mixin to the block editor here.

### Watch with Livereload

When you're developing, you'll want Gulp to listen for when you save any SASS or JS files, so that the browser reloads the styles, or refreshes the page in the event that you altered JS. This will also refresh the page is PHP files are saved.

```gulp watch``` (or just ```gulp```)

- If a scss file is changed, it will compile your scss into css.
- If a JS file is changed, it will ```jshint``` your modules, then compile everything in ```js/vendor/``` with ```app.init.js``` with everything in ```js/modules``` into ```app.js```.
- If a php file is changed, it will reload the page. Livereload listens for changed .php files in theme root, ```/templates/```, and ```/partials/```.  

Make sure you have the Chrome extension [Livereload](https://goo.gl/b1wkQu) installed. You need to run ```gulp``` first, then click the Livereload icon in your browser to enable live reloading.

## Gutenberg

WPX is Gutenberg-ready. WPX relies on the ACF Pro.

### Registering Custom Blocks

1) In ```includes/blocks.php``` copy the Custom Block registration to register your own. Change the parameters in the acf_register_block function as you see fit. Read about them in the [ACF documentation](https://www.advancedcustomfields.com/resources/acf_register_block/ "ACF Documentation for acf_register_block"). The parameter for ```render_template``` is the file you will create in step 3.

2) You can also reference JS to run in Gutenberg if necessary when setting up the block. See the example block for reference.

2) Make sure the ```name``` of the block you registered matches the name in the ```allowed_block_types``` code. Your name will always be 'acf/name-of-block,' where 'name-of-block' is the name parameter entered into step 1.

3) Under ```templates\blocks\``` create a new file for your block and render the output of the block.

4) You'll finally need to make a corresponding ACF field in the Dashboard using the new Block field type to register your meta for the block, and assign the field to your new block.

Your custom blocks should now appear in Gutenberg.  

### Block Styles in the Dashboard

WPX applies a stylesheet called gutenberg.css to the Gutenberg editor (or ```gutenberg.min.css``` if ```WP_ENVIRONMENT_TYPE``` is set to development). This is a compilation of any sass files included in ```/styles/gutenberg/gutenberg.scss```. You will notice that there is a sample ```custom-block.scss``` in that directory, which contains the following:

	/**
	 * custom block
	 */
	.my-custom-block {
	}

We load a limit subset of the styles defined in the theme into Gutenberg to avoid having to repeat styles. This is so that only the styles related to the block are introduced to the Gutenberg editor. Gutenberg styles blocks by default in the editor already, so we only need to add styles we'd like to appear in the editor to make the block look similar to its end result on the front end. Thus the goal with applying only the relevant block styles is to create a low-fidelity presentation of the block within the Gutenberg editor itself.

## Plugin List

In WPX I typically start with the following plugins in every install:

- ACF Advanced Taxonomy Selector
- ACF Fold Flexible Content
- ACF Post Type Selector
- Admin Menu Editor
- Advanced Custom Fields Nav Menu Field
- Advanced Custom Fields Pro
- Akismet Anti-Spam
- Better Search Replace
- CMS Page Tree View
- Contact Form 7
- Duplicate Post
- FakerPress
- Flamingo
- Image Regenerate Select Crop
- Relevanssi
- Safe SVG
- Simple Page Ordering
- Simple Taxonomy Ordering
- Syntax Highlighting Code Block
- User Switching
- W3 Total Cache
- Yoast SEO
- WP CronTrol
- WP Mail SMTP
- WP Nested Pages
- WP-PageNavi
- WP Extend Utilities (*required*)