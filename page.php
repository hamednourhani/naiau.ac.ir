<?php get_header(); ?>

			<main class="site-main">

				
				<?php 
						$parent_pages = get_post_ancestors( $post->ID );
	
						$current_page_id = $post->ID;
						$parent_id = $post->ID;
						$current_content = $post->ID;

						$sub_pages = get_post_meta($current_page_id,'_naiau_group_sub_pages');
						$has_child = false;
						foreach($sub_pages[0] as $sub_page){

							if($sub_page['sub_id'] !== 'none' && $has_child == false){
								$has_child = true;
								$current_content = $sub_page['sub_id'];
								
							}
						}
						// var_dump($sub_pages[0][0]['sub_id']);
						if($post->post_parent && $has_child !== true/*$sub_pages[0][0]['sub_id'] =="none"*/ ){
							// var_dump($sub_pages);
							
							$sub_pages = get_post_meta($post->post_parent,'_naiau_group_sub_pages');
							$related_pages = get_post_meta($post->post_parent,'_naiau_group_related_pages');
							$parent_id = $post->post_parent;
							//var_dump($sub_pages);
						
						}else{
												
							$sub_pages = get_post_meta($current_page_id,'_naiau_group_sub_pages');
							$related_pages = get_post_meta($current_page_id,'_naiau_group_related_pages');
						}


						

						
												
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
												<li><a class="sub-header" href="<?php echo get_the_permalink($parent_id);?>"><?php echo get_the_title($parent_id);?></a></li>
											
												<?php if($sub_pages[0] !== null ){ ?>	
													
													<?php foreach ($sub_pages[0] as $sub_page) {
														
														$sub_class = "";
														
														if($sub_page['sub_id'] == $current_content){
															$sub_class="current";
														}
														if($sub_page['sub_id'] !=="none"){
															echo '<li><a class="sub-page-link '.$sub_class.'" href="'.get_the_permalink($sub_page['sub_id']).'">'.$sub_page['list_name'].'</a></li>';
														}
													}?>
												<?php } ?>	
											</ul>
											<?php if( $related_pages[0] !== null){ ?>
												<ul class="sub-widget">
													<li><span class="related-header"><?php echo __('related links','naiau');?></span></li>
													<?php foreach ($related_pages[0] as $related_page) {
															
															$sub_class = "";
															if($related_page['sub_id'] == $current_content){
																$sub_class="current";
															} 
															if($related_page['sub_id'] !=="none" && $related_page['link_or_page'] == 'page'){
																echo '<li><a class="related-link '.$sub_class.'" href="'.get_the_permalink($related_page['sub_id']).'">'.$related_page['list_name'].'</a></li>';
															}elseif($related_page['link_url'] !== false && $related_page['link_or_page'] == 'link'){
																echo '<li><a class="related-link '.$sub_class.'" href="'.$related_page['link_url'].'">'.$related_page['list_name'].'</a></li>';
															}
														
													}?>
													
												</ul>

											<?php }?>
											<?php if(count($parent_pages) > 0){ ?>
												<ul class="parent-widget">
													<?php foreach ($parent_pages as $parent_page) {
															echo '<li><a class="parent-link " href="'.get_the_permalink($parent_page).'">'.get_the_title($parent_page).'</a></li>';
													}?>
												</ul>
											<?php }?>
										</div>

										<div class="page-content with-sidebar">	
											<?php// the_content(); ?>

											<?php 	
													$content_post = get_post($current_content);
													$content = $content_post->post_content;
													$content = apply_filters('the_content', $content);
													$content = str_replace(']]>', ']]&gt;', $content);
													echo $content; 
											?>
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
