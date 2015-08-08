<?php
/*
 * CUSTOM POST TYPE TAXONOMY TEMPLATE
 *
 * This is the custom post type taxonomy template. If you edit the custom taxonomy name,
 * you've got to change the name of this template to reflect that name change.
 *
 * For Example, if your custom taxonomy is called "register_taxonomy('shoes')",
 * then your template name should be taxonomy-shoes.php
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates#Displaying_Custom_Taxonomies
*/
?>

<?php get_header(); ?>
			<main class="site-main">

				<section class="layout">
						<h1 class="section-title"><?php single_cat_title(); ?></h1>
				</section>

				<section class="layout">



						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" class="archive-tour" role="article">
								<a href="<?php the_permalink() ?>" class="tour-link" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail(); ?>
									<span class="archive-tour-title">
										<?php the_title(); ?>
									</span>
								</a>
						</article>

						<?php endwhile; ?>

								<?php naiau_page_navi(); ?>

						<?php else : ?>

								<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( ' hala hoola Oops, Post Not Found!', 'naiau' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'naiau' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the taxonomy-custom_cat.php template.', 'naiau' ); ?></p>
									</footer>
								</article>

						<?php endif; ?>

					</section>			

			</main>

<?php get_footer(); ?>
