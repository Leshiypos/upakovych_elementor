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

// Shortcode for mobile menu

add_shortcode('mobile_menu_custom', 'mobile_menu_function');

function mobile_menu_function(){
	?>
	<div class="header_mobile">
		<div class="wrap">
			<div class="logo_mobile">
				<a href="/"><img src="/wp-content/uploads/2024/02/МИ-e1739461999196.png" alt="Логотип сайта" />Упаковыч</a>  
			</div>
			<div class="burger_menu" id="burger_button">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-burger-white.svg" style="fill:#fff" alt="burger">
			</div>
		</div>

		<div class="mobile_menu_list not_active">

	<?php wp_nav_menu([
		'menu' => 103,
		'container_class' => "mobile_menu_link"
	]); ?>
	<!-- Контакты -->
	 	<ul class="contacts">
			<li>
				<a href="tel:88001019652" alt="8 (800) 101-96-52" title="8 (800) 101-96-52">
					<p>8 (800) 101-96-52</p>
				</a>
			</li>
			<li>
				<a href="tel:89921854801" alt="8 (992) 185-48-01" title="8 (992) 185-48-01">
						<p>8 (992) 185-48-01</p>
				</a>
			</li>
			<li>
				<a href="https://yandex.ru/maps/2/saint-petersburg/house/polevaya_sabirovskaya_ulitsa_45k1/Z0kYdABlSUwDQFtjfXV4dXRlbA==/?ll=30.275141%2C59.994417&amp;z=18.4">
					<svg aria-hidden="true" class="point" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path></svg>			</span>
					<span>Полевая Сабировская,45к1</span>
				</a>
			</li>
			
		</ul>
	<!-- Конец Контакты -->

	<!-- Иконки -->
		<ul class="mobile_icons">
		<li><a class="" href="http://t.me/upakovych" target="_blank"><span class="elementor-screen-only">Telegram</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" width="512" height="512"><g id="Artboard"><path style="fill-rule:evenodd;clip-rule:evenodd;" d="M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12S18.627,0,12,0z    M17.562,8.161c-0.18,1.897-0.962,6.502-1.359,8.627c-0.168,0.9-0.5,1.201-0.82,1.23c-0.697,0.064-1.226-0.461-1.901-0.903   c-1.056-0.692-1.653-1.123-2.678-1.799c-1.185-0.781-0.417-1.21,0.258-1.911c0.177-0.184,3.247-2.977,3.307-3.23   c0.007-0.032,0.015-0.15-0.056-0.212s-0.174-0.041-0.248-0.024c-0.106,0.024-1.793,1.139-5.062,3.345   c-0.479,0.329-0.913,0.489-1.302,0.481c-0.428-0.009-1.252-0.242-1.865-0.442c-0.751-0.244-1.349-0.374-1.297-0.788   c0.027-0.216,0.324-0.437,0.892-0.663c3.498-1.524,5.831-2.529,6.998-3.015c3.333-1.386,4.025-1.627,4.477-1.635   C17.472,7.214,17.608,7.681,17.562,8.161z"/></g></svg></a></li>
		<li><a class="" href="https://wa.me/79921854801" target="_blank"><span class="elementor-screen-only">Whatsapp</span><svg class="e-font-icon-svg e-fab-whatsapp" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>					</a></li>
		<li><a class="" href="mailto:7795@upakovych.ru" target="_blank"><span class="elementor-screen-only">Icon-email</span><svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"><path d="M19.5,2H4.5C2.019,2,0,4.019,0,6.5v11c0,2.481,2.019,4.5,4.5,4.5h15c2.481,0,4.5-2.019,4.5-4.5V6.5c0-2.481-2.019-4.5-4.5-4.5ZM4.5,3h15c1.084,0,2.043,.506,2.686,1.283l-7.691,7.692c-.662,.661-1.557,1.025-2.497,1.025-.914-.017-1.826-.36-2.492-1.025L1.814,4.283c.643-.777,1.601-1.283,2.686-1.283Zm18.5,14.5c0,1.93-1.57,3.5-3.5,3.5H4.5c-1.93,0-3.5-1.57-3.5-3.5V6.5c0-.477,.097-.931,.271-1.346l7.528,7.528c.851,.851,1.98,1.318,3.177,1.318s2.375-.467,3.226-1.318l7.528-7.528c.174,.415,.271,.869,.271,1.346v11Z"/></svg></a></li>
		<li><a class="" href="#request_call"><span class="elementor-screen-only">Icon-phone-call</span><svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,1a1,1,0,0,1,1-1A10.011,10.011,0,0,1,24,10a1,1,0,0,1-2,0,8.009,8.009,0,0,0-8-8A1,1,0,0,1,13,1Zm1,5a4,4,0,0,1,4,4,1,1,0,0,0,2,0,6.006,6.006,0,0,0-6-6,1,1,0,0,0,0,2Zm9.093,10.739a3.1,3.1,0,0,1,0,4.378l-.91,1.049c-8.19,7.841-28.12-12.084-20.4-20.3l1.15-1A3.081,3.081,0,0,1,7.26.906c.031.031,1.884,2.438,1.884,2.438a3.1,3.1,0,0,1-.007,4.282L7.979,9.082a12.781,12.781,0,0,0,6.931,6.945l1.465-1.165a3.1,3.1,0,0,1,4.281-.006S23.062,16.708,23.093,16.739Zm-1.376,1.454s-2.393-1.841-2.424-1.872a1.1,1.1,0,0,0-1.549,0c-.027.028-2.044,1.635-2.044,1.635a1,1,0,0,1-.979.152A15.009,15.009,0,0,1,5.9,9.3a1,1,0,0,1,.145-1S7.652,6.282,7.679,6.256a1.1,1.1,0,0,0,0-1.549c-.031-.03-1.872-2.425-1.872-2.425a1.1,1.1,0,0,0-1.51.039l-1.15,1C-2.495,10.105,14.776,26.418,20.721,20.8l.911-1.05A1.121,1.121,0,0,0,21.717,18.193Z"/></svg></a></li>
		<li><a class="" href="https://upakovych.ru/cart/" target="_blank"><span class="elementor-screen-only">Shopping-basket</span><svg class="e-font-icon-svg e-fas-shopping-basket" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M576 216v16c0 13.255-10.745 24-24 24h-8l-26.113 182.788C514.509 462.435 494.257 480 470.37 480H105.63c-23.887 0-44.139-17.565-47.518-41.212L32 256h-8c-13.255 0-24-10.745-24-24v-16c0-13.255 10.745-24 24-24h67.341l106.78-146.821c10.395-14.292 30.407-17.453 44.701-7.058 14.293 10.395 17.453 30.408 7.058 44.701L170.477 192h235.046L326.12 82.821c-10.395-14.292-7.234-34.306 7.059-44.701 14.291-10.395 34.306-7.235 44.701 7.058L484.659 192H552c13.255 0 24 10.745 24 24zM312 392V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm112 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm-224 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24z"></path></svg>					</a></li>
		</ul>
	<!-- Конец Иконки -->
	</div>

	</div>
	<?php
}

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


// Проверка хука
function check_hook(){
	add_action('woocommerce_checkout_order_review', function() {
		global $wp_filter;
	
		$hook = 'woocommerce_checkout_order_review';
	
		if ( isset( $wp_filter[ $hook ] ) ) {
			echo '<pre>';
			foreach ( $wp_filter[ $hook ]->callbacks as $priority => $callbacks ) {
				echo "Priority: $priority\n";
				foreach ( $callbacks as $callback ) {
					if ( is_array( $callback['function'] ) ) {
						echo 'Function: ' . get_class( $callback['function'][0] ) . '::' . $callback['function'][1] . "\n";
					} elseif ( is_string( $callback['function'] ) ) {
						echo 'Function: ' . $callback['function'] . "\n";
					}
				}
			}
			echo '</pre>';
		}
	});
}


    remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
