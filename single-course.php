<?php
/**
 * Template Name: Scientific Board Page
 *
 * 
 */

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
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
 */

 get_header(); 
	
	


?>
		<main class="site-main">
			
			<?php if(have_posts()){ ?>
				 <div class="main-area">
					<?php while(have_posts()) { the_post(); ?>
						<div class="content-area">
						
							<div class="single-page-title">
								<section class="layout">
									<h1><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h1>
								</section>
							</div>
							<div class="page-main">
								<section class="layout">
																
										<div class="profile-page">
																			
											<div id="tabs" class="science-tabs">
													
															
													<ul>
														<div class="author-info">
															<?php 
																$author_id = get_the_author_id();
																$author = get_userdata( $author_id );
																
																if(SCIENCE_ID){
																	if(get_option('permalink_structure') == '/%postname%/'){
																			$sb_url = get_the_permalink(SCIENCE_ID).'/'.$author->user_nicename;
																	} else {
																			$sb_url = add_query_arg( array('sb' => $author->user_nicename), get_the_permalink(SCIENCE_ID) );
																	}
																}
																
	
																if($sb_url !== null){
																	echo '<div class="author-pic"><a href="'.$sb_url.'"><img src="'. get_user_meta( $author_id, '_naiau_user_picture',1 ) .'" alt="'.$author->display_name.'" title="'.$author->display_name.'"/></a></div>';
																} else {
																	echo '<span class="author-name">'.get_the_author().'</span>';

																}
															?>
														</div>

															<li><a href="#home"><?php echo 'Course '.__('(Course)','naiau');?></a></li>
															<li><a href="#lecture_reading "><?php echo 'Lecture & reading  '.__('(Lecture & reading )','naiau');?></a></li>
															<li><a href="#homework_exame"><?php echo 'Homework & Exam '.__('(Homework & Exame)','naiau');?></a></li>
															<span class="science-back-button"><a href="<?php echo $sb_url; ?>"><i class="fa fa-angle-double-right"></i><?php echo __('Back to Scinece','naiau');?></a></span>
													
													</ul>
																										
													<div id="home" class="science-tab">
														<?php the_content(); ?>
													</div> 

													<div id="lecture_reading" class="science-tab">
														<?php 
															echo '<h3>'.__('Lecture & reading','naiau').' (Lecture & reading)</h3>';
															echo get_post_meta( $post->ID,'_naiau_course_lecture_reading',1 ); 
														?>
													</div>

													<div id="homework_exame" class="science-tab">
														<?php 
															echo '<h3>'.__('Homework & Exame','naiau').' (Homework & Exame)</h3>';
															echo get_post_meta( $post->ID,'_naiau_course_homework_exame',1 ); 
														?>
													</div>

																																					
											</div> <!-- #tabs.science-tabs -->

											
										</div>
									
									
							</section>
							</div>
						</div>
					<?php } ?>

				</div>
			<?php } ?>
		
				<?php get_template_part('library/footer','links'); ?>
				
		</main>
		<script type="text/javascript" defer>
	      jQuery('document').ready(function($){
	          $('#tabs').tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	          
	      });
	    </script>

				
<?php get_footer(); ?>
