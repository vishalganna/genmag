<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
//load_child_theme_textdomain( 'genmag', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'genmag' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'GenMag', 'genmag' ) );
define( 'CHILD_THEME_URL', 'https://geekbone.org/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'genmag_enqueue_scripts_styles' );
function genmag_enqueue_scripts_styles() {

	wp_enqueue_script( 'genmag-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	//wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lora:400,700|Oswald:400', array(), PARENT_THEME_VERSION );

}

//* Add new featured image size
add_image_size( 'grid-featured', 300, 150, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 320,
	'height'          => 65,
	'header-selector' => '.site-header .title-area',
	'header-text'     => false
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Remove breadcrumb and navigation meta boxes
add_action( 'genesis_theme_settings_metaboxes', 'genmag_remove_genesis_metaboxes' );
function genmag_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'genmag_secondary_menu_args' );
function genmag_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'genmag_remove_comment_form_allowed_tags' );
function genmag_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'genmag_author_box_gravatar' );
function genmag_author_box_gravatar( $size ) {

	return 128;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'genmag_comments_gravatar' );
function genmag_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Wrap widget title with a div
add_filter( 'genesis_register_widget_area_defaults', 'wrap_widget_title_with_div' );

function wrap_widget_title_with_div( $defaults ) { 

	$defaults['before_title'] = '<div class="widget-title"><h4 class="widgettitle">';
	$defaults['after_title'] = "</h4></div>\n";

	return $defaults;
	
}