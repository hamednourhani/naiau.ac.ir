<?php
/*
Author: Eddie Machado
URL: http://themble.com/naiau/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/
// define( 'WPCF7_ADMIN_READ_CAPABILITY', 'manage_options' );
// define( 'WPCF7_ADMIN_READ_WRITE_CAPABILITY', 'manage_options' );
// LOAD naiau CORE (if you remove this, the theme will break)
require_once( 'library/naiau.php' );

//Include and setup custom metaboxes and fields.
if( !class_exists("CMB2") ){
    require_once( dirname(__FILE__)."/library/cmb/init.php" );
}
require_once( 'library/cmb-functions.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
 //require_once( 'library/admin.php' );

/*********************
LAUNCH naiau
Let's get everything up and running.
*********************/

function naiau_ahoy() {

  //Allow editor style.
  //add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'naiau', get_template_directory() . '/languages' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'naiau_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'naiau_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'naiau_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'naiau_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'naiau_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'naiau_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  naiau_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'naiau_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'naiau_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'naiau_excerpt_more' );



} /* end naiau ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'naiau_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'slider', 1120, 400, array( 'center', 'center' ) );
add_image_size( 'gallery-slide', 960, 500, array( 'center', 'center' ) );
add_image_size( 'slider-thumb', 100, 80, array( 'center', 'center' ) );
add_image_size( 'carousel', 320, 120, false );

add_filter( 'image_size_names_choose', 'naiau_custom_sizes' );
 
function naiau_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'slider' => __( 'Slider Size' ),
        'slider-thumb' => __( 'Slider Thumb' ),
    ) );
}

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'naiau-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'naiau-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'naiau_custom_image_sizes' );

function naiau_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'slider' => __('1120px by 400px'),
        'gallery-slide' => __('960px by 500px'),
        'slider-thumb' => __('100px by 80px'),
        'carousel' => __('320px by 120px'),
    ) );
}


/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function naiau_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'naiau_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function naiau_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar',
		'name' => __( 'Sidebar', 'naiau' ),
		'description' => __( 'The first (primary) sidebar.', 'naiau' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
  register_sidebar(array(
    'id' => 'notify-sidebar',
    'name' => __( 'Notify Sidebar', 'naiau' ),
    'description' => __( 'The Notify sidebar.', 'naiau' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'naiau' ),
		'description' => __( 'The second (secondary) sidebar.', 'naiau' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function naiau_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'naiau' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'naiau' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'naiau' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'naiau' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


function naiau_pagination(){
  global $wp_query;
      
      $big = 999999999; 
      echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'prev_text'    => __('<i class="fa fa-angle-double-right"></i>','naiau'),
        'next_text'    => __('<i class="fa fa-angle-double-left"></i>','naiau')
      ) );
}


function naiau_SearchFilter($query) {
    if ($query->is_search) {
      $query->set('post_type', array('post','news','notify'));
    }
    return $query;
    }

add_filter('pre_get_posts','naiau_SearchFilter');

function naiau_add_query_vars_filter( $vars ){
  $vars[] = "sub_id";
  return $vars;
}
add_filter( 'query_vars', 'naiau_add_query_vars_filter' );

// add_filter( 'the_content', 'naiau_remove_br_gallery', 11, 2);
// function naiau_remove_br_gallery($output) {
//     return preg_replace('/<br style=(.*)>/mi','',$output);
// }
/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function naiau_fonts() {
  wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

//add_action('wp_enqueue_scripts', 'naiau_fonts');

// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form'
	) );



/* DON'T DELETE THIS CLOSING TAG */ 
/*---------------Widgets----------------------*/

// Creating the widget 
class last_notify_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'last_notify_widget', 

        // Widget name will appear in UI
        __('Last Notify Widget', 'naiau'), 

        // Widget description
        array( 'description' => __( 'Display Last Notifies', 'naiau' ), ) 
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $number = $instance['number'];

        $notifies = get_posts(array(
            'post_type' => 'notify',
            'posts_per_page' => $number,
            )
        );
        //var_dump($notifies);
        $content = '<ul>';
        foreach($notifies as $notify) : setup_postdata( $notify );
          $url = get_the_permalink($notify->ID);
          $name = $notify->post_title;
          $content .='<li><i class="fa fa-bullhorn"></i><a href="'.$url.'">'.$name.'</a><li>';
        endforeach;
        $content .= '</ul>';

      
       

        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'New title', 'naiau' );
        }
        if ( isset( $instance[ 'number' ] ) ) {
            $number = $instance[ 'number' ];
        }else {
            $number = 5;
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Notify Numbers :','naiau' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <?php 
    }
      
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here



class last_news_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'last_news_widget', 

        // Widget name will appear in UI
        __('Last News Widget', 'naiau'), 

        // Widget description
        array( 'description' => __( 'Display Last News', 'naiau' ), ) 
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $number = $instance['number'];

        $news_list = get_posts(array(
            'post_type' => 'news',
            'posts_per_page' => $number,
            )
        );
        //var_dump($notifies);
        $content = '<ul>';
        foreach($news_list as $news) : setup_postdata( $news );
          $url = get_the_permalink($news->ID);
          $name = $news->post_title;
          $content .='<li><i class="fa fa-newspaper-o"></i><a href="'.$url.'">'.$name.'</a><li>';
        endforeach;
        $content .= '</ul>';

      
       

        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'New title', 'naiau' );
        }
        if ( isset( $instance[ 'number' ] ) ) {
            $number = $instance[ 'number' ];
        }else {
            $number = 5;
        }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'News Numbers :','naiau' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <?php 
    }
      
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
    return $instance;
    }
} // Class wpb_widget ends here


// Register and load the widget
function naiau_widget() {
  register_widget( 'last_notify_widget' );
  register_widget( 'last_news_widget' );
}
add_action( 'widgets_init', 'naiau_widget' );


function naiau_is_tree($pid) {      // $pid = The ID of the page we're looking for pages underneath
  global $post;         // load details about this page
  if(is_page()&&($post->post_parent==$pid||is_page($pid))) 
               return true;   // we're at the page or at a sub page
  else 
               return false;  // we're elsewhere
};

function naiau_search_form( $form ) {
  $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
  <div><input type="text" value="' . get_search_query() . '" placeholder="'.__('Search','naiau').'" name="s" id="s" />
  <button type="submit" id="searchsubmit" />'.__('Search','naiau').'</button>
  </div>
  </form>';

  return $form;
}

add_filter( 'get_search_form', 'naiau_search_form' );



/*-----------------user roles config functions -----------------------*/
/*-----------------user roles config functions -----------------------*/
/*-----------------user roles config functions -----------------------*/


function naiau_add_user_roles(){
remove_role('sciene_board');
remove_role('scientific_board');

$role = add_role( 'scienes_board', __(
'Scienes Board','naiau' ),
array(


      'read' => true, // true allows this capability
      'edit_posts' => true, // Allows user to edit their own posts
      'edit_pages' => false, // Allows user to edit pages
      'edit_others_posts' => false, // Allows user to edit others posts not just their own
      'create_posts' => true, // Allows user to create new posts
      'manage_categories' => false, // Allows user to manage post categories
      'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
      'edit_themes' => false, // false denies this capability. User can’t edit your theme
      'install_plugins' => false, // User cant add new plugins
      'update_plugin' => false, // User can’t update any plugins
      'update_core' => false, // user cant perform core updates
      'upload_files' => true,
      'moderate_comments' => false,


 ) );
   
}
// let's get this party started
add_action( 'after_setup_theme', 'naiau_add_user_roles',11 );

add_action('admin_init','naiau_add_role_caps',999);
    function naiau_add_role_caps() {

    // Add the roles you'd like to administer the custom post types
    $roles = array('editor','administrator');
    
    // Loop through each role and assign capabilities
    foreach($roles as $the_role) { 

         $role = get_role($the_role);

      
               $role->add_cap( 'read' );
               $role->add_cap( 'read_admin_post');
               $role->add_cap( 'read_admin_posts' );
               $role->add_cap( 'edit_admin_post' );
               $role->add_cap( 'edit_admin_posts' );
               $role->add_cap( 'edit_others_admin_posts' );
               $role->add_cap( 'edit_published_admin_posts' );
               $role->add_cap( 'publish_admin_posts' );
               $role->add_cap( 'delete_others_admin_posts' );
               $role->add_cap( 'delete_private_admin_posts' );
               $role->add_cap( 'delete_published_admin_posts' );
    
    }
}

add_action( 'admin_init', 'naiau_remove_menu_pages',999 );
function naiau_remove_menu_pages() {

    global $user_ID,$wp_roles;
    
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    $role = array_shift($roles);

    
    

    if ( $role == "administrator" || $role == 'editor') {
      //some code
    } else {

   
      
      // remove_menu_page('upload.php'); // Media
      remove_menu_page('link-manager.php'); // Links
      remove_menu_page('edit-comments.php'); // Comments
      // remove_menu_page('edit.php?post_type=page'); // Pages
      remove_menu_page('plugins.php'); // Plugins
      remove_menu_page('themes.php'); // Appearance
      // remove_menu_page('users.php'); // Users
      remove_menu_page('tools.php'); // Tools
      remove_menu_page('options-general.php'); // Settings   
      remove_menu_page('admin.php?page=wpcf7'); // contact form  
      remove_menu_page('upload.php'); // Settings 
      remove_menu_page( 'wpcf7' );
    }
}

