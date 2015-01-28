<?php
/**
* load script and style
**/ 

function load_style_script () {
    wp_enqueue_script('jqery', get_template_directory_uri() . '/js/jquery-2.1.3.min.js');
    //wp_enqueue_script('fakeLoader', get_template_directory_uri() . '/js/fakeLoader.min.js');
	//wp_enqueue_script('body', get_template_directory_uri() . '/js/body.js');
    wp_enqueue_style('reset', get_template_directory_uri() . '/reset.css');
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
    //wp_enqueue_style('fakeLoader', get_template_directory_uri() . '/fakeLoader.css');

}

add_action('wp_enqueue_scripts','load_style_script');

add_theme_support( 'post-thumbnails' );

function menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'menu' );

add_filter( 'post_thumbnail_html', 'remove_width_and_height_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_and_height_attribute', 10 );
function remove_width_and_height_attribute( $html ) {
   return preg_replace( '/(height|width)="\d*"\s/', "", $html );
}
add_filter('login_errors',create_function('$a', "return null;"));
// hide wp

function remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');

remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action('wp_head', 'previous_post_rel_link', 10, 0);
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action('wp_head', '_ak_framework_meta_tags');

remove_action('wp_head', 'wp_generator');

function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}

add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );

add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );




function callback($buffer) {
    $buffer = preg_replace('/<!--(.|\s)*?-->/', '', $buffer);
    return $buffer;
}
function buffer_start() {
    ob_start("callback");
}
function buffer_end() {
    ob_end_flush();
}
add_action('get_header', 'buffer_start');
add_action('wp_footer', 'buffer_end');

?>
