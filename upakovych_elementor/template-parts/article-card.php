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