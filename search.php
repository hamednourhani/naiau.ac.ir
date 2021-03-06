<?php
/*
 * CUSTOM POST TYPE TEMPLATE
 *
 * This is the custom post type post template. If you edit the post type name, you've got
 * to change the name of this template to reflect that name change.
 *
 * For Example, if your custom post type is "register_post_type( 'bookmarks')",
 * then your single template should be single-bookmarks.php
 *
 * Be aware that you should rename 'custom_cat' and 'custom_tag' to the appropiate custom
 * category and taxonomy slugs, or this template will not finish to load properly.
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
*/
?>

<?php get_header(); ?>

			<main class="site-main">

			
					 <div class="main-area">
						
							<div class="content-area">
							
								<div class="single-page-title">
									<section class="layout">
										<h1><?php printf( __( 'Search Results for: %s', 'naiau' ), get_search_query() ); ?></h1>
									</section>
								</div>
								
									<div class="page-main">
										<section class="layout">

										   <div class="page-content with-sidebar">	
										   		<?php get_search_form( true ); ?>
												<?php if(have_posts()){ ?>
													<?php while(have_posts()) { the_post(); ?>
													
														<article class="hentry">
															
															<div class="post-title">
																<a href="<?php the_permalink(); ?>">
																	<h3><?php the_title(); ?></h3>
																</a>
															</div>
															<div class="post-content">
																<?php the_excerpt(); ?>
																															</div>
														</article>
													<?php } ?>
												<?php }else{ ?>
													<article class="hentry page404">
														
															<p class="notfound"><?php _e( '<i class="icon-attention"></i>Sorry, but nothing matched your search terms. Please try again with different keywords.', 'naiau' ); ?></p>	
														
													
												<?php } ?>
												<nav class="pagination">
													<?php naiau_pagination(); ?>
												</nav>	
											</div>
											<div class="page-sidebar">
												<?php get_sidebar(); ?>
											</div>
										
									</section>
								</div>
							</div>
					</div>
				
				

				
				<?php get_template_part('library/footer','links'); ?>
				<?php get_template_part('library/related','links'); ?>

			
		</main>

				
<?php get_footer(); ?>
