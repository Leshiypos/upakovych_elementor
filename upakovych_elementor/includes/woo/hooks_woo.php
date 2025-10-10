<?php 
// Тут будут хуки темы визуального редактирования шаблонов

// archive product
// remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10); //Убираем заоловок категории
add_action('woocommerce_before_shop_loop', function(){
	echo do_shortcode( '[hero_section]' );
	echo do_shortcode( '[main_advantages_section]' );
	echo do_shortcode( '[product_range_section]' );
}, 3);

add_action( 'woocommerce_after_shop_loop', function(){
echo do_shortcode( '[examples_use_section]' );
echo do_shortcode( '[JTBD_buyers_section]' );
echo do_shortcode( '[main_advantages_JTBD_patners_section]' );
echo do_shortcode( '[general_customer_reviews_section]' );
echo do_shortcode( '[stages_cooperation_section]' );
echo do_shortcode( '[answers_asked_questions_section]' );
echo do_shortcode( '[cta_feedback_section]' );
}, 11 );

