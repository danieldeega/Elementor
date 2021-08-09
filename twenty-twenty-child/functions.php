<?php

// Add from parent
function theme_enqueue_styles() {
    $parent = 'twentytwenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parent, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version') );
    wp_enqueue_style( 'twentytwenty-child-style', get_stylesheet_uri(), array( $parent ), filemtime( dirname( __FILE__ ) . '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Remove admin bar for wp-test 
function remove_admin_bar()
{
    $user = wp_get_current_user();
    $username = $user->user_login;
    if ($username && $username == "wp-test") {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');