<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

		<div class="body-wrapper">
		<!-- <img src="images/introBack.jpg" class="back-wall"/> -->
			
			<header class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

				<div id="top-bar" class="top-bar cf">
				<section class="layout">
					
					<nav role="navigation" class = "top-bar-menu" itemscope itemtype="http://schema.org/SiteNavigationElement">
						
						<?php wp_nav_menu(array(
    					         'container' => false,                           // remove nav container
    					         'container_class' => 'menu cf',                 // class of container (should you choose to use it)
    					         'menu' => __( 'Top Menu', 'naiau' ),  // nav name
    					         'menu_class' => 'nav top-nav cf',               // adding custom nav class
    					         'theme_location' => 'top-menu',                 // where it's located in the theme
    					         'before' => '',                                 // before the menu
        			               'after' => '',                                  // after the menu
        			               'link_before' => '',                            // before each link
        			               'link_after' => '',                             // after each link
        			               'depth' => 1,                                   // limit the depth of the nav
    					         'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>

					</nav>
					<div class="search-area">
						<!-- <input type="search" class="top-search" placeholder="<?php echo __('Search','naiau'); ?>" /> -->
						<?php get_search_form( true ); ?>
					</div>
				</section>
				</div>

				<div id="menu-bar" class="menu-bar cf">
					<section class="layout">
						<div class="logo-wrapper">
							<a href="<?php echo get_bloginfo('url'); ?>">
								<img src="<?php echo get_template_directory_uri();?>/images/nazarabad-logo.png" />
							</a>
						</div>
						<nav role="navigation" class = "main-menu" itemscope itemtype="http://schema.org/SiteNavigationElement">
							<span class="current-time">
								
								<?php if(function_exists(jdate)){
											echo jdate( ' H:i Y-m-d', current_time( 'timestamp', 0 ) ); 
										} else {
											echo date( ' H:i Y-m-d', current_time( 'timestamp', 1 ) );
										}

									?>
								<i class="fa fa-calendar"></i>
							</span>
							
							<?php wp_nav_menu(array(
	    					         'container' => false,                           // remove nav container
	    					         'container_class' => 'menu cf',                 // class of container (should you choose to use it)
	    					         'menu' => __( 'The Main Menu', 'naiau' ),  // nav name
	    					         'menu_class' => 'nav main-nav cf',               // adding custom nav class
	    					         'theme_location' => 'main-nav',                 // where it's located in the theme
	    					         'before' => '',                                 // before the menu
	        			               'after' => '',                                  // after the menu
	        			               'link_before' => '',                            // before each link
	        			               'link_after' => '',                             // after each link
	        			               'depth' => 3,                                   // limit the depth of the nav
	    					         'fallback_cb' => ''                             // fallback function (if there is one)
							)); ?>

						</nav>
						
					</section>
				</div>

			</header>