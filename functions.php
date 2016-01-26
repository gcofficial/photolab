<?php
add_theme_support( "title-tag" );
/**
 * photolab functions and definitions
 *
 * based on Underscores starter WordPress theme
 *
 * @package photolab
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function photolab_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on photolab, use a find and replace
	 * to change 'photolab' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'photolab', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	// Add editor styling
	add_editor_style( 'editor-style.css' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( 
		array(
			'top'    => __( 'Top Menu', 'photolab' ),
			'main'   => __( 'Main Menu', 'photolab' ),
			'footer' => __( 'Footer Menu', 'photolab' ),
		) 
	);

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'photolab_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Setup required image sizes
	 */
	set_post_thumbnail_size( 405, 385, true );
	add_image_size( 'fullwidth-thumbnail', 1040, 385, true );
	add_image_size( 'nav-thumbnail', 555, 150, true );
	add_image_size( 'gallery-large', 628, 390, true );
	add_image_size( 'gallery-small', 382, 180, true );

}
add_action( 'after_setup_theme', 'photolab_setup' );

/**
 * Enqueue scripts and styles.
 */
function photolab_assets() {

	// Styles
	global $wp_styles;

	wp_enqueue_style( 'photolab-layout', get_template_directory_uri() . '/css/layout.css', array(), '1.1.0' );
	wp_enqueue_style( 'photolab-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'photolab-fonts', photolab_fonts_url(), array(), null );
	wp_enqueue_style( 'photolab-style', get_stylesheet_uri(), array(), '1.1.0' );

	// layot CSS for old IE
	$wp_styles->add( 'photolab-layout-ie', get_template_directory_uri() . '/css/layout-ie.css', array(), '1.1.0' );
	$wp_styles->add_data( 'photolab-layout-ie', 'conditional', 'lte IE 8' );
	$wp_styles->enqueue( array( 'photolab-layout-ie' ) );

	// Also enqueue Font Awesome for social icons, they are enabelrd in options
	$options = get_option( 'photolab' );
	
	wp_enqueue_style( 'photolab-font-awesome', get_template_directory_uri(). '/css/font-awesome-4.5.0/css/font-awesome.min.css' );

	// Script
	wp_enqueue_script( 'photolab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'photolab-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'photolab-superfish', get_template_directory_uri() . '/js/jquery.superfish.min.js', array('jquery'), '1.4.9', true );
	wp_enqueue_script( 'photolab-mobilemenu', get_template_directory_uri() . '/js/jquery.mobilemenu.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'photolab-sfmenutouch', get_template_directory_uri() . '/js/jquery.sfmenutouch.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'photolab-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'photolab-device', get_template_directory_uri() . '/js/device.min.js', array('jquery'), '1.0.2', true );
	wp_enqueue_script( 'photolab-sticky', get_template_directory_uri() . '/js/jquery.stickyheader.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'photolab-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js', array('jquery') );
	
	wp_localize_script( 
		'photolab-custom', 
		'photolab_custom', 
		array('stickup_menu' => HeaderSettingsModel::getStickupMenu()) 
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'photolab_assets' );

/**
 * Add to wp admin script and styles
 */
function admin_script_and_styles( $hoot_suffix ) {
	if ( $hoot_suffix == 'appearance_page_about_photolab' ) {
		// ==============================================================
		// Scripts
		// ==============================================================
		wp_enqueue_script( 'about-photolab-core', get_template_directory_uri().'/js/core.min.js', array(), false, true );
		wp_enqueue_script( 'about-photolab', get_template_directory_uri().'/js/about_photolab.js', array(), false, true );

		// ==============================================================
		// Styles
		// ==============================================================
		wp_enqueue_style( 'about-photolab-style', get_template_directory_uri().'/css/about_photolab.css' );
		wp_enqueue_style( 'open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700' );
	}
}
add_action( 'admin_enqueue_scripts', 'admin_script_and_styles' );

/**
 * Get allowed socials list
 */
function photolab_allowed_socials() {

	$socials = array(
		'facebook' => array(
			'label' => __( 'Facebook', 'photolab' ),
			'icon'  => 'fa-facebook-official'
		),
		'twitter' => array(
			'label' => __( 'Twitter', 'photolab' ),
			'icon'  => 'fa-twitter'
		),
		'google-plus' => array(
			'label' => __( 'Google+', 'photolab' ),
			'icon'  => 'fa-google-plus'
		),
		'instagram' => array(
			'label' => __( 'Instagram', 'photolab' ),
			'icon'  => 'fa-instagram'
		),
		'linkedin' => array(
			'label' => __( 'LinkedIn', 'photolab' ),
			'icon'  => 'fa-linkedin'
		),
		'dribbble' => array(
			'label' => __( 'Dribbble', 'photolab' ),
			'icon'  => 'fa-dribbble'
		),
		'youtube' => array(
			'label' => __( 'YouTube', 'photolab' ),
			'icon'  => 'fa-youtube'
		)
	);

	return apply_filters( 'photolab_allowed_socials', $socials );

}

/**
 * Include Google fonts
 */
function photolab_fonts_url() {

	$fonts_url = '';

	$locale = get_locale();

	$cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

	/* Translators: If there are characters in your language that are not
	* supported by Lora, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$libre = _x( 'on', 'Libre Baskerville font: on or off', 'photolab' );

	/* Translators: If there are characters in your language that are not
	* supported by Open Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'photolab' );

	if ( 'off' !== $libre || 'off' !== $open_sans ) {

		$font_families = array();

		if ( 'off' !== $libre ) {
			$font_families[] = 'Libre Baskerville:400,700,400italic';
		}

		if ( 'off' !== $open_sans ) {
			$font_families[] = 'Open Sans:300,400,700,400italic,700italic';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		if ( in_array($locale, $cyrillic_locales) ) {
			$query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
		}

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

// Additional template tags
require get_template_directory() . '/inc/template-tags.php';
// Additional functions
require get_template_directory() . '/inc/extras.php';
// Include customizer
require get_template_directory() . '/inc/customizer.php';
// Include custom header support
require get_template_directory() . '/inc/custom-header.php';
// Jetpack compatibility file
require get_template_directory() . '/inc/jetpack.php';

/**
 * Tools
 */
require_once get_template_directory() . '/inc/tools.php';

/**
 * Walkers
 */
require_once get_template_directory() . '/inc/photolab_walker.php';

/**
 * Models
 */
require_once get_template_directory() . '/inc/models/options.php';
require_once get_template_directory() . '/inc/models/general_site_settings.php';
require_once get_template_directory() . '/inc/models/header_settings.php';
require_once get_template_directory() . '/inc/models/blog_settings.php';
require_once get_template_directory() . '/inc/models/footer_settings.php';
require_once get_template_directory() . '/inc/models/typography_settings.php';
require_once get_template_directory() . '/inc/models/sidebar_settings.php';
/**
 * Widgets
 */
require_once get_template_directory() . '/inc/widgets/accordion_widget.php';
require_once get_template_directory() . '/inc/widgets/flex_slider_widget.php';
require_once get_template_directory() . '/inc/widgets/instagram_widget.php';
require_once get_template_directory() . '/inc/widgets/google_plus_widget.php';
require_once get_template_directory() . '/inc/widgets/advertisement_widget.php';


/**
 * Meta Boxes
 */
require_once get_template_directory() . '/inc/metaboxes/social_post_types.php';
require_once get_template_directory() . '/inc/metaboxes/sidebars.php';

/**
 * Theme pages
 */
require_once get_template_directory() . '/inc/pages/upgrade_to_pro.php';

/**
 * Customizer
 */
require_once get_template_directory() . '/inc/customizer/sidebar_creator.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function photolab_widgets_init() {
	register_sidebar( 
		array(
			'name'          => __( 'Sidebar', 'photolab' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Allowed only on static pages', 'photolab' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) 
	);

	register_sidebar( 
		array(
			'name'          => __( 'Sidebar second', 'photolab' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Allowed only on static pages', 'photolab' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) 
	);

	register_sidebar( 
		array(
			'name'          => __( 'Footer Widget Area', 'photolab' ),
			'id'            => 'footer',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s '.FooterSettingsModel::getColumnsCSSClass().' col-sm-6">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) 
	);

	$sidebar_creator = SidebarSettingsModel::getSidebarsOptions();
	if(count($sidebar_creator))
	{
		foreach ($sidebar_creator as $sidebar) 
		{
			register_sidebar( $sidebar );
		}
	}
}
add_action( 'widgets_init', 'photolab_widgets_init' );


/**
 * Return template part in string
 * @param  string $slug --- template part slug
 * @param  string $name --- tmplate name
 * @return string --- html code
 */
function getTemplatePartStr( $slug, $name )
{
	ob_start();
	get_template_part( $slug, $name );
	return ob_get_clean();
}

/**
 * Loop 
 * @param  string $slug --- slug name
 * @param  string $name --- name
 * @return string       --- html code
 */
function loop($slug, $name)
{
	if(BlogSettingsModel::isMasonryLayout())
	{
		return masonryLoop($slug, $name);
	}

	if(BlogSettingsModel::isGridLayout())
	{
		return gridLoop($slug, $name);
	}
	return defaultLoop($slug, $name);
}

/**
 * Grid loop
 * @param  string $slug --- slug name
 * @param  string $name --- name
 * @return string       --- html code
 */
function gridLoop($slug, $name)
{
	global $wp_query;
	$posts = $wp_query->get_posts();
	return Tools::renderView(
		'loop_row_grid',
		array(
			'posts'            => $posts,
			'columns_count'    => BlogSettingsModel::getColumns(),
			'column_css_class' => BlogSettingsModel::getColumnCSSClass(),
			'slug'             => $slug,
			'name'             => $name
		)
	);	
}

/**
 * Masonry loop
 * @param  string $slug --- slug name
 * @param  string $name --- name
 * @return string       --- html code
 */
function masonryLoop($slug, $name)
{
	global $wp_query;
	$posts = $wp_query->get_posts();
	return Tools::renderView(
		'loop_row_masonry',
		array(
			'posts'            => $posts,
			'columns_count'    => BlogSettingsModel::getColumns(),
			'column_css_class' => BlogSettingsModel::getColumnCSSClass(),
			'slug'             => $slug,
			'name'             => $name
		)
	);	
}

/**
 * Default loop
 * @param  string $slug --- slug name
 * @param  string $name --- name
 * @return string       --- html code
 */
function defaultLoop($slug, $name)
{
	global $wp_query;
	$posts = $wp_query->get_posts();
	return Tools::renderView(
		'loop_row',
		array(
			'posts'            => $posts,
			'slug'             => $slug,
			'name'             => $name
		)
	);
}