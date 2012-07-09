<?php

remove_action( 'wp_head', 'wp_generator' );

/**
 *  Remove unused user profile fields
 */
function m3_remove_contact_methods( $contactmethods ) {
	unset( $contactmethods['aim']    );
	unset( $contactmethods['yim']    );
	unset( $contactmethods['jabber'] );
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'm3_remove_contact_methods' );

/**
 * Remove admin bar items
 */
function m3_remove_admin_bar_items() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'new-link', 'new-content' );
	$wp_admin_bar->remove_menu( 'new-media', 'new-content' );
}
add_action( 'wp_before_admin_bar_render', 'm3_remove_admin_bar_items');

/**
 * Stop Skype from hijacking phone numbers
 * 
 * Adds a META tag to the HTML document head, that prevents Skype from 
 * hijacking/over-writing phone numbers displayed in the theme.
 * 
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-fix-skype-overwriting-phone-numbers-in-wordpress-themes/ 
 */
function m3_skype_meta() {
    echo '<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />';
}
add_action( 'wp_head', 'm3_skype_meta' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'm3_add_viewport_meta_tag' );
function m3_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/* Google CDN for jQuery */
function m3_google_jquery() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js", false, null);
	wp_enqueue_script('jquery');
}
if (!is_admin())
	add_action("wp_enqueue_scripts", "m3_google_jquery", 11);