<?php
get_header();
?>
<main id="site-content" role="main">
    <header class="entry-header has-text-align-center header-footer-group">
        <div class="entry-header-inner section-inner medium">
            <h1 class="main-title">Products</h1>
        </div>
    </header>

    <div class="section-inner">
        <div class="grid">
            <?php
$args = array('post_type' => 'products',
    'order' => 'ASC');
$wp_query = new WP_Query($args);

while ($wp_query->have_posts()) {
    $wp_query->the_post();
    echo '<a href="' . esc_url(get_permalink()) . '" class="grid-column">';
    get_template_part('template-parts/featured-image');
    the_title('<p class="entry-title grid-title">', '</p>');
    if (get_post_meta(get_the_ID(), 'twentytwentychild_products_is_on_sale', true)) {
        echo '<div class="sale"><span>SALE</span></div>';
    }
    echo '</a>';
}

?>
        </div>
    </div>

</main>
<?php get_footer();?>