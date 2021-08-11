<?php

// Add from parent
function theme_enqueue_styles()
{
    $parent = 'twentytwenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style($parent, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version'));
    wp_enqueue_style('twentytwenty-child-style', get_stylesheet_uri(), array($parent), filemtime(dirname(__FILE__) . '/style.css'));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

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

// CPT
function twenty_twenty_child_custom_post_type()
{

    $labels = array(
        'name' => _x('Products', 'Post Type General Name', 'twentytwentychild'),
        'singular_name' => _x('Product', 'Post Type Singular Name', 'twentytwentychild'),
        'menu_name' => __('Products', 'twentytwentychild'),
        'parent_item_colon' => __('Parent Product', 'twentytwentychild'),
        'all_items' => __('All Products', 'twentytwentychild'),
        'view_item' => __('View Product', 'twentytwentychild'),
        'add_new_item' => __('Add New Product', 'twentytwentychild'),
        'add_new' => __('Add New', 'twentytwentychild'),
        'edit_item' => __('Edit Product', 'twentytwentychild'),
        'update_item' => __('Update Product', 'twentytwentychild'),
        'search_items' => __('Search Product', 'twentytwentychild'),
        'not_found' => __('Not Found', 'twentytwentychild'),
        'not_found_in_trash' => __('Not found in Trash', 'twentytwentychild'),
    );

    $args = array(
        'label' => __('Products', 'twentytwentychild'),
        'labels' => $labels,
        'has_archive' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-tag',
        'public' => true,
        'rewrite' => array('slug' => 'products'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('products', $args);
}
add_action('init', 'twenty_twenty_child_custom_post_type', 0);

// Categories
function twenty_twenty_child_register_new_taxonomy()
{
    $labels = [
        'name' => _x('Categories', 'taxonomy general name', 'twentytwentychild'),
        'singular_name' => _x('Category', 'taxonomy singular name', 'twentytwentychild'),
        'search_items' => __('Search Categories', 'twentytwentychild'),
        'all_items' => __('All Categories', 'twentytwentychild'),
        'parent_item' => __('Parent Category', 'twentytwentychild'),
        'parent_item_colon' => __('Parent Category:', 'twentytwentychild'),
        'edit_item' => __('Edit Category', 'twentytwentychild'),
        'update_item' => __('Update Category', 'twentytwentychild'),
        'add_new_item' => __('Add New Category', 'twentytwentychild'),
        'new_item_name' => __('New Category Name', 'twentytwentychild'),
        'menu_name' => __('Categories', 'twentytwentychild'),
    ];

    $args = [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'custom_categories'],
    ];

    register_taxonomy('custom_categories', ['products'], $args);
}
add_action('init', 'twenty_twenty_child_register_new_taxonomy', 0);

// Meta
function twenty_twenty_child_register_meta()
{

    register_post_meta('products', 'twentytwentychild_products_description', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ));

    register_post_meta('products', 'twentytwentychild_products_price', array(
        'type' => 'number',
        'single' => true,
        'show_in_rest' => true,
    ));

    register_post_meta('products', 'twentytwentychild_products_is_on_sale', array(
        'type' => 'boolean',
        'single' => true,
        'show_in_rest' => true,
    ));

    register_post_meta('products', 'twentytwentychild_products_sale_price', array(
        'type' => 'number',
        'single' => true,
        'show_in_rest' => true,
    ));
    register_post_meta('products', 'twentytwentychild_products_video', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ));

};
add_action('init', 'twenty_twenty_child_register_meta');

// Assets
function twenty_twenty_child_enqueue_assets()
{
    $screen = get_current_screen();
    if ($screen->post_type != 'products') {
        return;
    }

    wp_enqueue_script(
        'twentytwentychild-gutenberg-sidebar',
        get_stylesheet_directory_uri() . '/sidebar/products.js',
        array('wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post'),
        filemtime(dirname(__FILE__) . '/sidebar/products.js')
    );
}
add_action('enqueue_block_editor_assets', 'twenty_twenty_child_enqueue_assets');

function get_product_description($id)
{
    return get_post_meta($id, 'twentytwentychild_products_description', true);
}
function get_product_price($id)
{
    return get_post_meta($id, 'twentytwentychild_products_price', true);
}
function get_product_is_on_sale($id)
{
    return get_post_meta($id, 'twentytwentychild_products_is_on_sale', true);
}
function get_product_sale_price($id)
{
    return get_post_meta($id, 'twentytwentychild_products_sale_price', true);
}
function get_product_video($id)
{
    return get_post_meta($id, 'twentytwentychild_products_video', true);
}

function get_featured_image_by_id( $id ){
	global $post; 
	$post = get_post($id); 

	ob_start();
	get_template_part( 'template-parts/featured-image');
	$result = ob_get_contents(); 
	ob_end_clean();  
	wp_reset_postdata();

	return $result;
}

function twentytwentychild_product_shortcode($atts) {

	extract(shortcode_atts(array(
		'id'=>0,
		'color'=>'#BBB'
    ), $atts));
    
	$result = '';

	if( $id ) {
        $price = get_product_price($id);
        $is_on_sale = get_product_is_on_sale($id);
        $sale_price = get_product_sale_price($id);

		$result .=	'<div class="grid">';
		$result .= 		'<a href="' . esc_url( get_permalink($id) ) . '" class="grid-column grid-column-center" style="border: 1px solid '. $color .';">';
		$result .= 			get_featured_image_by_id($id);
		$result .=			'<p class="entry-title grid-title">' . get_the_title($id) . '</p>';
		$result .=			'<p class="price">' . ( $is_on_sale ? $price.'<span>'.$sale_price.'</span>' : $price ) . '</p>';
		if( $is_on_sale ) {
			$result .= 		'<div class="sale"><span>'.__('SALE', 'twentytwentychild' ).'</span></div>';
		}
		$result .= 		'</a>';
		$result .=	'</div>';
	}

	return apply_filters('custom_shortcode_product', $result);
}
add_shortcode('product', 'twentytwentychild_product_shortcode');

function twentytwentychild_custom_columns_posts_head($defaults) {
    $new_array['shortcode'] = '<div style="text-align: center;">Shortcode<div>';
    array_splice( $defaults, 3, 0, $new_array );
    return $defaults;
}

function twentytwentychild_custom_columns_content($column_name, $post_ID) {
    switch ( $column_name ) {
        case 'shortcode':
            echo '<div style="text-align: center;"><code>[product id="'.$post_ID.'" color="#000"]</code><div>';
            break;
    }
}
add_filter('manage_products_posts_columns', 'twentytwentychild_custom_columns_posts_head');
add_action('manage_products_posts_custom_column', 'twentytwentychild_custom_columns_content', 10,2);

function shortcodeFilter(string $input): string	{
        return '<div style="background: transparent;">'.$input.'</div>';	
    }
add_filter('custom_shortcode_product', 'shortcodeFilter');