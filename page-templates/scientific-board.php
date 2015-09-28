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
		'role'         => 'scientific_board',
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
									<div class="page-content without-sidebar">		
											
										

									<?php if(!empty($users) && $single_user_id == ''){ ?>
										<div class="table-container">
											<div class="science-tabs">	
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
																				$edu_group = __('Electronic','naiau');
																				break;
																			
																			case 'mechanic':
																				$edu_group = __('Mechanic','naiau');
																				break;
																			
																			case 'building':
																				$edu_group = __('Building','naiau');
																				break;
																			
																			case 'material':
																				$edu_group = __('Material','naiau');
																				break;
																			
																			case 'computer':
																				$edu_group = __('Computer','naiau');
																				break;
																			
																			case 'public':
																				$edu_group = __('Public','naiau');
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
																																
																<td><a href="<?php echo $sb_url;?>"><?php echo $user->first_name.' '.$user->last_name; ?></a></td>
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
										<div class="table-container">
											<div class="science-name">
												<div class="science-pic">
													<?php echo '<img src="'. get_usermeta( $single_user_id, $meta_key = '_naiau_user_picture' ) .'" alt="'.$single_user->display_name.'" title="'.$single_user->display_name.'"/>';?>
												</div>
													<div class="science-info-wrapper">
														<ul class="science-info">
															<?php 
																$edu_group = get_usermeta( $single_user_id, $meta_key = '_naiau_user_edu_group' );
																switch($edu_group){
																	case 'electronic':
																		$edu_group = __('Electronic','naiau');
																		break;
																	
																	case 'mechanic':
																		$edu_group = __('Mechanic','naiau');
																		break;
																	
																	case 'building':
																		$edu_group = __('Building','naiau');
																		break;
																	
																	case 'material':
																		$edu_group = __('Material','naiau');
																		break;
																	
																	case 'computer':
																		$edu_group = __('Computer','naiau');
																		break;
																	
																	case 'public':
																		$edu_group = __('Public','naiau');
																		break;
																}
															?>
															<li><?php echo '<strong>'.__('Name and Family : ','naiau').'</strong>'.$single_user->display_name;?></li>
															<li><?php echo '<strong>'.__('Science Degree : ','naiau').'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_degree' );?></li>
															<li><?php echo '<strong>'.__('Educational Group : ','naiau').'</strong>'.$edu_group;?></li>
															<li><?php echo '<strong>'.__('Emails : ','naiau').'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_emails' );?></li>

														</ul>
													</div>
											</div>	
											<?php 
											 		$exps = get_usermeta( $single_user_id, $meta_key = '_naiau_study_exp' ); 
											 		$magazines = get_usermeta( $single_user_id, $meta_key = '_naiau_article_art' ); 
											 		$confs = get_usermeta( $single_user_id, $meta_key = '_naiau_conf_article_art' ); 
											 		$reses = get_usermeta( $single_user_id, $meta_key = '_naiau_res_projects_res' ); 
											 		$books = get_usermeta( $single_user_id, $meta_key = '_naiau_books_books' ); 
											?>
											<div id="tabs" class="science-tabs">
													
													<ul>
														<?php 
														if(!empty($exps)){ ?>
																<li><a href="#study-exp"><?php echo __('Study Experinces','naiau');?></a></li>
														<?php }
														if(!empty($magazines)){ ?>
																<li><a href="#mag-article"><?php echo __('Magazines Articles','naiau');?></a></li>
														<?php }
														if(!empty($confs)){ ?>
																<li><a href="#conf-article"><?php echo __('Conference Articles','naiau');?></a></li>
														<?php }
														if(!empty($reses)){ ?>
																<li><a href="#res-project"><?php echo __('Researchal Projects','naiau');?></a></li>
														<?php }
														if(!empty($books)){ ?>
																	<li><a href="#study-books"><?php echo __('Published Books','naiau');?></a></li>
														<?php } ?>
													</ul>
													
													<?php if(!empty($exps)){ ?>
														<table id="study-exp" class="scientific-board">
															
															<tr>
																<th><?php echo __('Row','naiau'); ?></th>
																<th><?php echo __('Study Degree','naiau'); ?></th>
																<th><?php echo __('Study Course','naiau'); ?></th>
																<th><?php echo __('Study Uni','naiau'); ?></th>
																<th><?php echo __('Study Year','naiau'); ?></th>
															</tr>	
															<?php $counter = 1; 
																foreach($exps as $exp){ ?>
																<tr>
																	<td><?php echo $counter;?></td>
																	<td><?php echo $exp['study_degree'];?></td>
																	<td><?php echo $exp['study_course'];?></td>
																	<td><?php echo $exp['study_uni'];?></td>
																	<td><?php echo $exp['study_year'];?></td>
																</tr>
															<?php  $counter++;

															} ?>
														</table>
													<?php } ?>
												
													<?php if(!empty($magazines)){ ?>
														<table id="mag-article" class="scientific-board">
															<tr>
																<th><?php echo __('Row','naiau'); ?></th>
																<th><?php echo __('Article Title','naiau'); ?></th>
																<th><?php echo __('Publisher','naiau'); ?></th>
																<th><?php echo __('magazine degree','naiau'); ?></th>
																<th><?php echo __('Publish Date','naiau'); ?></th>
															</tr>
															<?php $counter = 1; 
																foreach($magazines as $magazine){ ?>
																<tr>
																	<td><?php echo $counter;?></td>
																	<td><?php echo $magazine['article_title'];?></td>
																	<td><?php echo $magazine['publisher'];?></td>
																	<td><?php echo $magazine['mag_degree'];?></td>
																	<td><?php echo $magazine['publish_date'];?></td>
																</tr>
															<?php  $counter++;

															} ?>
														</table>
													<?php } ?>
												
													<?php if(!empty($confs)){ ?>
														<table id="conf-article" class="scientific-board">
															<tr>
																<th><?php echo __('Row','naiau'); ?></th>
																<th><?php echo __('Article Title','naiau'); ?></th>
																<th><?php echo __('Conference Title','naiau'); ?></th>
																<th><?php echo __('Conference Level','naiau'); ?></th>
																<th><?php echo __('Conference Location','naiau'); ?></th>
																<th><?php echo __('Conference Date','naiau'); ?></th>
															</tr>
															<?php $counter = 1; 
																foreach($confs as $conf){ ?>
																<tr>
																	<td><?php echo $counter;?></td>
																	<td><?php echo $conf['article_title'];?></td>
																	<td><?php echo $conf['conf_title'];?></td>
																	<td><?php echo $conf['conf_level'];?></td>
																	<td><?php echo $conf['Conf_location'];?></td>
																	<td><?php echo $conf['conference_date'];?></td>
																</tr>
															<?php  $counter++;

															} ?>
														</table>
													<?php } ?>
												
													<?php if(!empty($reses)){ ?>
														<table id="res-project" class="scientific-board">
															<tr>
																<th><?php echo __('Row','naiau'); ?></th>
																<th><?php echo __('Project Title','naiau'); ?></th>
																<th><?php echo __('Approval authority','naiau'); ?></th>
																<th><?php echo __('Project Duration','naiau'); ?></th>
																<th><?php echo __('Project status','naiau'); ?></th>
															</tr>
															<?php $counter = 1; 
																foreach($reses as $res){ ?>
																<tr>
																	<td><?php echo $counter;?></td>
																	<td><?php echo $res['project_title'];?></td>
																	<td><?php echo $res['approval_authority'];?></td>
																	<td><?php echo $res['project_duration'];?></td>
																	<td>
																		<?php if($res['project_status'] == 'in_proccess'){
																			echo __('In Proccess','naiau');
																		} elseif($res['project_status'] == 'cleared'){
																			echo __('Cleard','naiau');
																		}?>
																	</td>
																</tr>
															<?php  $counter++;

															} ?>
														</table>
													<?php } ?>
												
													<?php if(!empty($books)){ ?>
														<table id="study-books" class="scientific-board">
															<tr>
																<th><?php echo __('Row','naiau'); ?></th>
																<th><?php echo __('Book Title','naiau'); ?></th>
																<th><?php echo __('Author','naiau'); ?></th>
																<th><?php echo __('translator','naiau'); ?></th>
																<th><?php echo __('Publisher','naiau'); ?></th>
															</tr>
															<?php $counter = 1; 
																foreach($books as $book){ ?>
																<tr>
																	<td><?php echo $counter;?></td>
																	<td><?php echo $book['book_title'];?></td>
																	<td><?php echo $book['author'];?></td>
																	<td><?php echo $book['translator'];?></td>
																	<td><?php echo $book['publisher'];?></td>
																</tr>
															<?php  $counter++;

															} ?>
														</table>
													<?php } ?>
												
											</div> <!-- #tabs.science-tabs -->

											<div class="science-desc">
												<h4><?php echo __('Small Description','naiau');?></h4>
												<?php echo get_usermeta( $single_user_id, $meta_key = '_naiau_user_description' ); ?>
											</div>
											<?php the_content(); ?>
										</div>
									<?php } ?>
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
	          $('#tabs').tabs();
	      });
	    </script>

				
<?php get_footer(); ?>
