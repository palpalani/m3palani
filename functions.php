<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'M3Palani Child Theme' );
define( 'CHILD_THEME_URL', 'http://www.m3webware.com/m3palani' );

require_once( get_stylesheet_directory() . '/lib/utilities.php' );
require_once( get_stylesheet_directory() . '/lib/bootstrap-walker.php' );

function child_do_sidebar() {
	echo '<div id="magazine-sidebar">
			<div id="magazine-primary" class="sidebar widget-area">';
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Magazine Sidebar' ) ) {
		}
		echo '</div>';
		echo '<div id="magazine-secondary" class="sidebar widget-area">';
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Magazine Sidebar Alt' ) ) {
		}
	echo '</div>';
}

function m3palani_setup() {
	add_filter( 'http_request_args', 'm3_dont_update_m3palani', 5, 2 );
		
	/** Add support for custom background */
	add_theme_support( 'custom-background' );

	/** Add support for custom header */
	add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );
	
	add_action( 'genesis_meta', 'm3_add_viewport_meta_tag' );
	
	if (!is_admin())
		add_action("wp_enqueue_scripts", "m3_google_jquery", 11);
	
	add_action( 'wp_enqueue_scripts', 'm3_custom_stylesheet' );
	
	add_image_size( 'home-middle-left', 280, 180, TRUE );
	add_image_size( 'home-middle-right', 50, 50, TRUE );

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
	
	/** Add support for 3-column footer widgets */
	add_theme_support( 'genesis-footer-widgets', 3 );

}
add_action( 'after_setup_theme', 'm3palani_setup' );


/* Twitter Bootstrap nav bar */
add_filter( 'wp_nav_menu', 'm3_do_bootstrap_navbar', 30 );
function m3_do_bootstrap_navbar($menu){
	return '<div class="navbar navbar-static">
      <div class="navbar-inner">
        <div class="container">
	<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
	  <a class="brand" href="'. site_url() .'">'. get_bloginfo('sitename') .'</a>
	  <div class="nav-collapse collapse">'. $menu .'</div>
	  </div>
      </div>
    </div>';
}

function m3palani_do_nav() {

	if ( ! genesis_nav_menu_supported( 'primary' ) )
		return;

	if ( genesis_get_option( 'nav' ) ) {
		if ( has_nav_menu( 'primary' ) ) {
			$args = array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_class'     => 'nav nav-pills',
				'echo'           => 0,
				'depth'	=> 2,
				'walker'	 => new Bootstrap_Walker_Nav_Menu()
			);

			$nav = wp_nav_menu( $args );
		}
		$nav_output = sprintf( '<div id="nav">%2$s%1$s%3$s</div>', $nav, genesis_structural_wrap( 'nav', 'open', 0 ), genesis_structural_wrap( 'nav', 'close', 0 ) );

		echo apply_filters( 'genesis_do_nav', $nav_output, $nav, $args );
	}

}
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_after_header', 'm3palani_do_nav' );