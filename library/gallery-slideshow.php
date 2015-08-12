<?php

// The Query

	$gallery_images = get_post_meta(get_the_ID(),'_naiau_gallery_metabox');
	var_dump($gallery_images);
	
 ?>

<div id="example3" class="slider-pro gallery-slideshow">
		
		<div class="sp-slides">
			<?php foreach($gallery_images as $gallery_image){}?>
			<div class="sp-slide">
				<img class="sp-image" src="<?php echo get_template_directory_uri();?>/images/blank.gif" 
					data-src="http://bqworks.com/slider-pro/images/image1_medium.jpg"
					data-small="http://bqworks.com/slider-pro/images/image1_small.jpg"
					data-medium="http://bqworks.com/slider-pro/images/image1_medium.jpg"
					data-large="http://bqworks.com/slider-pro/images/image1_large.jpg"
					data-retina="http://bqworks.com/slider-pro/images/image1_large.jpg"/>

				<!-- <p class="sp-layer sp-white sp-padding"
					data-horizontal="50" data-vertical="50"
					data-show-transition="left" data-show-delay="400">
					Lorem ipsum
				</p> -->

				
			</div>

	        
		</div>

		<div class="sp-thumbnails">
			<img class="sp-thumbnail" src="http://bqworks.com/slider-pro/images/image1_thumbnail.jpg"/>
			
		</div>
    </div>

    <script type="text/javascript">
		$( document ).ready(function( $ ) {
			$( '.gallery-slideshow' ).sliderPro({
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