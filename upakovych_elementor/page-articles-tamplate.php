<?php
/**
 Template name: Статьи
 Template post type: page
 * 
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();

while ( have_posts() ) :
	the_post();
	?>

    <main>
      <!-- Hero Section -->
	   <?php 
	 	$hero_section = get_field("hero_section");  
	   ?>
      <section class="hero_section_articles">
        <div class="wrap_section">
          <h1>
			<?php echo $hero_section["title"] ? $hero_section["title"] : "Статьи <br />об упаковке <br />и логистике"; ?>
          </h1>
          <div class="wrap_content">
            <div class="content_block">
              <div class="padding"></div>
              <div class="discription">
                <p>
					<?php echo $hero_section["description"] ? $hero_section["description"] : "Введите описание секции"; ?>
                </p>
              </div>
              <div class="wrap_btn flex_row">
                <a href="/katalog-tovarov/" class="btn cta_white">Перейти в каталог</a>
              </div>
            </div>
            <div class="slider_wrap">
              <div class="hero_section_slider">
                <div class="swiper-wrapper">
					<?php 
						if ($hero_section && !empty($hero_section['slider'])){
							foreach ($hero_section['slider'] as $slider_url){
					?>                  
					<div class="swiper-slide">
						<img
						src="<?php echo $slider_url; ?>"
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

      <!-- Секция статьи -->
	   <?php 
	 	$arg = [
			'post_type' => 'post',
			'paged' => 1,
			'posts_per_page' => 9,
			'category_name' => 'articles',
		];  
		$query = new WP_Query($arg);
	   ?>
      <section class="articles_section">
        <div class="wrap_section">
          <h2>Все статьи</h2>
		  <?php 
		 	if ($query->have_posts()){
			?>
          <div class="articles" id="article_wrap">
            
			 <?php 
			 	while ($query->have_posts()){
					$query->the_post();
				?>
				<!-- Статья -->
				<div class="article">
				<a href="<?php the_permalink(); ?>">
					<div class="wrap_img">
					<img src="<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri().'/assets/images/sections/istockphoto-2173059563-612x612.jpg' ; ?>" alt="" />
					</div>
					<div class="content">
					<h3>
						<?php the_title(); ?>
					</h3>
					<div class="description">
						<?php 
							the_excerpt();
						?>
					</div>
					</div>
				</a>
				</div>
				<!-- КОНЕЦ Статья -->
			<?php
				}
			 ?>
          </div>
			<?php
			} else {
				echo "<div>Записи отсутствуют</div>";
			}
		  ?>

          <!-- Кнопка -->
		   <?php 
		 	global $wp_query;
			$paged = $query->paged ? $query->paged : 1;
			$max_pages = $query->max_num_pages;
			if ($paged < $max_pages){
			?>
			<div class="btn_block">
				<a href="/katalog-tovarov/" id="load_more" class="btn cta_primary" data-max_pages="<?php echo $max_pages; ?>" data-paged="<?php echo $paged; ?>"><span>Показать еще</span><div class="loader"></div></a>
			</div>
			<?
			}
		   ?>
		   <?php wp_reset_postdata(); ?>

        </div>
      </section>

      <!-- Секция Популярные статьи -->
	   <?php 
	 	$arg = [
			'post_type' => 'post',
			'posts_per_page' => 4,
			'category_name' => 'articles_favorit'
		];
		
		$favorite_articles = get_posts($arg);

		if (!empty($favorite_articles)){
		?>
		<section class="popular_articles_section">
			<div class="wrap_section">
			<h2>ПОПУЛЯРНЫЕ СТАТЬИ</h2>
			<div class="articles">
			<?php 
			
				foreach ($favorite_articles as $post){
					setup_postdata($post);
			?>
							<!-- Начало статьи -->
				<div class="article">
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri().'/assets/images/sections/istockphoto-2173059563-612x612.jpg' ; ?>" alt="" />
					<div class="tint_color"></div>
					<div class="content">
					<h3>
						<?php the_title(); ?>
					</h3>
					<div class="description">
						<?php the_excerpt(); ?>
					</div>
					</div>
				</a>
				</div>
				<!-- Конец статьи -->


			<?php
				}
				wp_reset_postdata();
			?>
			</div>
			</div>
		</section>


		<?php
		} else {
			echo "<div>Записи отсутствуют</div>";
		}
	   ?>


      <!-- Секция CTA каталог -->
      <section class="cta_catalog_section">
        <div class="wrap_section">
          <div class="content">
            <h2>Нужна упаковка под ключ?</h2>
            <div class="description">
              Перейдите в каталог и соберите решение под ваши задачи — коробки,
              плёнка, наполнители и расходники. Если хотите, поможем с подбором
              по телефону.
            </div> 
          </div>
          <div class="btn_block">
            <a href="/katalog-tovarov/" class="btn cta_white">Перейти в каталог</a>
          </div>
        </div>
      </section>
    </main>

	<?php
endwhile;
get_footer();