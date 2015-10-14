<?php
	
	$show_related = get_post_meta(get_the_ID() , '_naiau_related_links');
	

	// _naiau_link_url
if($show_related == true){

	

	$args = array (
	    'post_type'              => array( 'link' ),
	    'posts_per_page'         => '20',
	        // 'category'         => 'news_cat',
	    'link_cat'    => $links_cat,
	  );

	$related_links = get_posts($args);
	
	if(!empty($related_links)){
?>

<div class="important-links">
	<section class="layout">
		<div class="virtual-border"> 
			<h4 class="related-links"><?php echo __('related sites','naiau'); ?></h4>
		</div>
	</section>
	<section class="layout">
		<div id="owl-carousel" class="owl-carousel owl-theme">
		  <?php
		  		foreach($related_links as $related_link){ 
					  $link = get_post_meta($related_link->ID,'_naiau_link_url');
					  $thumb = get_the_post_thumbnail($related_link->ID,'carousel');
					  
					  ?>
					  <div class="item">
					  		<a href="<?php echo esc_html($link[0]);?>">
					  			<div class="thumb-wrapper">
					  				<?php echo $thumb; ?>
					  			</div>
					  			<span>
					  				<?php// echo $related_link->post_title; ?>
					  			</span>
					  		</a>
					  </div>
		<?php } ?>
		  
		</div>
	</section>
</div>
<script type="text/javascript" async defer>
		jQuery(document).ready(function($) {
 
		  var owl = $("#owl-carousel");
		 
		  owl.owlCarousel({
		      items : 4, //10 items above 1000px browser width
		      itemsDesktop : [1000,4], //5 items between 1000px and 901px
		      itemsDesktopSmall : [900,3], // betweem 900px and 601px
		      itemsTablet: [600,2], //2 items between 600 and 0
		      itemsMobile : [320,1] ,// itemsMobile disabled - inherit from itemsTablet option
		      autoplay : true,
		      autoplayTimeout : 1500,
		      autoplayHoverPause : true,
		      loop : true,
		      responsive:{
			        0:{
			            items:1,
			            //nav:true
			        },
			        400:{
			            items:2,
			            //nav:true
			        },
			        600:{
			            items:3,
			            //nav:true
			        },
			        1000:{
			            items:4,
			            //nav:true,
			            loop:true
			        }
			    }
		  });
		 
		  // Custom Navigation Events
		  
		 
		});
</script>
<?php wp_reset_postdata();

} ?>

<?php } ?>