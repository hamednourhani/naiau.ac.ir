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

				<section class="layout">
					
					<?php 
						
						$tour_airline = get_post_meta( get_the_ID(), '_naiau_tour_airline', true );
						$tour_pick_up = get_post_meta( get_the_ID(), '_naiau_pick_up_time', true );
						$tour_landing = get_post_meta( get_the_ID(), '_naiau_landing_time', true );
					?>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" class="single-tour" role="article">

							<div class="tour-side">
								<header class="tour-header">
									<h3 class="tour-title "><?php the_title(); ?></h3>
								</header>

								<section class="tour-slide">
									<?php the_post_thumbnail(); ?>
								</section>
								
								<footer class="tour-information">
									<h3 class="tour-information-title">
										<?php echo __('Tour Information','naiau')?>
									</h3>
									<ul class="tour-info-list">
										<li>
											<?php echo '<strong>'.__('Airline : ','naiau').'</strong>'.'<span>'.$tour_airline.'</span>'; ?>
										</li>
										<li>
											<?php echo '<strong>'.__('Pickup Time : ','naiau').'</strong>'.'<span>'.$tour_pick_up.'</span>'; ?>
										</li>
										<li>
											<?php echo '<strong>'.__('Landing Time : ','naiau').'</strong>'.'<span>'.$tour_landing.'</span>'; ?>
										</li>
									</ul>
								</footer>

							</div>
							<div class="tour-detail">
								
								<div class="tour-content cf">
									<?php get_template_part("library/tour" , "packages"); ?>
								</div> <!-- end article section -->
								
								<div class="tour-extra">
									<?php the_content(); ?>
								</div>
						
							</div>

						</article>

					<?php endwhile; ?>

					<?php else : ?>

							<article id="post-not-found" class="single-tour cf">
								<header class="tour-header">
									<h1><?php _e( 'Oops, Post Not Found!', 'naiau' ); ?></h1>
								</header>
								<section class="tour-content">
									<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'naiau' ); ?></p>
								</section>
								<footer class="tour-footer">
									<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'naiau' ); ?></p>
								</footer>
							</article>

					<?php endif; ?>

			</main>

				
<?php get_footer(); ?>
