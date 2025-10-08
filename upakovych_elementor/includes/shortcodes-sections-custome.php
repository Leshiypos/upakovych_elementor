<?php
function check_empty($field, $default = "Зачение не указано"){
	return $field ? $field : $default;
};


// Секция HeroSecton [hero_section]
add_shortcode( "hero_section", "hero_section_func" );
function hero_section_func(){
	$hero_section = get_field('hero_section');
	?>
	     <section class="hero_section">
        <div class="wrap_section">
          <h1>
			<?php echo check_empty($hero_section['title'], "Упаковка <br />на заказ от производителя: <br />Решения для вашего бизнеса"); ?>
          </h1>
          <div class="wrap_content">
            <div class="content_block">
              <div class="padding"></div>
              <div class="discription">
                <p>
					<?php echo check_empty($hero_section['description'], " Производим и поставляем упаковку, которая защищает ваш продукт и повышает продажи. От термоэтикеток до гофротары – комплексные решения для оптовых покупателей. Upakovych.ru –
                  ваш надежный партнер для бизнеса: гарантируем качество, сроки и выгодные цены.") ?>
                </p>
              </div>
              <div class="wrap_btn flex_row">
                <a href="#" class="btn cta_primary">Рассчитать стоимость</a>
                <a href="/katalog-tovarov/" class="btn cta_secondary">Перейти в каталог</a>
              </div>
            </div>
            <div class="slider_wrap">
              <div class="swiper hero_section_slider">
                <div class="swiper-wrapper">

				<?php 
					if ($hero_section && !empty($hero_section['imgs_slide'])){
						foreach($hero_section['imgs_slide'] as $url){
				?>
                  <div class="swiper-slide">
                    <img
                      src="<?php echo $url; ?>"
                      alt="boxes"
                    />
                  </div>
				<?php
						}
					}
				?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция - 2 Общая информация о компании -->[about_company_section]
add_shortcode( 'about_company_section', "about_company_section_func" );
function about_company_section_func(){
	$about_company = get_field('about_company_section')
	?>
	<section class="about_company_section">
        <div class="wrap_section">
          <img
            src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/2_bg_cover_section.png"
            alt="bg_cover"
            class="bg_cover"
          />
          <div class="wrap_content">
            <h2>
				<?php echo check_empty($about_company['title'], "Upakovych.ru: <br /> Ваш надежный поставщик упаковки <br /> с опытом"); ?>
            </h2>
            <div class="description">
				<?php echo check_empty($about_company['description'], "Более 10 лет на рынке упаковки. Собственное производство: контроль
              качества на всех этапах. Широкий ассортимент: от расходных
              материалов до специализированных решений. Мы помогаем вашему
              бизнесу расти, обеспечивая бесперебойные поставки качественной
              упаковки, которая защищает ваш продукт и повышает его ценность."); ?>

            </div>
            <div class="advantages_block">
              
				<?php 
				if ($about_company && !empty($about_company['advantages'])){
					foreach ($about_company['advantages'] as $adv){
				?>
				<div class="card">
					<div class="card_content">
						<?php echo $adv['text']; ?>
					</div>
				</div>
				<?php
					}
				}
				?>
            </div>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция Основные преимущества --> [main_advantages_section]
add_shortcode( 'main_advantages_section', "main_advantages_section_func" );
function main_advantages_section_func(){
	$main_advantages = get_field('main_advantages');
	?>
    <section class="main_advantages_section">
        <div class="wrap_section">
          <h2 class="title_right">
			<?php echo check_empty($main_advantages['title'], "Почему выбирают Upakovych.ru: <br />Ваши выгоды и наша экспертиза"); ?>
          </h2>
          <div class="features">
			<?php 
			if ($main_advantages && !empty($main_advantages['cards'])){
				foreach ($main_advantages['cards'] as $card){
			?>
            <div class="feature">
              <div class="hed_wrap_content">
                <img
                  decoding="async"
                  src="<?php echo $card['icon_url'];?>"
                  alt="Упаковка"
                />
                <h3><?php echo $card['title_card']; ?></h3>
              </div>
              <p><?php echo $card['description_card']; ?></p>
            </div>
			<?php
				}
			}
			?>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция Основные сегменты --> КАТАЛОГ [key_product_segments_section]
add_shortcode( 'key_product_segments_section', "key_product_segments_section_func" );
function key_product_segments_section_func(){
	$key_product_segments = get_field('key_product_segments');
	?>
	  <section class="key_product_segments_section">
        <div class="wrap_section">
          <h2 class="pseudo_h1">
			<?php echo check_empty($key_product_segments["title"],"Широкий выбор упаковки <br /> для вашего бизнеса: От А до Я" ); ?>
          </h2>
          <div class="catalog_products">
            <a href="/product-category/termоetiketki-samokleiyushchiesya-etiketki/" class="card_product">
              <h4>Термоэтикетки</h4>
              <hr />
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/cat_img_1.png" alt="Термоэтикетки" />
              </div>
            </a>
            <a href="/product-category/streych-plenka/" class="card_product">
              <h4>Стрейч-пленка</h4>
              <hr />
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/cat_img_2.png" alt="Термоэтикетки" />
              </div>
            </a>
            <a href="/product-category/kuryerskie-pakety-pakety-dlya-marketpleysov/" class="card_product">
              <h4>Курьерские пакеты</h4>
              <hr />
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/cat_img_3.png" alt="Термоэтикетки" />
              </div>
            </a>
            <a href="/product-category/gofrotary/" class="card_product accent">
              <h4>Гофротара</h4>
              <hr />
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/cat_img_4.png" alt="Термоэтикетки" />
              </div>
            </a>
            <a href="/product-category/kantselyaria/" class="card_product">
              <h4>Канцелярия</h4>
              <hr />
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/cat_img_5.png" alt="Термоэтикетки" />
              </div>
            </a>
            <a href="/product-category/odnorazovyie-rasxodnyie-materialyi-odezhda/" class="card_product">
              <h4>Одноразовая одежда</h4>
              <hr />
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/cat_img_6.png" alt="Термоэтикетки" />
              </div>
            </a>
          </div>

          <a href="/katalog-tovarov/" class="btn cta_primary">Посмотреть весь каталог</a>
        </div>
      </section>
	<?php
}

// <!-- Секция Решаемые JTBD (для B2B-закупщиков) --> [JTBD_buyers_section]
add_shortcode( 'JTBD_buyers_section', "JTBD_buyers_section_func" );
function JTBD_buyers_section_func(){
	$JTBD_buyers = get_field('JTBD_buyers');
	?>
	   <section class="JTBD_buyers_section">
        <div class="wrap_section">
          <h2 class="title_right">
			<?php echo check_empty($JTBD_buyers["title"],"Мы решаем ваши задачи: <br /> Как Upakovych.ru упрощает закупки" ); ?>
          </h2>
          <div class="wrap_content">

			<?php 
			if($JTBD_buyers && !empty($JTBD_buyers['cards'])){
				foreach ($JTBD_buyers['cards'] as $key => $card ){
			?>
			<div class="card <?php if ($key%2){echo "right";} else {echo "left";} ?>">
				<?php 
				if (!($key%2)){
				?>
				<div class="wrap_img">
				  <img src="<?php echo $card['img_url']; ?>" alt="" />
				</div>
				<?php
				}
				?>
              <div class="content">
                <div class="question">
                 <?php echo $card["question"]; ?>

                  <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/<?php if ($key%2){echo "qw_left";} else {echo "qw_right";} ?>.svg" alt="" />
                </div>
                <div class="answer text">
					<?php echo $card["answer"]; ?>
                </div>
              </div>
			  	<?php 
				if ($key%2){
					?>
				<div class="wrap_img">
				  <img src="<?php echo $card['img_url']; ?>" alt="" />
				</div>
				<?php
				}
				?>
            </div>
			<?php
				}
			}
			?>



            <!-- <div class="card left">
              <div class="wrap_img">
                <img src="<?php //echo get_template_directory_uri(  ); ?>/assets/images/sections/segment_1.png" alt="" />
              </div>
              <div class="content">
                <div class="question">
                  "Не могу найти надежного поставщика упаковки"
                  <img src="<?php //echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/qw_right.svg" alt="" />
                </div>
                <div class="answer text">
                  Upakovych.ru – это проверенный производитель с многолетним
                  опытом. Мы гарантируем стабильность поставок и высокое
                  качество продукции, подтвержденное сертификатами. Забудьте о
                  недобросовестных партнерах – с нами ваш бизнес защищен.
                </div>
              </div>
            </div>
            <div class="card right">
              <div class="content">
                <div class="question">
                  "Сложно контролировать качество и сроки поставки"
                  <img src="<?php //echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/qw_left.svg" alt="" />
                </div>
                <div class="answer text">
                  Персональный менеджер возьмет на себя все вопросы, от
                  размещения заказа до отслеживания доставки. Вы всегда будете в
                  курсе статуса вашего заказа, а наша система контроля качества
                  на производстве исключает появление брака.
                </div>
              </div>
              <div class="wrap_img">
                <img src="<?php //echo get_template_directory_uri(  ); ?>/assets/images/sections/segment_2.png" alt="" />
              </div>
            </div>

            <div class="card left">
              <div class="wrap_img">
                <img src="<?php //echo get_template_directory_uri(  ); ?>/assets/images/sections/segment_3.png" alt="" />
              </div>
              <div class="content">
                <div class="question">
                  "Хочу оптимизировать расходы на упаковку"
                  <img src="<?php //echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/qw_right.svg" alt="" />
                </div>
                <div class="answer text">
                  Мы предлагаем гибкие цены и индивидуальные оптовые скидки,
                  которые позволят вам значительно сэкономить. Прямые поставки
                  от производителя исключают наценки посредников, а комплексные
                  решения помогут сократить затраты на логистику и хранение.
                </div>
              </div>
            </div>

            <div class="card right">
              <div class="content">
                <div class="question">
                  "Нужна быстрая доставка по СПБ, Москве и регионам"
                  <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/qw_left.svg" alt="" />
                </div>
                <div class="answer text">
                  Наша логистическая служба обеспечивает оперативную доставку по
                  Санкт-Петербургу, Москве и другим регионам России. Мы
                  понимаем, как важна скорость, поэтому гарантируем выполнение
                  сроков и бесперебойные поставки.
                </div>
              </div>
              <div class="wrap_img">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/segment_4.png" alt="" />
              </div>
            </div> -->



          </div>
        </div>
      </section>
	<?php
}


// <!-- Секция Решаемые JTBD (для партнеров) --> [main_advantages_JTBD_patners_section]
add_shortcode( 'main_advantages_JTBD_patners_section', "main_advantages_JTBD_patners_section_func" );
function main_advantages_JTBD_patners_section_func(){
	?>
	   <section class="main_advantages_section JTBD_patners">
        <div class="wrap_section">
          <h2 class="pseudo_h1">
            Сотрудничество с Upakovych.ru: <br />
            Выгодные условия для агентов
          </h2>
          <div class="features">
            <div class="feature">
              <div class="hed_wrap_content">
                <img
                  decoding="async"
                  src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/JTBD_partners_1.svg"
                  alt="Упаковка"
                />
                <h3>Высокие комиссионные вознаграждения</h3>
              </div>
              <p>
                Зарабатывайте больше с каждой сделкой, приводя клиентов в
                Upakovych.ru. Наша прозрачная система расчетов гарантирует
                честные и своевременные выплаты.
              </p>
            </div>
            <div class="feature">
              <div class="hed_wrap_content">
                <img
                  decoding="async"
                  src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/JTBD_partners_2.svg"
                  alt="Решения для отраслей"
                />
                <h3>Поддержка маркетинговыми материалами:</h3>
              </div>
              <p>
                Мы предоставим вам все необходимое для успешного привлечения
                клиентов – от презентаций до образцов продукции.
              </p>
            </div>
            <div class="feature">
              <div class="hed_wrap_content">
                <img
                  decoding="async"
                  src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/JTBD_partners_3.svg"
                  alt="Бесплатный образец"
                />
                <h3>Доступ к широкому ассортименту продукции:</h3>
              </div>
              <p>
                Расширяйте свой портфель услуг, предлагая клиентам весь спектр
                нашей упаковки: термоэтикетки, стрейч-пленку, гофротару и многое
                другое.
              </p>
            </div>
            <div class="feature">
              <div class="hed_wrap_content">
                <img
                  decoding="async"
                  class="svg_icon"
                  src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/JTBD_partners_4.svg"
                  alt="Контроль"
                />
                <h3>Расширение вашего бизнеса:</h3>
              </div>
              <p>
                Станьте нашим агентом и получите надежного партнера, который
                поможет вам увеличить доход и укрепить позиции на рынке.
              </p>
            </div>
          </div>
        </div>
      </section>
	<?php
}


// <!-- Секция Наши клиенты/Кейсы --> [our_clients_section]
 add_shortcode( 'our_clients_section', "our_clients_section_func" );
 function our_clients_section_func(){
	$our_clients = get_field('our_clients');
	?>
	<section class="our_clients_section">
        <div class="wrap_section">
          <h2 class="title_left">
			<?php echo check_empty($our_clients["title"],"Нам доверяют: <br /> Истории успеха наших клиентов" ); ?>
          </h2>
          <div class="wrap_content">
            <div class="our_client_slider_btn">
              <img
                src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/arrow_prev.svg"
                class="our_client_prev"
                alt=""
              />
            </div>
            <div class="swiper our_clients_slider">
              <div class="swiper-wrapper">
				<?php 
				if ($our_clients && !empty($our_clients['slides'])){
					foreach ($our_clients['slides'] as $slide){
				?>
                <div class="swiper-slide">
                  <img
                    src="<?php echo $slide['img_url'] ; ?>"
                    class="slide_img"
                    alt="card_img"
                  />
                  <div class="content">
                    <div class="header_block">
                      <div class="logo_content">
                        <img
                          src="<?php echo $slide['logo_url'] ; ?>"
                          class="logo"
                          alt="logo"
                        />
                      </div>
                      <h3>
                        <?php echo $slide['title_slide']; ?>
                      </h3>
                    </div>
                    <div class="description">
                      <?php echo $slide['description']; ?>
                    </div>
                    <a href="<?php echo $slide['post_link'] ; ?>" class="btn cta_primary">Подробнее</a>
                  </div>
                </div>
				<?php
					}
				}
				?>
              </div>
            </div>
            <div class="our_client_slider_btn">
              <img
                src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/arrow_next.svg"
                class="our_client_next"
                alt=""
              />
            </div>
          </div>
        </div>
      </section>
	<?php
 }

//<!-- Секция  отзывы (общие) --> [general_customer_reviews_section]
 add_shortcode( 'general_customer_reviews_section', "general_customer_reviews_section_func" );
 function general_customer_reviews_section_func(){
	?>
	    <section class="general_customer_reviews_section">
        <div class="wrap_section">
          <h2 class="pseudo_h1">
            Что говорят о нас клиенты: <br />
            Ваше мнение – наш приоритет
          </h2>

          <div class="reviews_about">
            <iframe
              style="
                width: 100%;
                height: 100%;
                border: 1px solid #e6e6e6;
                border-radius: 8px;
                box-sizing: border-box;
              "
              src="https://yandex.ru/maps-reviews-widget/73654501305?comments"
            ></iframe
            ><a
              style="
                box-sizing: border-box;
                text-decoration: none;
                color: #b3b3b3;
                font-size: 10px;
                font-family: YS Text, sans-serif;
                padding: 0 16px;
                position: absolute;
                bottom: 8px;
                width: 100%;
                text-align: center;
                left: 0;
                overflow: hidden;
                text-overflow: ellipsis;
                display: block;
                max-height: 14px;
                white-space: nowrap;
              "
              href="https://yandex.ru/maps/org/upakovych/73654501305/"
              target="_blank"
              rel="noopener"
              >Упаковыч на карте Санкт‑Петербурга — Яндекс Карты</a
            >
          </div>
        </div>
      </section>
	<?php
 }

//  <!-- Секция Этапы сотрудничества --> [stages_cooperation_section]
add_shortcode( 'stages_cooperation_section', "stages_cooperation_section_func" );
function stages_cooperation_section_func(){
	?>
	      <section class="stages_cooperation_section">
        <div class="wrap_section">
          <h2 class="pseudo_h1">
            Как мы работаем: <br />
            Простой путь к идеальной упаковке
          </h2>
          <div class="steps_block">
            <img
              src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/step_section_bg.png"
              class="bg_step_section"
              alt="cover"
            />
            <div class="step">
              <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/step_1.svg" alt="icon_step" />
              <div class="content_step">
                <h3>Оставьте заявку или позвоните нам:</h3>
                <div class="description">
                  Свяжитесь с нами удобным для вас способом. Наши менеджеры
                  оперативно ответят на все вопросы и помогут оформить запрос.
                </div>
              </div>
            </div>
            <div class="step">
              <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/step_2.svg" alt="icon_step" />
              <div class="content_step">
                <h3>Получите консультацию и индивидуальное предложение:</h3>
                <div class="description">
                  Мы проанализируем ваши потребности и предложим оптимальные
                  решения, учитывая специфику вашего бизнеса и бюджет.
                </div>
              </div>
            </div>
            <div class="step">
              <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/step_3.svg" alt="icon_step" />
              <div class="content_step">
                <h3>Согласуйте макет и условия:</h3>
                <div class="description">
                  После утверждения предложения мы подготовим макет упаковки и
                  согласуем все детали заказа.
                </div>
              </div>
            </div>
            <div class="step">
              <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/step_4.svg" alt="icon_step" />
              <div class="content_step">
                <h3>Производство и контроль качества:</h3>
                <div class="description">
                  На собственном производстве мы строго контролируем каждый
                  этап, гарантируя соответствие продукции высоким стандартам
                  качества.
                </div>
              </div>
            </div>
            <div class="step">
              <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/step_5.svg" alt="icon_step" />
              <div class="content_step">
                <h3>Оперативная доставка: :</h3>
                <div class="description">
                  Готовая упаковка будет доставлена точно в срок по указанному
                  адресу в Санкт-Петербурге, Москве или любом другом регионе
                  России.
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция География работы --> [geography_work_section]
add_shortcode( 'geography_work_section', "geography_work_section_func" );
function geography_work_section_func(){
	?>
	   <section class="geography_work_section">
        <div class="wrap_section">
          <h2 class="title_left">
            Доставляем <br />
            упаковку по всей России
          </h2>
          <div class="post_title">ваш заказ – в любой точке страны</div>
          <div class="wrap_content">
            <div class="col">
              <a href="#">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/geography_1.png" alt="" />
              </a>
            </div>
            <div class="col">
              <a href="#">
                <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/geography_2.png" alt="" />
              </a>
            </div>
          </div>
        </div>
      </section>
      <section class="main_advantages_section geography">
        <div class="wrap_section">
          <h2>Сроки доставки</h2>
          <div class="features">
            <div class="feature">
              <div class="hed_wrap_content">
                <h3>Экономия до 20%</h3>
              </div>
              <p>Срок: от 1 рабочего дня</p>
              <ul>
                <li>
                  Заказы, оформленные до 13:00, могут быть доставлены уже на
                  следующий рабочий день.
                </li>
                <li>
                  Если товар есть на складе, доставка возможна в день заказа —
                  по согласованию.
                </li>
                <li>
                  В выходные и праздничные дни доставка осуществляется по
                  индивидуальному графику.
                </li>
                <li>
                  При оформлении крупногабаритного заказа срок доставки может
                  увеличиться на 1–2 дня.
                </li>
                <li>
                  Доставка осуществляется по зонам — Зона 1, 2 и 3 (см. карту).
                </li>
              </ul>
            </div>
            <div class="feature">
              <div class="hed_wrap_content">
                <h3>По России (ТК)</h3>
              </div>
              <p>Срок: от 2 до 7 рабочих дней</p>
              <ul>
                <li>
                  Мы отправляем грузы в любой регион России удобной для вас
                  транспортной компанией:СДЭК, Деловые линии, ПЭК, Энергия,
                  Байкал Сервис и др.
                </li>
                <li>
                  Отправка производится в течение 1 рабочего дня после
                  подтверждения заказа.
                </li>
                <li>зависят от региона получателя и графика работы ТК</li>
              </ul>
            </div>
            <div class="feature">
              <div class="hed_wrap_content">
                <h3>Экспресс-доставка</h3>
              </div>
              <p>Срок: от 2–4 часов до 1 дня (в пределах СПб)</p>
              <ul>
                <li>
                  Осуществляется в день заказа, если он подтверждён до 12:00.
                </li>
                <li>
                  Доступна при наличии товара на складе и при условии
                  согласования с менеджером.
                </li>
                <li>
                  Возможна доставка курьером или по договорённости — через
                  сервисы срочной доставки.
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция CTA + Форма обратной связи --> [cta_feedback_section]
add_shortcode( 'cta_feedback_section', "cta_feedback_section_func" );
function cta_feedback_section_func(){
	$cta_feedback = get_field("cta_feedback");
	?>
	  <section class="cta_feedback_section">
        <div class="wrap_section">
          <div class="col col_1">
            <h2>Свяжитесь с нами</h2>
            <p>
              телефон <br />
              <?php echo check_empty($cta_feedback['tel_pref'], '+7-993-'); ?><a href="tel:<?php echo check_empty($cta_feedback['tel_pref'], '+7-993-'); ?><?php echo check_empty($cta_feedback['tel_num'], '073-20-85'); ?>"><?php echo check_empty($cta_feedback['tel_num'], '073-20-85'); ?></a>
            </p>
            <p>
              E-mail:
              <a href="mailto:<?php echo check_empty($cta_feedback['e_mail'], '7795@upakovych.ru'); ?>"><?php echo check_empty($cta_feedback['e_mail'], '7795@upakovych.ru'); ?></a>
            </p>
            <a href="#request_call" class="btn cta_white request_call">Связаться с нами</a>
          </div>
          <div class="col col_2">
            <h3>Заполните форму и получите индивидуальное предложение</h3>
			<?php echo do_shortcode( '[metform form_id="314"]' ); ?>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция Блок с новостями/акциями --> [news_sales_secton]
add_shortcode( 'news_sales_secton', "news_sales_secton_func" );
function news_sales_secton_func(){
	$news_sales = get_field('news_sales');
	?>
	    <section class="news_sales_secton">
        <div class="wrap_section">
          <h2 class="pseudo_h1"><?php echo check_empty($news_sales["title"],"Акции Upakovych.ru" ); ?></h2>
          <div class="wrap_content">
            <div class="discount-grid">

			<?php if($news_sales && !empty($news_sales['sales_group'])){
				foreach ($news_sales['sales_group'] as $sale){
			?>
              <div class="discount-box">
                <div class="circle red" style="background-color: <?php echo $sale['color'] ? $sale['color'] : 'inherit'?>"><?php echo $sale['procent']; ?>%</div>
                <strong><?php echo $sale['title_sale']; ?></strong>
				<?php echo $sale['is_vip'] ? '<div class="vip">+ <span>VIP статус</span></div>' : null; ?>
                <p>
                  <?php echo $sale['description']; ?>
                </p>
              </div>
			<?php
				}
			} ?>
            </div>
          </div>
        </div>
      </section>
	<?php
}

// <!-- Секция Наши партнеры (для B2B-партнеров) --> [logo_slide_section]
add_shortcode( 'logo_slide_section', "logo_slide_section_func" );
function logo_slide_section_func(){
	$logo_slide = get_field('logo_slide');
	if (!empty($logo_slide)){
	?>
	<section class="logo_slide_section">
        <div class="wrap_section">
          <h2 class="title_left"><?php echo check_empty($logo_slide['title'], "Наши клиенты"); ?></h2>
          <div class="wrap_slider">
            <div class="logo_slider_btn">
              <img
                src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/arrow_prev_white.svg"
                class="logo_btn_prev"
                alt=""
                tabindex="0"
                role="button"
                aria-label="Previous slide"
                aria-controls="swiper-wrapper-c48fada187bb101710"
              />
            </div>
            <div class="swiper logo_slider">
              <div class="swiper-wrapper">
				<?php if ($logo_slide && !empty($logo_slide['logos'])){
					foreach ($logo_slide['logos'] as $slide){
				?>
                <div class="swiper-slide">
                  <div class="logo_slide">
                    <img src="<?php echo $slide['logo_url']; ?>" alt="" />
                  </div>
                </div>
				<?php
					}
				} ?>
              </div>
            </div>
            <div class="logo_slider_btn">
              <img
                src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/icon/arrow_next_white.svg"
                class="logo_btn_next"
                alt=""
                tabindex="0"
                role="button"
                aria-label="Next slide"
                aria-controls="swiper-wrapper-c48fada187bb101710"
              />
            </div>
          </div>
        </div>
      </section>
	<?php
	}
}

// <!-- Секция контакты --> [contacts_section]
add_shortcode( 'contacts_section', "contacts_section_func" );
function contacts_section_func(){
	?>
	      <section class="contacts_section">
        <div class="wrap_section">
          <h2>Контактная информация</h2>
          <div class="wrap_content">
            <div class="col">
              <div class="info">
                <h3>Контакты для связи</h3>
                <a href="tel:88001019652">8 (800) 101-96-52</a> <br />
                <a href="tel:89921854801">8 (992) 185-48-01</a>
              </div>
              <div class="info">
                <h3>Электронная почта:</h3>
                <a href="mailto:7795@upakovych.ru">7795@upakovych.ru</a>
              </div>
              <div class="info">
                <h3>Адрес:</h3>
                <a
                  href="https://yandex.ru/maps/2/saint-petersburg/house/polevaya_sabirovskaya_ulitsa_45k1/Z0kYdABlSUwDQFtjfXV4dXRlbA==/?ll=30.275093%2C59.994868&amp;source=serp_navig&amp;z=16"
                  target="_blank"
                  rel="noopener"
                  >Санкт-Петербург <br />
                  ул. Полевая Сабировская,45к1</a
                >
              </div>
              <div class="info">
                <h3>ПРОСЬБА, ПРЕДВАРИТЕЛЬНО ЗВОНИТЬ.</h3>
                <p>Режим работы:</p>
                <p>Пн-Чт. : с 10:00 до 18:00; Пт.: с 10:00 до 17:00</p>
              </div>
            </div>
            <div class="col img">
              <img src="<?php echo get_template_directory_uri(  ); ?>/assets/images/sections/contact_section_img.png" alt="" />
            </div>
          </div>
        </div>
      </section>
	<?php
}