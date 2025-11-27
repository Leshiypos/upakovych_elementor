<?php
/**
 * Template Name: Шаблон
 * Template Post Type: post
 */
/**
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

<?php 
	$hero_section = get_field("hero_section");
?>
<main id="content" <?php post_class( 'site-main' ); ?>>
		<div class="about_page">
			<section class="hero" id="hero_section_single">
				<div>
					<?php if ($hero_section['title'] && $hero_section['title'] != "" ){ echo "<h1>".$hero_section['title']."</h1>";} else {the_title( '<h1 class="entry-title">', '</h1>' );} ?>
					<p>
						<?php echo  $hero_section["description"];?>
					</p>
					</div>
				<img src=" <?php echo $hero_section['img_url']; ?>" alt="Коробки" />
			</section>
		</div>

	<div class="page-content">
		<section class="single_page_cotent">
			<?php the_content(); ?>
		</section>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . esc_html__( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>

	<?php //comments_template(); ?>

</main>

	<?php
endwhile;
get_footer();
