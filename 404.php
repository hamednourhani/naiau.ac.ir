<?php get_header(); ?>

				<main id="main" class="site-main cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
					<section class="layout">
						<article id="post-not-found" class="hentry cf">

							<header class="article-header">

								<h1><?php _e( 'Epic 404 - Article Not Found', 'naiau' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The article you were looking for was not found, but maybe try looking again!', 'naiau' ); ?></p>

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

							</section>

							<footer class="article-footer">

									<p><?php _e( 'This is the 404.php template.', 'naiau' ); ?></p>

							</footer>

						</article>
					</section>		
				</main>
				
<?php get_footer(); ?>
