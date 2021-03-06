<?php
/**
 * Nu Themes functions and definitions
 *
 * @package Nu Themes
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since nuThemes 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 570; /* pixels */

if ( ! function_exists( 'nuthemes_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since nuThemes 1.0
 */
function nuthemes_setup() {

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 650, 240, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nuthemes' ),
	) );

}
endif;
add_action( 'after_setup_theme', 'nuthemes_setup' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since nuThemes 1.0
 */
function nuthemes_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'nuthemes_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since nuThemes 1.0
 */
function nuthemes_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'nuthemes_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since nuThemes 1.0
 */
function nuthemes_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'nuthemes' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'nuthemes_wp_title', 10, 2 );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since nuThemes 1.0
 */
function nuthemes_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'nuthemes' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #1', 'nuthemes' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #2', 'nuthemes' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #3', 'nuthemes' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #4', 'nuthemes' ),
		'id'            => 'sidebar-5',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'nuthemes_widgets_init' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since nuThemes 1.0
 */
function nuthemes_extra_col_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'col-sm-12 widget-area';
			break;
		case '2':
			$class = 'col-sm-6 widget-area';
			break;
		case '3':
			$class = 'col-sm-4 widget-area';
			break;
		case '4':
			$class = 'col-sm-3 widget-area';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * @since nuThemes 1.0
 */
function nuthemes_fonts_url() {
	$fonts_url = '';

	// Source Sans Pro
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'nuthemes' );

	// Bitter
	$bitter = _x( 'on', 'Bitter font: on or off', 'nuthemes' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueues scripts and styles for front end.
 *
 * @since nuThemes 1.0
 */
function nuthemes_scripts() {
	// Load Bootstrap stylesheet.
	wp_enqueue_style( 'nu-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array() );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'nu-genericons', get_template_directory_uri() . '/css/genericons.css', array() );

	// Add Open Sans and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style( 'nu-fonts', nuthemes_fonts_url(), array(), '20131010' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'nu-style', get_stylesheet_uri(), array() );

	// Load Bootstrap JavaScript.
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );

	// Adds JavaScript to support threaded comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nuthemes_scripts' );

define('NUTHEMES_PATH', get_template_directory() );

/**
 * Customizer additions.
 *
 * @since nuThemes 1.0
 */
require NUTHEMES_PATH . '/inc/customizer.php';

/**
 * Custom template tags for this theme.
 *
 * @since nuThemes 1.0
 */
require NUTHEMES_PATH . '/inc/template-tags.php';

/**
 * Custom nav walker to match Bootstrap structure.
 *
 * @since nuThemes 1.0
 */
require NUTHEMES_PATH . '/inc/wp-bootstrap-navwalker.php';

/**
 * Custom gallery using Bootstrap layout.
 *
 * @since nuThemes 1.0
 */
require NUTHEMES_PATH . '/inc/wp-bootstrap-gallery.php';