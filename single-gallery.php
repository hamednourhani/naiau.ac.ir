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

				
					
					<?php 
					
				$hide_content = get_post_meta(get_the_ID(),'_naiau_content');
				$show_comments = get_post_meta(get_the_ID(),'_naiau_comments');
				$hide_sidebar = get_post_meta(get_the_ID(),'_naiau_sidebar');

				
				?>

				
				<?php get_template_part('library/slider','area'); ?>

				
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
									<div class="gallery-slideshow-wrapper">
										<?php get_template_part('library/gallery','slideshow'); ?>
									</div>
									
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				

				<?php get_template_part('library/notify','tabs'); ?>
				<?php get_template_part('library/footer','links'); ?>
				<?php get_template_part('library/related','links'); ?>

			
		</main>

				
<?php get_footer(); ?>
