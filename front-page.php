<?php

add_action( 'genesis_meta', 'news_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function news_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) || is_active_sidebar( 'home-bottom' ) ) {
	
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'news_home_loop_helper' );
		//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
		add_filter( 'body_class', 'add_body_class' );
			function add_body_class( $classes ) {
   			$classes[] = 'news';
  			 return $classes;
		}
		
		//add_action( 'genesis_before_content_sidebar_wrap', 'child_front_page_before_content_sidebar_wrap' );
		
		add_action( 'genesis_loop', 'child_front_page_before_content_sidebar_wrap' );
		add_action( 'genesis_loop', 'child_grid_loop_helper' );

	}
}

function news_home_loop_helper() {
	global $paged;
     
    if( $paged >= 1 )
        return;
	
	if ( is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) ) {
		//bof slider
		echo '<div id="home-top-1"><div class="border wrap2">';
		echo '<div class="home-top-slider">';
		dynamic_sidebar( 'home-top-slider' );
		echo '</div><!-- end .home-top-slider -->';
		echo '</div><!-- end .border wrap --></div><!-- end #home-top-1 -->';
		
		echo '<div id="home-middle"><div class="border wrap2">';

			echo '<div class="home-middle-left">';
			dynamic_sidebar( 'home-middle-left' );
			echo '</div><!-- end .home-middle-left -->';

			echo '<div class="home-middle-right">';
			dynamic_sidebar( 'home-middle-right' );
			echo '</div><!-- end .home-middle-right -->';
		
		echo '</div><!-- end .border wrap --></div><!-- end #home-middle -->';
		
		
		echo '<div id="home-middle-2"><div class="border wrap2">';

			echo '<div class="home-middle-left-2">';
			dynamic_sidebar( 'home-middle-left-2' );
			echo '</div><!-- end .home-middle-left-2 -->';

			echo '<div class="home-middle-right-2">';
			dynamic_sidebar( 'home-middle-right-2' );
			echo '</div><!-- end .home-middle-right-2 -->';
		
		echo '</div><!-- end .border wrap --></div><!-- end #home-middle -->';
		
	}

}

//add_action( 'genesis_before_content_sidebar_wrap', 'child_front_page_before_content_sidebar_wrap' );
/**
 *  This function loads the three sidebars that will be used
 *  after the content and sidebar of the front page.
 */
function child_front_page_before_content_sidebar_wrap() {
    global $paged;
     
    if( $paged >= 1 )
        return;
 
    $home_sidebars = array (
        'home-top-1',
        'home-top-2',
        'home-top-3',
    );
  
    $wrap = '1';
      
    foreach( $home_sidebars as $id ){
          
        if( $wrap && is_active_sidebar( $id ) ) {
            echo '<div class="home-top">';
            $wrap = '';
        }
          
        genesis_widget_area( $id, array( 'before' => '<div class="'. $id . ' widget-area">' ) );
          
    }
      
    if( '' == $wrap )
        echo '</div><!-- end .home-top -->';
}
  
//add_action( 'genesis_after_content_sidebar_wrap', 'child_front_page_after_content_sidebar_wrap' );
/**
 *  This function loads the four sidebars that will be used 
 *  after the content and sidebar of the front page.
 */
function child_front_page_after_content_sidebar_wrap(){
	global $paged;
	if( $paged > 1 )
		return;
		
	$home_sidebars = array (
	'home-bottom-1',
	'home-bottom-2',
	'home-bottom-3',
	'home-bottom-3',
	);
	$wrap = '1';
	
	foreach( $home_sidebars as $id ){	
		if( $wrap && is_active_sidebar( $id ) ) {
			echo '<div class="home-bottom">';
			$wrap = '';
		}
		genesis_widget_area( $id, array( 'before' => '<div class="'. $id . ' widget-area">' ) );
	}
	if( '' == $wrap )
		echo '</div><!-- end .home-bottom -->';
}

//remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_action( 'genesis_loop', 'child_grid_loop_helper' );

function child_grid_loop_helper() {

	if ( function_exists( 'genesis_grid_loop' ) ) {
		genesis_grid_loop( array(
			'features' => 1,
			'feature_image_size' => 0,
			'feature_image_class' => 'alignleft post-image',
			'feature_content_limit' => 0,
			'grid_image_size' => 0,
			'grid_image_class' => 0,
			'grid_content_limit' => 250,
			'more' => __( '[Continue reading]', 'genesis' ),
			'posts_per_page' => 5,
		) );
	} else {
		genesis_standard_loop();
	}

}

genesis();