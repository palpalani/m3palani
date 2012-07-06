<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'M3Palani Child Theme' );
define( 'CHILD_THEME_URL', 'http://www.m3webware.com/m3palani' );

require_once( get_stylesheet_directory() . '/lib/utilities.php' );

function m3palani_setup() {
	/** Add support for custom background */
	add_theme_support( 'custom-background' );

	/** Add support for custom header */
	add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );

	/* Registering widgets */
	$home_sidebars = array (
		'home-top-slider'    => 'Home Slider',
		
		'home-middle-left'    => 'Home Middle Left',
		'home-middle-right'    => 'Home Middle Right',
		'home-middle-left-2'    => 'Home Middle Left 2',
		'home-middle-right-2'    => 'Home Middle Right 2',	
		
		'home-top-1'    => 'Home Bottom Column 1',
		'home-top-2'    => 'Home Bottom Column 2',
		'home-top-3'    => 'Home Bottom Column 3',
		
		'magazine-alternative'    => 'Magazine Sidebar',
		'magazine-alternative-alt'    => 'Magazine Sidebar Alt'
	);
	foreach( $home_sidebars as $id => $title ){
		genesis_register_sidebar( array(
		'id'          => $id,
		'name'        => $title,
		) );
	}
	
	/* Placing magazine widgets */
	add_action( 'genesis_after_content', 'child_do_sidebar' );
	function child_do_sidebar() {
		echo '<div id="magazine-sidebar">';
		echo '<div id="magazine-primary" class="sidebar widget-area">';
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Magazine Sidebar' ) ) {
		}
		echo '</div>';
		echo '<div id="magazine-secondary" class="sidebar widget-area">';
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Magazine Sidebar Alt' ) ) {
		}
		echo '</div>';
	}
	
	/** Add support for 3-column footer widgets */
	add_theme_support( 'genesis-footer-widgets', 3 );

}
add_action( 'after_setup_theme', 'm3palani_setup' );