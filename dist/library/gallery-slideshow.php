<?php

// The Query

	$gallery_images = get_post_meta(get_the_ID(),'_naiau_image_list');
	
	
 ?>

<div id="gallery-slideshow" class="slider-pro gallery-slideshow">
		
		<div class="sp-slides">
			<?php foreach($gallery_images[0] as $gallery_image){?>
				<div class="sp-slide">
					<img class="sp-image" src="<?php echo get_template_directory_uri();?>/images/blank.gif" 
						data-src="<?php echo $gallery_image; ?>"/>
				
				</div>
			<?php } ?>

	        
		</div>

		<div class="sp-thumbnails">
			<?php foreach($gallery_images[0] as $gallery_image){?>
				<img class="sp-thumbnail" src="<?php echo $gallery_image; ?>"/>
			<?php } ?>
		</div>
    </div>

    <script type="text/javascript">
		jQuery( document ).ready(function( $ ) {
			$( '#gallery-slideshow' ).sliderPro({
				width: 960,
				height: 500,
				fade: true,
				arrows: true,
				buttons: false,
				fullScreen: true,
				shuffle: true,
				smallSize: 500,
				mediumSize: 1000,
				largeSize: 3000,
				thumbnailArrows: true,
				autoplay: false
			});
		});
	</script>