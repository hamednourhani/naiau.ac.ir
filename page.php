<?php get_header(); ?>


				<?php 
				$hide_title = get_post_meta(get_the_ID(),'_naiau_title');	
				$hide_content = get_post_meta(get_the_ID(),'_naiau_content');
				$hide_sidebar = get_post_meta(get_the_ID(),'_naiau_sidebar');
				
				?>

				
				<?php get_template_part('library/slider','area'); ?>

				<?php if($hide_title !== true){/*the_title()*/} ?>
				<?php if($hide_content !== true){/*the_content()*/ } ?>
				<?php if($hide_sidebar !== true){/*the_sidebar()*/} ?>

				<?php get_template_part('library/notify','tabs'); ?>
				<?php get_template_part('library/footer','links'); ?>
				<?php get_template_part('library/related','links'); ?>
				

		
		
<?php get_footer(); ?>
