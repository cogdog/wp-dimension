<?php get_header(); ?>

			<!-- Header -->
				<div id="pagemain">
						
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
					
								<div id="staticpage" <?php post_class('post single'); ?>>	
						
									<h2 class="major"><?php the_title(); ?></h2>
							
									<?php  
									if ( has_post_thumbnail() ) 
										echo '<span class="main image">';
										the_post_thumbnail('page-thumb'); 
										echo '</span>';
									?>
									
									<?php the_content(); ?>
							
							
									<p class="align-center"><a href="<?php echo site_url(); ?>" class="button special icon  fa-hand-o-left">return</a></p>

								</div>
									
					<?php endwhile; else: ?>
						
			<p><?php _e("We couldn't find any posts that matched your query. Please try again.", "dimension"); ?></p>

	<?php endif; ?>
					


								
<?php get_footer(); ?>