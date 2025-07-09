<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.0.2' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-3' => esc_html__( 'Меню каталога', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
//Вставляем код яндекс метрики
add_action( 'wp_footer', 'yandex_metrika_action' );
function yandex_metrika_action(){
	echo <<<END
	<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date(); for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }} k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(100712159, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/100712159" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
	END;
}






add_action( 'wp_enqueue_scripts', 'custom_script' );

function custom_script(){
	wp_enqueue_script( 'custom-script', get_template_directory_uri(  ).'/assets/custom/custom.js', array('jquery'), null, true );
	wp_enqueue_script( 'reach-goal-script', get_template_directory_uri(  ).'/assets/custom/yandexReachGoal.js', array(), null, true );
	wp_enqueue_style('custom-theme-style',get_template_directory_uri() . '/assets/custom/custom.css',[],'1.0.0');
}

add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description2" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}

// Установка чата Jiro.ru
add_action( 'wp_head', 'jivo_chat_script' );

function jivo_chat_script() {
	echo '<script src="//code.jivo.ru/widget/dAcBxdDrkC" async></script>';
}							
//add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Admin notice
if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

// Заменяет первую ссылку пагинации на сслыку без параметров Задание 3
add_filter('paginate_links', 'remove_page_1_from_pagination', 10, 2);
function remove_page_1_from_pagination($link) {
	if (strpos($link, '/page/1/') !== false) {
        // Получаем базовый URL без пагинации
        $base_url = preg_replace('#/page/1/?([/?"])#', '$1', $link);
        return $base_url;
    }
    return $link;
}

// Исправление атрибута rel="canonical" на страницах категории товаров
add_filter( 'wpseo_canonical', 'fix_yoast_canonical_on_pagination' );
function fix_yoast_canonical_on_pagination( $canonical ) {
    if ( is_paged() && is_product_category() ) {
        $term = get_queried_object();
        if ( $term && isset( $term->term_id ) ) {
            $url = get_term_link( $term );
            if ( ! is_wp_error( $url ) ) {
                return $url;
            }
        }
    }

    // Для главной страницы магазина (если нужна)
    if ( is_paged() && is_shop() ) {
        return get_permalink( wc_get_page_id( 'shop' ) );
    }

    return $canonical;
}





add_filter('wpseo_metadesc', 'custom_limit_yoast_metadesc_clean', 10, 1);

function custom_limit_yoast_metadesc_clean($metadesc) {
    $max_length = 400;

    if (mb_strlen($metadesc) > $max_length) {
        $trimmed = mb_substr($metadesc, 0, $max_length);
        
        // Обрезаем по последнему пробелу, чтобы не резать слово
        $last_space = mb_strrpos($trimmed, ' ');
        if ($last_space !== false) {
            $trimmed = mb_substr($trimmed, 0, $last_space);
        }

        $metadesc = rtrim($trimmed, " .,;:-");
    }

    return $metadesc; 
}

// wp-dev - правки woocomerce

//Переопределяем положение описание в категориях после цикла с товарами  /wp-content/themes/hello-elementor/woocommerce/archive-product.php
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 5 ); // приоритет 5 — до пагинации


// Регистрация POST TYpe
// Регистрация POST TYPE Скидки
add_action('init','upavovych_cpt' );

function upavovych_cpt(){
	register_post_type( 'discounts', array(
        'labels'             => array(
			'name'               => 'Скидки', // основное название для типа записи
			'singular_name'      => 'Скидка', // название для одной записи этого типа
			'add_new'            => 'Добавить скидку', // для добавления новой записи
			'add_new_item'       => 'Добавление скидки', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование скидки', // для редактирования типа записи
			'new_item'           => 'Новая скидка', // текст новой записи
			'view_item'          => 'Смотреть скидку', // для просмотра записи этого типа.
			'search_items'       => 'Искать скидку', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Скидки', // название меню
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'discounts' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'menu_icon'          => 'dashicons-yes',
        'supports'           => array( 'title','thumbnail'),
		'taxonomies'		 => array('product_cat')
    ) );
	
}

// Shortcodes

// Шорткод для категории товаров
function ea_related_products_swiper() {
    if ( ! is_product() ) return;

    global $post;

    $terms = get_the_terms( $post->ID, 'product_cat' );
    if ( empty($terms) || is_wp_error($terms) ) return '';

    $term_ids = wp_list_pluck( $terms, 'term_id' );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post__not_in'   => array( $post->ID ),
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    );

    $loop = new WP_Query( $args );
    if ( ! $loop->have_posts() ) return '';

    ob_start(); ?>

    <div class="swiper-container related-products-swiper">
        <div class="swiper-wrapper">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="swiper-slide">
                    <div class="product-card">
                        <div class="product-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('medium');
                                } ?>
                            </a>
                        </div>
                        <div class="product-info">
                            <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                            <?php woocommerce_template_loop_price(); ?>
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination and navigation -->
        <div class="swiper-pagination"></div>
    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'ea_related_by_cat', 'ea_related_products_swiper' ); //Рабочий шорткод [ea_related_by_cat]

// Shortcode for discount percentage

add_shortcode('discounts_percentage', 'discount_percentage_func'); //Рабочий шорткод [discounts_percentage]

function discount_percentage_func(){
	$arg = array (
		'post_type' => 'discounts',
		'posts_per_page' => -1,
		'meta_key' => 'position',        // Название поля ACF
		'orderby'   => 'meta_value_num', // Если значение числовое
		'order'     => 'ASC',            // Или DESC, если нужно от большего к меньшему
	);
	$discounts = new WP_Query($arg);
	if ( ! $discounts->have_posts() ) return 'Скидок нет';

		ob_start();?>
		<div class="discount-grid">
		<?php 
			while( $discounts->have_posts() ){
				$discounts->the_post();
				
				$title = get_field('title');
				$discount_per = get_field('discount_per');
				$description = get_field('description');
				$is_vip = get_field('is_vip');
				?>
					<div class="discount-box">
						<div class="circle <?php echo $discount_per ? 'red' : 'blue'; ?>"><?php echo $discount_per ? esc_html($discount_per) : ''; ?>%</div>
						<strong><?php echo $title ? esc_html($title) : ''; ?></strong>
						<?php echo $is_vip ? '<div class="vip">+ <span>VIP статус</span></div>' : ''; ?>
						<p><?php echo $description ? esc_html($description) : ''; ?></p>
					</div>
				<?php
			}
			wp_reset_postdata(); // сбрасываем переменную $post
			?>
			</div>
			<?php
		return ob_get_clean();
};

// Добавляем облако тэгов

add_action('woocommerce_before_shop_loop', 'upakovych_show_product_tags_cloud', 4);

function upakovych_show_product_tags_cloud() {
    if (is_product_category()) {
        global $wp_query;

        // Получим все ID товаров в текущем архиве
        $product_ids = wp_list_pluck($wp_query->posts, 'ID');

        // Соберем все теги этих товаров
        $tags = wp_get_object_terms($product_ids, 'product_tag', ['orderby' => 'count', 'order' => 'DESC']);

        if (!empty($tags) && !is_wp_error($tags)) {
            echo '<div class="product-tags-cloud">';
            echo '<strong>Теги в этой категории:</strong><br>';
			echo '<div class="wrap_tags">';
            foreach ($tags as $tag) {
                $link = get_term_link($tag);
                if (!is_wp_error($link)) {
                    echo '<a href="' . esc_url($link) . '" class="tag-link" style="margin-right: 8px;">' . esc_html($tag->name) . ' ('.intval($tag->count).')</a>';
                }
            }
			echo '</div>';
            echo '</div><hr>';
        }
    }
}




// Добавление филтров на страницы

function script_remove_null_filter(){
	?>
	<script>
		let filterItem = document.querySelectorAll('.wpc-filters-section');
		filterItem.forEach((element)=>{
			
			element.querySelectorAll('input[value="0"]').length == 2 ? 
			element.remove() : null
		}
	)


	</script>	
	<?php

}



//  Четерехклапанные коробки
add_action('woocommerce_before_shop_loop', function() {
	$filtred_category = array(
		'chetirehklyapannie-korobki',
		'samosbornie-korobki',
		'samosbornie-korobki-s-okoshkom',
		'termoetiketki-plg-v-t-ch-transfernye-termotransfernye',
		'termoetiketki-top',
		'termoetiketki-eko-samokleyashchiesya-etikety-v-rulonakh-eko'
	);
	$not_filtred_category = array(
		'gofrotary',
		'korobki',
		'termоetiketki-samokleiyushchiesya-etiketki',
		'pakety-iz-vozdushno-puzirchatoy-plyonki',
		'pakety-iz-vozdushno-puzirchatoy-plyonki',
		'tsvetnaya-vozdushno-puzirchataya-plyonka-2-sloya',
		'tsvetnaya-streych-plenka',
		'streych-plenka',
		'kleykiye-lenty-skotch',
		'grippery-zip-lock-pakety-s-zamkom',
		'pakety-slaydery-s-begunkom'
	);
    if (!is_product_category($not_filtred_category)) {
        echo do_shortcode('[fe_widget]');
		add_action('wp_footer', 'script_remove_null_filter');
    }
}, 5);

// Добавляем боковое меню в категори товаров

add_action('woocommerce_shop_loop_header', 'left_menu_sidebar', 9);

function left_menu_sidebar(){
	if (is_product_category()) {
	echo '
	<div class="left_menu_sidebar">';
	
	wp_nav_menu( [
	'theme_location'  => 'menu-3',
	'menu'            => '',
	'container'       => 'div',
	'container_class' => '',
	'container_id'    => 'sidebar',
	'menu_class'      => 'menu',
	'menu_id'         => '',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'depth'           => 0,
	'walker'          => '',
] );

	echo '
	</div>
	<div class="cont">';
	}
}





// // Термоэтикетки
// add_action('woocommerce_before_shop_loop', function() {
// 	$filtred_category = array(
// 		'termoetiketki-plg-v-t-ch-transfernye-termotransfernye',
// 		'termoetiketki-top',
// 		'termoetiketki-eko-samokleyashchiesya-etikety-v-rulonakh-eko',
// 	);
//     if (is_product_category($filtred_category)) {
//         echo do_shortcode('[fe_widget id="7034"]');
//     }
// }, 5);






// add_action('woocommerce_before_shop_loop', function() {
// 	$term = get_queried_object();
// 	if (!$term || empty($term->slug)) return;

// 	$slug = $term->slug;

// 	$filters = [
// 		// Категории для коробок
// 		'chetirehklyapannie-korobki' => 6878,
// 		'samosbornie-korobki' => 6878,
// 		'samosbornie-korobki-s-okoshkom' => 6878,

// 		// Категории для термоэтикеток
// 		'termoetiketki-plg-v-t-ch-transfernye-termotransfernye' => 7034,
// 		'termoetiketki-top' => 7034,
// 		'termoetiketki-eko-samokleyashchiesya-etikety-v-rulonakh-eko' => 7034,
// 	];

// 	if (isset($filters[$slug])) {
// 		echo do_shortcode('[fe_widget id="' . $filters[$slug] . '"]');
// 	}
// }, 5);

// Форма доставки
// отключаем доставку по другому адресу
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );

add_filter( 'woocommerce_checkout_fields' , 'remove_unwanted_checkout_fields' );

function remove_unwanted_checkout_fields( $fields ) {
    // Удаление из секции оплаты (billing)
    unset($fields['billing']['billing_country']);      // Страна/регион
    unset($fields['billing']['billing_state']);        // Область / район
    unset($fields['billing']['billing_address_1']);    // Адрес
    unset($fields['billing']['billing_address_2']);    // Крыло, подъезд, этаж и т.д.
    unset($fields['billing']['billing_postcode']);     // Почтовый индекс
    unset($fields['billing']['billing_city']);         // Населённый пункт

    return $fields;
}

