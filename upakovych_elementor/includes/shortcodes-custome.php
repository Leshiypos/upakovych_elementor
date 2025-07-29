<?php
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
	<h2>Рекомендуемые товары</h2>
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

// Сопутствуюие товары

function sc_crassels_products_carusel_func(){
	
global $product;
if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
    return '<!-- product not found -->';
}

$cross_sell_ids = array_unique( $product->get_cross_sell_ids() );

if ( $cross_sell_ids ) {
    ?>
    <h2>Сопутствующие товары</h2>

    <div class="swiper cross-sells-slider">
        <div class="swiper-wrapper">
            <?php
            foreach ( $cross_sell_ids as $cross_id ) {
                $post_object = get_post( $cross_id );
                setup_postdata( $GLOBALS['post'] =& $post_object );
                ?>
                <div class="swiper-slide">
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                </div>
                <?php
            }
            ?>
        </div>

    </div>

    <?php
    wp_reset_postdata();
}
}
add_shortcode('crassels_products_carusel', 'sc_crassels_products_carusel_func');




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
	$count = WC()->cart->get_cart_contents_count();
	?>
	<div class="header_mobile">
		<div class="wrap">
			<div class="logo_mobile">
				<a href="/"><img src="/wp-content/uploads/2024/02/МИ-e1739461999196.png" alt="Логотип сайта" />Упаковыч</a>  
			</div>
				<!-- Иконки -->
			 
			<ul class="always_display_mobile_icons">
				<li><?php echo do_shortcode('[favotite_page_link]'); ?>	</li>
				<li><a class="request_call" href="#request_call"><span class="elementor-screen-only">Icon-phone-call</span><svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,1a1,1,0,0,1,1-1A10.011,10.011,0,0,1,24,10a1,1,0,0,1-2,0,8.009,8.009,0,0,0-8-8A1,1,0,0,1,13,1Zm1,5a4,4,0,0,1,4,4,1,1,0,0,0,2,0,6.006,6.006,0,0,0-6-6,1,1,0,0,0,0,2Zm9.093,10.739a3.1,3.1,0,0,1,0,4.378l-.91,1.049c-8.19,7.841-28.12-12.084-20.4-20.3l1.15-1A3.081,3.081,0,0,1,7.26.906c.031.031,1.884,2.438,1.884,2.438a3.1,3.1,0,0,1-.007,4.282L7.979,9.082a12.781,12.781,0,0,0,6.931,6.945l1.465-1.165a3.1,3.1,0,0,1,4.281-.006S23.062,16.708,23.093,16.739Zm-1.376,1.454s-2.393-1.841-2.424-1.872a1.1,1.1,0,0,0-1.549,0c-.027.028-2.044,1.635-2.044,1.635a1,1,0,0,1-.979.152A15.009,15.009,0,0,1,5.9,9.3a1,1,0,0,1,.145-1S7.652,6.282,7.679,6.256a1.1,1.1,0,0,0,0-1.549c-.031-.03-1.872-2.425-1.872-2.425a1.1,1.1,0,0,0-1.51.039l-1.15,1C-2.495,10.105,14.776,26.418,20.721,20.8l.911-1.05A1.121,1.121,0,0,0,21.717,18.193Z"/></svg></a></li>
				<li>	
					<a class="cart-quantity header-icon-cart" href="/cart/">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/shopping-cart.svg" alt="">
						<span class="count<?php echo ($count === 0)?" no-items": ""; ?>"><?php echo !($count === 0)?$count: ""; ?></span>
					</a>
				</li>
			</ul>
	<!-- Конец Иконки -->
			<div class="burger_menu" id="burger_button">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-burger-white.svg" style="fill:#fff" alt="burger">
			</div>
		</div>

		<div class="mobile_menu_list not_active">
			<div class="wrap_list">

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
		<li><a class="request_call" href="#request_call"><span class="elementor-screen-only">Icon-phone-call</span><svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,1a1,1,0,0,1,1-1A10.011,10.011,0,0,1,24,10a1,1,0,0,1-2,0,8.009,8.009,0,0,0-8-8A1,1,0,0,1,13,1Zm1,5a4,4,0,0,1,4,4,1,1,0,0,0,2,0,6.006,6.006,0,0,0-6-6,1,1,0,0,0,0,2Zm9.093,10.739a3.1,3.1,0,0,1,0,4.378l-.91,1.049c-8.19,7.841-28.12-12.084-20.4-20.3l1.15-1A3.081,3.081,0,0,1,7.26.906c.031.031,1.884,2.438,1.884,2.438a3.1,3.1,0,0,1-.007,4.282L7.979,9.082a12.781,12.781,0,0,0,6.931,6.945l1.465-1.165a3.1,3.1,0,0,1,4.281-.006S23.062,16.708,23.093,16.739Zm-1.376,1.454s-2.393-1.841-2.424-1.872a1.1,1.1,0,0,0-1.549,0c-.027.028-2.044,1.635-2.044,1.635a1,1,0,0,1-.979.152A15.009,15.009,0,0,1,5.9,9.3a1,1,0,0,1,.145-1S7.652,6.282,7.679,6.256a1.1,1.1,0,0,0,0-1.549c-.031-.03-1.872-2.425-1.872-2.425a1.1,1.1,0,0,0-1.51.039l-1.15,1C-2.495,10.105,14.776,26.418,20.721,20.8l.911-1.05A1.121,1.121,0,0,0,21.717,18.193Z"/></svg></a></li>
		<li>	
			<a class="cart-quantity header-icon-cart" href="/cart/">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/shopping-cart.svg" alt="">
				<span class="count<?php echo ($count === 0)?" no-items": ""; ?>"><?php echo !($count === 0)?$count: ""; ?></span>
			</a>
		</li>
		</ul>
	<!-- Конец Иконки -->
		</div>
	</div>

	</div>
	<?php
}

// меню каталога
add_shortcode('mobile_menu_catalog', 'mobile_menu_catalog_func');
function mobile_menu_catalog_func(){
	?>
	<div class="mobile_cotalog_menu">
		<div class="burger_menu" id="burger_catalog_button">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-burger-white.svg" alt="burger">
		</div>
			<div class="wrap_menu_catalog">
				<ul id="list_menu_catalog">
					<li><img src="<?php echo get_template_directory_uri(); ?>/assets/images/cross-white.svg" id="burger_catalog_button_cross" alt="burger"></li>
				<?php 
					wp_nav_menu( [
					'theme_location'  => 'menu-3',
					'menu'            => '',
					'container'       => '',
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
					'items_wrap'      => '<li id="%1$s" class="%2$s">%3$s</li>',
					'depth'           => 0,
					'walker'          => '',
				] );
				?>
				</ul>
		</div>
	</div>
	<?php
}
// Корзина
add_shortcode('custom_shoppping_basket', 'custom_shoppping_basket_func');

function custom_shoppping_basket_func(){
	$count = WC()->cart->get_cart_contents_count();
	?>
	<a class="cart-quantity header-icon-cart" href="/cart/">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/images/shopping-cart.svg" alt="">
    	<span class="count<?php echo ($count === 0)?" no-items": ""; ?>"><?php echo !($count === 0)?$count: ""; ?></span>
	</a>
	<?php
}
add_filter( 'woocommerce_add_to_cart_fragments', 'custom_ajax_cart_count_fragment' );
function custom_ajax_cart_count_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-quantity .count'] = ob_get_clean();
    return $fragments;
}

// добавляем кнопку ссылки на страницу избранное
function favotite_page_link_funk(){
	echo '<div class="fovorite_link_page">';
	echo do_shortcode('[ti_wishlist_products_counter]');
	echo '</div>';
}
add_shortcode('favotite_page_link', 'favotite_page_link_funk');


// Форма целевого назначения

add_shortcode('form_of_intended_use', 'form_of_intended_use_func');

function form_of_intended_use_func(){
	?>

<div class="intended_use">
	<h2>Товары от производителя</h2>
	<div class="wrap">
		<div>
			<img src="/wp-content/uploads/2025/07/fon_popUp.png" alt="">
		</div>
		<div class="form">	
			<?php echo do_shortcode( '[contact-form-7 id="6dfff09" title="Форма целевого действия"]' ); ?>
		</div>
	</div>
</div>
	<?php
}

//форма Нашли дешевле? 
add_shortcode('form_found_it_cheaper', 'form_found_it_cheaper_func');

function form_found_it_cheaper_func(){
	?>

<div class="standart_form">
	<h2>Нашли дешевле? Мы вам перезвоним</h2>
	<div class="wrap">
		<div class="form">	
			<?php echo do_shortcode( '[contact-form-7 id="2d72a73" title="Форма Нашли дешевле?"]' ); ?>
		</div>
	</div>
</div>
	<?php
} 

//форма Запрос цены на опт? 
add_shortcode('form_wholesale_price', 'form_wholesale_price_func');

function form_wholesale_price_func(){
	?>

<div class="standart_form">
	<h2>Запрос цены на опт</h2>
	<div class="wrap">
		<div class="form">	
			<?php echo do_shortcode( '[contact-form-7 id="dff5267" title="Форма Запрос цены на опт"]' ); ?>
		</div>
	</div>
</div>
	<?php
} 


// Описание продукта с выводом данных кастомных полей на странице товара

add_shortcode('description_short_code', 'description_short_code_func');

function description_short_code_func(){
	$urls_slugs = [
		"Ширина, м" => "width.svg",
		"Ширина, см" => "width.svg",
		"Ширина, мм" => "width.svg",
		"Ширина" => "width.svg",
		"Длина, м" => "dimensions.svg",
		"Длина" => "dimensions.svg",
		"Высота" => "dimensions.svg",
		"Высота, см" => "dimensions.svg",
		"Высота, мм" => "dimensions.svg",
		"Толщина, мкм" => "line-width.svg",
		"Объём" => "volume.svg",
		"Вес, кг" => "weight.svg",
		"Плотность, гр" => "size.svg",
		"Цвет" => "palette.svg",
		"Штук в рулоне" => "sushi.svg",
		"По умолчанию" => "volume.svg",

	];
	global $post;
	$fields = get_field_objects($post->ID);
?>


<?php
		if ($fields) {
			?>
			<div class="characteristics">
				<h6>Характеристики</h6>
				<div class="wrap_charact">
			<?php
			foreach ($fields as $field) {
				$label = $field['label'];
				if(!empty($field['value'])){
				?>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dimensions_icon/<?php echo $urls_slugs[$label] ? $urls_slugs[$label] : $urls_slugs['По умолчанию'];?>" title=""/>
					<span><?php echo esc_html($field['label']); ?>: </span> <?php  echo esc_html($field['value']); ?>
				</div> 
				<?php
				}
			}
			?>
				</div>
			</div>
			<?php
		}
		?>
	<?php
}

// Страница доставки и оплаты

add_shortcode('delivery_and_payment_page','delivery_and_payment_page_func');

function delivery_and_payment_page_func(){
	?>
<div class="delivery_page">
	<section class="variant_del">
		<div class="flex">
			<h3>Варианты и условия доставки</h3>
			<p>Мы заботимся о вашем удобстве и предлагаем несколько способов доставки продукции, чтобы вы могли выбрать оптимальный вариант для вашего региона и типа заказа.</p>
			<h3>Доставка по Москве:</h3>
			<ul>
				<li>Самовывоз со склада или одного из РЦ - <b>бесплатно</b></li>
				<li>Доставка по СПб и ЛО при заказе от 20тыс руб (до 1го паллета/800кг) - <b>бесплатно</b></li>
				<li>Доставка до ТК для клиентов из другого города (негабаритный товар) - <b>бесплатно</b></li>
				<li>Доставка по СПб - <b>от 299 ₽</b></li>
				<li>Доставка в регионы - <b>индивидуально</b></li>
			</ul>
			<p class="footnote">* Доставку в другие города и регионы России можно обсудить с менеджером — свяжитесь с нами любым удобным способом</p>
		</div>
		<div>
			<img src="http://upakovych.ru/wp-content/uploads/2025/07/car_delivery.png" alt="Доставка автомобилем" title="Доставка автомобилем">
		</div>
	</section>

	<section class="map_zones">
		<h2>Зоны доставки</h2>
		<div class="flex">
			<div><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aa47a3bd9abe782b16a17c22549031ff9f3d072cdad67bcd46b0925665c959d10&amp;width=465&amp;height=467&amp;lang=ru_RU&amp;scroll=true"></script></div>
			<div>
				<div>
					<h3>Доставка по СПБ и ЛО:</h3>
					<ul class="delivery_zone">
						<li class="green">1-я зона  (до 900  ₽)</li>
						<li class="yellow">2-я зона (до 1800  ₽)</li>
						<li class="red">3- я зона (от 2400  ₽)</li>
					</ul>
				</div>
				<div>
					<p class="footnote">* Объём - до 1 паллета</p>
					<p class="footnote">* Вес - до 800 кг</p>
					<p class="footnote">* Подробнее об условиях доставки можно уточнить у менеджера </p>
				</div>
			</div>
		</div>
	</section>

	<section class="delivery_times">
		<h2>Сроки доставки</h2>
		<div class="flex">

			<div class="outer_block">
				<div class="inner_block">
					<h4>По Москве</h4>
					<p class="headline">Срок: от 1 рабочего дня</p>
					<ul>
						<li>Заказы, оформленные до 13:00, могут быть доставлены уже на следующий рабочий день.</li>
						<li>Если товар есть на складе, доставка возможна в день заказа — по согласованию.</li>
						<li>В выходные и праздничные дни доставка осуществляется по индивидуальному графику</li>
						<li>При оформлении крупногабаритного заказа срок доставки может увеличиться на 1–2 дня.</li>
						<li>Доставка осуществляется по зонам — Зона 1, 2 и 3 (см. карту).</li>
					</ul>
				</div>
			</div>

			<div class="outer_block">
				<div class="inner_block">
					<h4>По России (ТК)</h4>
					<p class="headline">Срок: от 2 до 7 рабочих дней</p>
					<ul>
						<li>Мы отправляем грузы в любой регион России удобной для вас транспортной компанией: СДЭК, Деловые линии, ПЭК, Энергия, Байкал Сервис и др.</li>
						<li>Отправка производится в течение 1 рабочего дня после подтверждения заказа.</li>
						<li>Сроки зависят от региона получателя и графика работы ТК</li>
					</ul>
				</div>
			</div>
			
			<div class="outer_block">
				<div class="inner_block">
					<h4>Экспресс-доставка</h4>
					<p class="headline">Срок: от 2–4 часов до 1 дня (в пределах СПб)</p>
					<ul>
						<li>Осуществляется в день заказа, если он подтверждён до 12:00.</li>
						<li>Доступна при наличии товара на складе и при условии согласования с менеджером.</li>
						<li>Возможна доставка курьером или по договорённости — через сервисы срочной доставки.</li>
					</ul>
				</div>
			</div>

		</div>
	</section>

	<section class="payment_methods">
		<h2>Способы оплаты</h2>
		<div class="site-payment-methods">
			<div class="site-payment-method">
			<b>Для физических лиц</b>
			<div class="site-payment-desc">
				<div>
					<img src="/wp-content/uploads/2025/07/wallet.svg">
					<div>Наличный расчет</div>
				</div>
				<div>
					<img src="/wp-content/uploads/2025/07/credit-card.svg">
					<div>Банковская карта</div>
				</div>
				<div>
					<img src="/wp-content/uploads/2025/07/qr.svg">
					<div> QR-код</div>
				</div>
				<div>
					<img src="/wp-content/uploads/2025/07/SBP.svg">
					<div>СБП</div>
				</div>
				<div>
					<img src="/wp-content/uploads/2025/07/money-bill-transfer.svg">
					<div>Банковский перевод</div>
				</div>
			</div>
			</div>
			<div class="site-payment-method">
			<b>Для юридических лиц</b>
			<div class="site-payment-desc">
						<div>
					<img src="/wp-content/uploads/2025/07/task-checklist.svg">
					<div>Оплата по счету</div>
				</div>
						<div>
					<img src="/wp-content/uploads/2025/07/credit-card.svg">
					<div>Банковская карта</div>
				</div>
						<div>
					<img src="/wp-content/uploads/2025/07/qr.svg">
					<div>QR-код</div>
				</div>
			</div>
			</div>
		</div>
	</section>

	<section>
		<h2>Оставьте заявку и менеджер с Вами свяжется</h2>
		<div>
			<div>
				<img src="/wp-content/uploads/2025/07/man_with_ipad.png" alt="Изображжение консультанта" title="Изображжение консультанта">
			</div>
			<div>
				<?php echo do_shortcode('[metform form_id="314"]'); ?>
			</div>
		</div>
	</section>

</div>


	<?php
}