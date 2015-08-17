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

				
					
				<?php  $sub_id = get_query_var( 'sub-id', 1 );  ?>					
				

				
				<?php if($hide_content !=true && have_posts()){ ?>
					 <div class="main-area">
						<?php while(have_posts()) { the_post(); ?>
							<div class="content-area">
							
								<div class="single-page-title">
									<section class="layout">
										<h1><?php the_title(); ?></h1>
									</section>
								</div>
								<div class="page-main">
									<section class="layout">

										
									</section>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				

				
				<?php get_template_part('library/footer','links'); ?>
				

			
		</main>

				
<?php get_footer(); ?>
