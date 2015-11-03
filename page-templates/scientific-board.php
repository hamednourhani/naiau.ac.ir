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

//if($_GET['science_board']){
if($wp_query->query_vars['sb']){

	$single_user_slug = $wp_query->query_vars['sb']; 
	//$single_user = get_userdata($single_user_id);
	$single_user = get_user_by('slug',$single_user_slug);
	$single_user_id = $single_user->ID;
	//var_dump(get_option('permalink_structure'));
} else {

	 $args = array(
		'blog_id'      => $GLOBALS['blog_id'],
		'role'         => 'si_board',
		'meta_key'     => '_naiau_user_edu_group',
		'meta_value'   => '',
		'meta_compare' => '',
		'meta_query'   => array(),
		'date_query'   => array(),        
		'include'      => array(),
		'exclude'      => array(),
		'orderby'      => '_naiau_user_edu_group',
		'order'        => 'ASC',
		'offset'       => '',
		'search'       => '',
		'number'       => '',
		'count_total'  => false,
		'fields'       => 'all',
		'who'          => ''
	 );

	$users = get_users($args);


} ?>

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
											
											
										
									
									<?php if(!empty($users) && $single_user_id == ''){ ?>
										<div class="page-content without-sidebar">
											<div class="table-container">
												
												<table class="scientific-board">
													<tbody>
														<tr>
															<th><?php echo __('Row','naiau'); ?></th>
															<th><?php echo __('Name and Family','naiau'); ?></th>
															<th><?php echo __('Sience Degree','naiau'); ?></th>
															<th><?php echo __('Educational Group','naiau'); ?></th>
																													
														</tr>
														<?php 	
																$counter = 1; 
																$edu_group = '';
															 	// $current_group = '';
															 	// $prev_group = ''; 
														?>

														<?php foreach($users as $user){?>
															<tr>
																<?php 
																	$edu_group = get_usermeta( $user->ID, $meta_key = '_naiau_user_edu_group' );
																	// var_dump($edu_group);
																		switch($edu_group){
																			case 'electronic':
																				$edu_group = __('Electronic Engineering','naiau').'<small>'.' (Electronic Engineering)'.'</small>';
																				break;
																			
																			case 'mechanic':
																				$edu_group = __('Mechanic Engineering','naiau').'<small>'.' (Mechanic Engineering)'.'</small>';
																				break;
																			
																			case 'civil':
																				$edu_group = __('Civil Engineering','naiau').'<small>'.' (Civil Engineering)'.'</small>';
																				break;
																			
																			case 'material':
																				$edu_group = __('Material Engineering','naiau').'<small>'.' (Material Engineering)'.'</small>';
																				break;
																			
																			case 'computer':
																				$edu_group = __('Computer Engineering','naiau').'<small>'.' (Computer Engineering)'.'</small>';
																				break;
																			
																			case 'public':
																				$edu_group = __('Public','naiau').'<small>'.' (Public)'.'</small>';
																				break;

																			case 'accounting':
																				$edu_group = __('Accounting','naiau').'<small>'.' (Accounting)'.'</small>';
																				break;
																		}
																	// $current_group = ($edu_group == $prev_group)?('~'):$edu_group; 
																	// $prev_group = $current_group;
																?>
																<td><?php echo $counter ;?></td>
																
																<?php 
																	if(get_option('permalink_structure') == '/%postname%/'){
																		$sb_url = get_the_permalink().'/'.$user->user_nicename;
																	} else {
																		$sb_url = add_query_arg( array('sb' => $user->user_nicename), get_the_permalink() );
																	}
																?>
																																
																<td><a href="<?php echo $sb_url;?>"><?php echo $user->display_name; ?></a></td>
																<td><?php echo get_usermeta( $user->ID, $meta_key = '_naiau_user_degree' );?></td>
																<td><?php echo $edu_group; ?></td>
															
															</tr>
														<?php 
															$counter++;
														} ?>
													</tbody>
												</table>
											
											</div>
										</div>
									<?php } elseif($single_user_id !== ''){?>
										<div class="profile-page">
																			
											<div id="tabs" class="science-tabs">
													
													<ul>
															<?php  
																	
																	echo '<div class="author-pic"><img src="'. get_usermeta( $single_user_id, $meta_key = '_naiau_user_picture' ) .'" alt="'.$single_user->display_name.'" title="'.$single_user->display_name.'"/></div>';
															?>
															<li><a href="#profile"><?php echo 'Home '.__('(Home)','naiau');?></a></li>
															<li id="exp-main" class="has-child"><a ><?php echo 'Experience '.__('(Experiences)','naiau');?></a></li>
																<li class="exp-child child-tab"><a href="#academic_positions"><?php echo 'Academic Positions '.__('(Academic Positions)','naiau');?></a></li>
																<li class="exp-child child-tab"><a href="#industrial_experience"><?php echo 'Industrial Experience '.__('(Industrial Experience )','naiau');?></a></li>
															<li id="pub-main" class="has-child"><a ><?php echo 'Publications '.__('(Publications)','naiau');?></a></li>
																<li class="pub-child child-tab"><a href="#books"><?php echo 'Books '.__('(Books)','naiau');?></a></li>
																<li class="pub-child child-tab"><a href="#journal_papers"><?php echo 'Journal Papers'.__('(Journal Papers)','naiau');?></a></li>
																<li class="pub-child child-tab"><a href="#conference_papers"><?php echo 'Conference Papers'.__('(Conference Papers)','naiau');?></a></li>

															<li><a href="#research_projects"><?php echo 'Research projects '.__('(Research projects)','naiau');?></a></li>
															<li id="course-main" class="has-child"><a ><?php echo 'Courses '.__('(Courses)','naiau');?></a></li>
																<?php 
																	$args = array(
																			'posts_per_page'   => -1,
																			'offset'           => 0,
																			'category'         => '',
																			'category_name'    => '',
																			'orderby'          => 'date',
																			'order'            => 'DESC',
																			'include'          => '',
																			'exclude'          => '',
																			'meta_key'         => '',
																			'meta_value'       => '',
																			'post_type'        => 'course',
																			'post_mime_type'   => '',
																			'post_parent'      => '',
																			'author'	   => $single_user_id,
																			'post_status'      => 'publish',
																			'suppress_filters' => true 
																		);
																	$courses = get_posts( $args );

																	if(!empty($courses)){
																		setup_postdata( $courses );
																		foreach($courses as $course){
																			echo '<span class="course-child child-tab"><a href="'.get_the_permalink($course->ID).'">'.$course->post_title.'</a></span>';
																		}
																	}
																?>
															<li><a href="#comments"><?php echo 'More Details '.__('(Comments)','naiau');?></a></li>
															
														
													</ul>
													
													<div id="profile" class="science-tab">
														
														<div class="science-info-wrapper">
															<div class="science-pic">
																<?php echo '<img src="'. get_usermeta( $single_user_id, $meta_key = '_naiau_user_picture' ) .'" alt="'.$single_user->display_name.'" title="'.$single_user->display_name.'"/>';?>
															</div>
															<ul class="science-info">
																<?php 
																	$edu_group = get_usermeta( $single_user_id, $meta_key = '_naiau_user_edu_group' );
																	switch($edu_group){
																		case 'electronic':
																			$edu_group = __('Electronic Engineering','naiau').'<small>'.' (Electronic Engineering)'.'</small>';
																			break;
																		
																		case 'mechanic':
																			$edu_group = __('Mechanic Engineering','naiau').'<small>'.' (Mechanic Engineering)'.'</small>';
																			break;
																		
																		case 'civil':
																			$edu_group = __('civil Engineering','naiau').'<small>'.' (Civil Engineering)'.'</small>';
																			break;
																		
																		case 'material':
																			$edu_group = __('Material Engineering','naiau').'<small>'.' (Material Engineering)'.'</small>';
																			break;
																		
																		case 'computer':
																			$edu_group = __('Computer Engineering','naiau').'<small>'.' (Computer Engineering)'.'</small>';
																			break;
																		
																		case 'public':
																			$edu_group = __('Public','naiau').'<small>'.' (Public)'.'</small>';
																			break;

																		case 'accounting':
																			$edu_group = __('Accounting','naiau').'<small>'.' (Accounting)'.'</small>';
																			break;
																	}
																?>
																<li><?php echo '<strong>'.__('Name and Family','naiau').' (Name) :   '.'</strong>'.$single_user->display_name;?></li>
																<li><?php echo '<strong>'.__('Science Degree','naiau').' (Title) :  '.'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_degree' );?></li>
																<li><?php echo '<strong>'.__('Educational Group','naiau').' (Department) :  '.'</strong>'.$edu_group;?></li>
																<li><?php echo '<strong>'.__('Emails','naiau').'(Emails) :  '.'</strong><img class="science-email-pic" src="'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_emails' ).'" alt="Emails" />';?></li>
																<li><?php echo '<strong>'.__('Phone','naiau').' (Phone)  :  '.'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_phone' );?></li>

															</ul>
														</div>
														<div class="science-education">
															
															<?php 
																$education = get_usermeta( $single_user_id, $meta_key = '_naiau_user_education' ); 
																if($education !== "" ){
																	echo '<h3>'.__('Education','naiau').' (Education)</h3>'; 
																	echo $education; 
																}
															?>
														</div>	
													</div>
													
													<?php  
														$academic_position = get_usermeta( $single_user_id, $meta_key = '_naiau_science_academic_positions' ); 
														
														if($academic_position !== "" ){?>
															<div id="academic_positions" class="science-tab">
																<?php 
																	echo '<h3>'.__('Academic Positions','naiau').' (Academic Positions)</h3>';
																	echo $academic_position;
																?>
															</div> 
														<?php } ?>

													<?php  
														$industrial_experience = get_usermeta( $single_user_id, $meta_key = '_naiau_science_industrial_experience' ); 
														if($industrial_experience !== "" ){?>
															<div id="industrial_experience" class="science-tab">
																<?php 
																	echo '<h3>'.__('Industrial Experience','naiau').' (Industrial Experience)</h3>';
																	echo $industrial_experience;
																?>
															</div>
														<?php } ?>
													
													<?php  
														$books = get_usermeta( $single_user_id, $meta_key = '_naiau_science_books' ); 
														if($books !== "" ){?>
															<div id="books" class="science-tab">
																<?php 
																	echo '<h3>'.__('Books','naiau').' (Books)</h3>';
																	echo $books; 
																?>
															</div>
													<?php } ?>

													<?php  
														$journal_papers = get_usermeta( $single_user_id, $meta_key = '_naiau_science_journal_papers' ); 
														if($journal_papers !== "" ){?>
															<div id="journal_papers" class="science-tab">
																<?php 
																	echo '<h3>'.__('Journal Papers','naiau').' (Journal Papers)</h3>';
																	echo $journal_papers; 
																?>
															</div>
													<?php } ?>

													<?php  
														$conference_papers = get_usermeta( $single_user_id, $meta_key = '_naiau_science_conference_papers' ); 
														if($conference_papers !== "" ){?>
															<div id="conference_papers" class="science-tab">
																<?php 
																	echo '<h3>'.__('Conference Papers','naiau').' (Conference Papers)</h3>';
																	echo $conference_papers; 
																?>
															</div>
													<?php } ?>

													<?php  
														$research_projects = get_usermeta( $single_user_id, $meta_key = '_naiau_science_research_projects' ); 
														if($research_projects !== "" ){?>
															<div id="research_projects" class="science-tab">
																<?php 
																	echo '<h3>'.__('Research Projects','naiau').' (Research Projects)</h3>';
																	echo $research_projects; 
																?>
															</div>
													<?php } ?>

													<?php  
														$comments = get_usermeta( $single_user_id, $meta_key = '_naiau_science_comments' ); 
														if($comments !== "" ){?>
															<div id="comments" class="science-tab">
																<?php 
																	echo '<h3>'.__('Comments','naiau').' (More Details)</h3>';
																	echo $comments; 
																?>
															</div>
													<?php } ?>
																								
											</div> <!-- #tabs.science-tabs -->

											
										</div>
									<?php } ?>
									
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

	          $('#exp-main').on('click',function(){
	          		$('li.exp-child').slideToggle();
	          });
	          $('#pub-main').on('click',function(){
	          		$('li.pub-child').slideToggle();
	          });
	          $('#course-main').on('click',function(){
	          		$('span.course-child').slideToggle();
	          });
	      });
	    </script>

				
<?php get_footer(); ?>
