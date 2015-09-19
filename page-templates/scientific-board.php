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
	
if($_GET['science_board']){

	$single_user_id = $_GET['science_board']; 
	$single_user = get_userdata($single_user_id);

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

}
	
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
									<div class="page-content without-sidebar">		
											
									<?php the_content(); ?>	

									<?php if(!empty($users) && $single_user_id == ''){ ?>
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
														 	$current_group = '';
														 	$prev_group = ''; 
													?>

													<?php foreach($users as $user){?>
														<tr>
															<?php 
																$edu_group = get_usermeta( $user->ID, $meta_key = '_naiau_user_edu_group' );
																$current_group = ($edu_group == $prev_group)?('~'):$edu_group; 
																$prev_group = $current_group;
															?>
															<td><?php echo $counter ;?></td>
															<td><a href="<?php echo get_the_permalink().'?science_board='.$user->ID;?>"><?php echo $user->first_name.' '.$user->last_name; ?></a></td>
															<td><?php echo get_usermeta( $user->ID, $meta_key = '_naiau_user_degree' );?></td>
															<td><?php echo $current_group; ?></td>
														
														</tr>
													<?php 
														$counter++;
													} ?>
												</tbody>
											</table>
										</div>
									<?php } elseif($single_user_id !== ''){?>
										<div class="table-container">
											<div class="science-name">
												<div class="science-pic">
													<?php echo '<img src="'. get_usermeta( $single_user_id, $meta_key = '_naiau_user_picture' ) .'" alt="'.$single_user->display_name.'" title="'.$single_user->display_name.'"/>';?>
												</div>
												<ul class="science-info">
													
													<li><?php echo '<strong>'.__('Name and Family : ','naiau').'</strong>'.$single_user->display_name;?></li>
													<li><?php echo '<strong>'.__('Science Degree : ','naiau').'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_degree' );?></li>
													<li><?php echo '<strong>'.__('Educational Group : ','naiau').'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_edu_group' );?></li>
													<li><?php echo '<strong>'.__('Emails : ','naiau').'</strong>'.get_usermeta( $single_user_id, $meta_key = '_naiau_user_emals' );?></li>

												</ul>
											</div>	
											
											<div class="science-study">
												<?php $exps = get_usermeta( $single_user_id, $meta_key = '_naiau_study_exp' ); 
													if(!empty($exps)){ ?>
													<table class="scientific-board">
														<h4><?php echo __('Study Experinces','naiau');?></h4>
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
											</div>

											<div class="science-magazine">
												<?php $magazines = get_usermeta( $single_user_id, $meta_key = '_naiau_article_art' ); 
													if(!empty($magazines)){ ?>
													<table class="scientific-board">
														<h4><?php echo __('Magazines Articles','naiau');?></h4>
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
											</div>

											<div class="science-conference">
												<?php $confs = get_usermeta( $single_user_id, $meta_key = '_naiau_conf_article_art' ); 
													if(!empty($confs)){ ?>
													<table class="scientific-board">
														<h4><?php echo __('Conference Articles','naiau');?></h4>
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
											</div>
											<div class="science-research">
												<?php $reses = get_usermeta( $single_user_id, $meta_key = '_naiau_res_projects_res' ); 
													if(!empty($reses)){ ?>
													<table class="scientific-board">
														<h4><?php echo __('Researchal Projects','naiau');?></h4>
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
																<td><?php echo $res['project_status'];?></td>
															</tr>
														<?php  $counter++;

														} ?>
													</table>
												<?php } ?>
											</div>
											<div class="science-books">
												<?php $books = get_usermeta( $single_user_id, $meta_key = '_naiau_books_books' ); 
													if(!empty($books)){ ?>
													<table class="scientific-board">
														<h4><?php echo __('Published Books','naiau');?></h4>
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
											</div>
											<div class="science-desc">
												<h4><?php echo __('Small Description','naiau');?></h4>
												<?php echo get_usermeta( $single_user_id, $meta_key = '_naiau_user_description' ); ?>
											</div>

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

				
<?php get_footer(); ?>