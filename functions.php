<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Sample Child Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/genesis' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add support for custom background */
add_theme_support( 'custom-background' );

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );


genesis_register_sidebar(array(
	'name'=>'Magazine Sidebar',
	'id' => 'magazine-alternative',
	'description' => 'This is an alternative sidebar',
	'before_widget' => '<div id="%1$s"><div class="widget %2$s">',
	'after_widget'  => "</div></div>\n",
	'before_title'  => '<h4><span>',
	'after_title'   => "</span></h4>\n"
));
genesis_register_sidebar(array(
	'name'=>'Magazine Sidebar Alt',
	'id' => 'magazine-alternative-alt',
	'description' => 'This is an alternative sidebar',
	'before_widget' => '<div id="%1$s"><div class="widget %2$s">',
	'after_widget'  => "</div></div>\n",
	'before_title'  => '<h4><span>',
	'after_title'   => "</span></h4>\n"
));


add_action( 'genesis_after_content_sidebar_wrap', 'child_do_sidebar' );
function child_do_sidebar() {
	echo '<div id="magazine-sidebar">';
	echo '<div class="sidebar magazine-sidebar">';
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Magazine Sidebar' ) ) {
	}
	echo '</div>';
	echo '<div class="sidebar magazine-sidebar">';
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Magazine Sidebar Alt' ) ) {
	}
	echo '</div>';
}