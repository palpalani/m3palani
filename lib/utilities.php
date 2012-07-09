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

/** Add Viewport meta tag for mobile browsers
* Adds a META tag to the HTML document head, that prevents Skype from hijacking/over-writing phone numbers displayed in the theme.
*/
function m3_add_viewport_meta_tag() {
    echo '<meta name="HandheldFriendly" content="True"><meta name="MobileOptimized" content="320"><meta name="viewport" content="width=device-width, initial-scale=1.0"/><meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />';
}

/* Google CDN for jQuery */
function m3_google_jquery() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js", false, null);
	wp_enqueue_script('jquery');
}

/*
if you name your child theme something that already exists in the
wordpress repo, then you may get an alert offering a "theme update"
for a theme that's not even yours. Weird, I know. Anyway, here's a
fix for that.

credit: Mark Jaquith
http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
*/
function m3_dont_update_m3palani( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}