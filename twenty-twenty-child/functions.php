<?php

// Add from parent
function theme_enqueue_styles() {
    $parent = 'twentytwenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parent, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version') );
    wp_enqueue_style( 'twentytwenty-child-style', get_stylesheet_uri(), array( $parent ), filemtime( dirname( __FILE__ ) . '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
