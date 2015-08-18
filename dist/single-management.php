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

				
					
				<?php  $sub_id = get_query_var('sub_id',1)  ;
						$sub_pages = get_post_meta(get_the_ID(),'_naiau_group_sub_page');
						$related_links = get_post_meta(get_the_ID(),'_naiau_group_related_links');
						$management_url = get_the_permalink();
												
				?>
				
				

				
				<?php if(have_posts()){ ?>
					 <div class="main-area">
						<?php while(have_posts()) { the_post(); ?>
							<div class="content-area">
							
								<div class="single-page-title">
									<section class="layout">
										<h1><?php the_title(); ?></h1>
									</section>
								</div>
								<div class="page-main has-sub-page">
									<section class="layout">
										<div class="page-sidebar">
											<ul class="sub-widget">
												<li><span class="sub-header"><?php the_title();?></span></li>
												<?php foreach ($sub_pages[0] as $sub_page) {
													$sub_page_url = $management_url.'?sub_id='.$sub_page['sub_id'].'">'.$sub_page['sub_name'];
													$sub_class = "";
													
													if($sub_page['sub_id'] == $sub_id){
														$sub_class="current";
													} elseif($sub_id != '1' && $sub_pages[0][0] == $sub_id){
														$sub_class="current";
													}
													echo '<li><a class="sub-page-link '.$sub_class.'" href="'.$sub_page_url.'</a></li>';
												}?>
												
											</ul>
											<?php if(!empty($related_links[0])){ ?>
												<ul class="sub-widget">
													<li><span class="related-header"><?php echo __('related links','naiau');?></span></li>
													<?php foreach ($related_links[0] as $related_link) {
														echo '<li><a class="related-link" href="'.$related_link['link_url'].'">'.$related_link['link_name'].'</a></li>';
													}?>
													
												</ul>

											<?php }?>
										</div>

										<div class="page-content with-sidebar">	
											<?php if($sub_id != '1'){
												
												$content_post = get_post($sub_id);
												$content = $content_post->post_content;
												$content = apply_filters('the_content', $content);
												$content = str_replace(']]>', ']]&gt;', $content);
												echo $content;
											} else {
												
												$content_post = get_post($sub_pages[0][0]['sub_id']);
												$content = $content_post->post_content;
												$content = apply_filters('the_content', $content);
												$content = str_replace(']]>', ']]&gt;', $content);
												
												if($content){
													echo $content;
												} else {
													echo get_the_content();
												}
												
											}?>
										</div>
										
									</section>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				

				
				<?php get_template_part('library/footer','links'); ?>
				

			
		</main>

				
<?php get_footer(); ?>
