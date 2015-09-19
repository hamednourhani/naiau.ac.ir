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

<?php get_header(); 
			$archive_name ='';
			$download_page = false;
			$notify_page = false;
			$circular_page = false;
	if($_GET['post_type'] && $_GET['post_type'] == 'download' ){
			$archive_name = __("Downloads",'naiau');
			$download_page = ture;
	}elseif($_GET['post_type'] && $_GET['post_type'] == 'notify' ){
			$archive_name = __("Notifies",'naiau');
			$notify_page = ture;
	}elseif($_GET['post_type'] && $_GET['post_type'] == 'circular' ){
			$archive_name = __("Circulars",'naiau');
			$circular_page = ture;

	}
?>


			<main class="site-main">

			
					 <div class="main-area">
						
							<div class="content-area">
							
								<div class="single-page-title">
									<section class="layout">
										<h1><?php echo __('Archive : ','naiau').$archive_name; ?></h1>
									</section>
								</div>
								
									<div class="page-main">
										<section class="layout">

										   <div class="page-content with-sidebar">	
												<?php if(have_posts()){ ?>
													<?php while(have_posts()) { the_post(); ?>
													
														<article class="hentry">
															<div class="featured-image single-image">
															<?php if($download_page='true'){ ?>
																<a href="<?php echo get_post_meta($get_the_ID,'_naiau_download_url',1); ?>">
															<?php }else{ ?>	
																<a href="<?php the_permalink(); ?>">
															<?php } ?>
																	<?php get_template_part('library/thumbnail','maker'); ?>
																</a>
															</div>
															<div class="post-title">
																<a href="<?php the_permalink(); ?>">
																	<h3><?php the_title(); ?></h3>
																</a>
															</div>
															<div class="post-content">
																<?php the_excerpt(); ?>
																<?php get_template_part('library/post','meta'); ?>
															</div>
														</article>
													<?php } ?>
												<?php } ?>
												
											</div>
											<div class="page-sidebar">
												<?php
													if($download_page == true){
														get_sidebar('download');
													}elseif($notify_page == true){
														get_sidebar('notify');
													}elseif($circular_page == true){
														get_sidebar('circular');
													}else{
														get_sidebar(); 
													}
													
												?>
											</div>
										
									</section>
								</div>
							</div>
					</div>
				
				

				
				<?php get_template_part('library/footer','links'); ?>
				<?php get_template_part('library/related','links'); ?>

			
		</main>

				
<?php get_footer(); ?>
