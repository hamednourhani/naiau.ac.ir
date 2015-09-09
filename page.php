<?php get_header(); ?>

			<main class="site-main">

				
				<?php 
						var_dump(get_post_ancestors( $post->ID ));
						$sub_mother = get_post_meta(get_the_ID(),'_naiau_sub_mother_page');
						
						$current_page_id = $post->ID;
						$parent_id = $post->ID;

						// $children = get_pages('child_of='.get_the_ID());
						if($sub_mother[0] == 'mother') { 
							$sub_pages = get_post_meta($current_page_id,'_naiau_group_sub_pages');
							$related_pages = get_post_meta($current_page_id,'_naiau_group_related_pages');
						}elseif($post->post_parent){
							$sub_pages = get_post_meta($post->post_parent,'_naiau_group_sub_pages');
							$related_pages = get_post_meta($post->post_parent,'_naiau_group_related_pages');
							$parent_id = $post->post_parent;
						}else{
							$sub_pages = array();
							$related_pages = array();
						}
						var_dump(get_the_title($parent_id));
						

						
												
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
												<li><span class="sub-header"><?php get_the_title($parent_id);?></span></li>
												
												<?php foreach ($sub_pages[0] as $sub_page) {
													
													$sub_class = "";
													
													if($sub_page['sub_id'] == $current_page_id){
														$sub_class="current";
													} 
													echo '<li><a class="sub-page-link '.$sub_class.'" href="'.get_the_permalink($sub_page['sub_id']).'">'.$sub_page['list_name'].'</a></li>';
												}?>
												
											</ul>
											<?php if(!empty($related_pages[0])){ ?>
												<ul class="sub-widget">
													<li><span class="related-header"><?php echo __('related links','naiau');?></span></li>
													<?php foreach ($related_pages[0] as $related_page) {
													
													$sub_class = "";
													
													if($related_page['sub_id'] == $current_page_id){
														$sub_class="current";
													} 
													echo '<li><a class="related-link '.$sub_class.'" href="'.get_the_permalink($related_page['sub_id']).'">'.$related_page['list_name'].'</a></li>';
												}?>
													
												</ul>

											<?php }?>
										</div>

										<div class="page-content with-sidebar">	
											<?php the_content() ?>
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
