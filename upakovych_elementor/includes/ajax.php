<?php
add_action( 'wp_enqueue_scripts', 'upakovich_ajax_script' );

function upakovich_ajax_script(){
	wp_enqueue_script( 'upakovich-ajax-script', get_template_directory_uri(  ).'/assets/custom/ajax.js', array(), null, true );

	wp_localize_script('upakovich-ajax-script', 'my_ajax_object', array(
		'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

add_action('wp_ajax_load_more_articles', 'load_more_articles');
add_action('wp_ajax_nopriv_load_more_articles', 'load_more_articles');

function load_more_articles() {
    $paged = intval($_POST['paged']) + 1;

    $q = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 9,
        'paged' => $paged,
        'category_name' => 'articles'
    ]);

    ob_start();
    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            get_template_part('template-parts/article-card'); 
        }
    }
    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
        'paged' => $paged,
    ]);
}