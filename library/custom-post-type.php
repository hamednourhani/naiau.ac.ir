<?php
/* naiau Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/naiau/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'naiau_flush_rewrite_rules' );

// Flush your rewrite rules
function naiau_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function news_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'news', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'News', 'naiau' ), /* This is the Title of the Group */
			'singular_name' => __( 'News', 'naiau' ), /* This is the individual type */
			'all_items' => __( 'All News', 'naiau' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'naiau' ), /* The add new menu item */
			'add_new_item' => __( 'Add New News', 'naiau' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'naiau' ), /* Edit Dialog */
			'edit_item' => __( 'Edit News', 'naiau' ), /* Edit Display Title */
			'new_item' => __( 'New News', 'naiau' ), /* New Display Title */
			'view_item' => __( 'View News', 'naiau' ), /* View Display Title */
			'search_items' => __( 'Search News', 'naiau' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'naiau' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'naiau' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is a News', 'naiau' ), /* Custom Type Description */
			'public' => true,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/images/news-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'news', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'notify', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'category', 'tour' );
	/* this adds your post tags to your custom post type */
	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
	
}


function notify_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'notify', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Notify', 'naiau' ), /* This is the Title of the Group */
			'singular_name' => __( 'Notify', 'naiau' ), /* This is the individual type */
			'all_items' => __( 'All Notifies', 'naiau' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'naiau' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Notify', 'naiau' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'naiau' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Notify', 'naiau' ), /* Edit Display Title */
			'new_item' => __( 'New Notify', 'naiau' ), /* New Display Title */
			'view_item' => __( 'View Notify', 'naiau' ), /* View Display Title */
			'search_items' => __( 'Search Notifies', 'naiau' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'naiau' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'naiau' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is a notify', 'naiau' ), /* Custom Type Description */
			'public' => true,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/images/notify-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'notify', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'notify', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'category', 'tour' );
	/* this adds your post tags to your custom post type */
	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
	
}
function link_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'link', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Link', 'naiau' ), /* This is the Title of the Group */
			'singular_name' => __( 'Link', 'naiau' ), /* This is the individual type */
			'all_items' => __( 'All Links', 'naiau' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'naiau' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Link', 'naiau' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'naiau' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Link', 'naiau' ), /* Edit Display Title */
			'new_item' => __( 'New Link', 'naiau' ), /* New Display Title */
			'view_item' => __( 'View Link', 'naiau' ), /* View Display Title */
			'search_items' => __( 'Search Links', 'naiau' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'naiau' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'naiau' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is a link', 'naiau' ), /* Custom Type Description */
			'public' => true,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/images/link-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'link', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'link', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', /*'editor',*/ 'author', 'thumbnail', /*'excerpt', 'trackbacks',*/ 'custom-fields', /*'comments', 'revisions',*/ 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'category', 'tour' );
	/* this adds your post tags to your custom post type */
	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
	
}
function gallery_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'gallery', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Gallery', 'naiau' ), /* This is the Title of the Group */
			'singular_name' => __( 'Gallery', 'naiau' ), /* This is the individual type */
			'all_items' => __( 'All Galleries', 'naiau' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'naiau' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Gallery', 'naiau' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'naiau' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Gallery', 'naiau' ), /* Edit Display Title */
			'new_item' => __( 'New Gallery', 'naiau' ), /* New Display Title */
			'view_item' => __( 'View Gallery', 'naiau' ), /* View Display Title */
			'search_items' => __( 'Search Galleries', 'naiau' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'naiau' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'naiau' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is a Gallery', 'naiau' ), /* Custom Type Description */
			'public' => true,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/images/gallery-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'gallery', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'gallery', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', /*'trackbacks',*/ 'custom-fields', /*'comments'*/ /*'revisions'*/ 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'category', 'tour' );
	/* this adds your post tags to your custom post type */
	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
	
}
function tab_maker_post_type() { 
// creating (registering) the custom type 
	register_post_type( 'tab', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Tab Maker', 'naiau' ), /* This is the Title of the Group */
			'singular_name' => __( 'Tab Maker', 'naiau' ), /* This is the individual type */
			'all_items' => __( 'All Tab Makers', 'naiau' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'naiau' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Tab Maker', 'naiau' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'naiau' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Tab Maker', 'naiau' ), /* Edit Display Title */
			'new_item' => __( 'New Tab Maker', 'naiau' ), /* New Display Title */
			'view_item' => __( 'View Tab Maker', 'naiau' ), /* View Display Title */
			'search_items' => __( 'Search Tab Makers', 'naiau' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'naiau' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'naiau' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is a tab maker', 'naiau' ), /* Custom Type Description */
			'public' => true,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/images/tab-maker-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'tab_maker', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'tab_maker', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', /*'author', 'thumbnail', 'excerpt', /*'trackbacks'*/ 'custom-fields', /*'comments'*/ /*'revisions'*/ 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'category', 'tour' );
	/* this adds your post tags to your custom post type */
	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'notify_post_type');
	add_action( 'init', 'news_post_type');
	add_action( 'init', 'link_post_type');
	add_action( 'init', 'gallery_post_type');
	add_action( 'init', 'tab_maker_post_type');

	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'news_cat', 
		array('news'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'News Categories', 'naiau' ), /* name of the custom taxonomy */
				'singular_name' => __( 'News Category', 'naiau' ), /* single taxonomy name */
				'search_items' =>  __( 'Search News Categories', 'naiau' ), /* search title for taxomony */
				'all_items' => __( 'All News Categories', 'naiau' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent News Category', 'naiau' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent News Category:', 'naiau' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit News Category', 'naiau' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update News Category', 'naiau' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New News Category', 'naiau' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New News Category Name', 'naiau' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'news-cat' ),
			'show_in_nav_menus' => true,
		)
	);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'news_tag', 
		array('news'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'News Tags', 'naiau' ), /* name of the custom taxonomy */
				'singular_name' => __( 'News Tag', 'naiau' ), /* single taxonomy name */
				'search_items' =>  __( 'Search News Tags', 'naiau' ), /* search title for taxomony */
				'all_items' => __( 'All News Tags', 'naiau' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent News Tag', 'naiau' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent News Tag:', 'naiau' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit News Tag', 'naiau' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update News Tag', 'naiau' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New News Tag', 'naiau' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New News Tag Name', 'naiau' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'show_in_nav_menus' => true,
		)
	);

		/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'notify_cat', 
		array('notify'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Notify Categories', 'naiau' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Notify Category', 'naiau' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Notify Categories', 'naiau' ), /* search title for taxomony */
				'all_items' => __( 'All Notifies Categories', 'naiau' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Notify Category', 'naiau' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Notify Category:', 'naiau' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Notify Category', 'naiau' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Notify Category', 'naiau' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Notify Category', 'naiau' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Notify category Name', 'naiau' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'notify-cat' ),
			'show_in_nav_menus' => true,
		)
	);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'notify_tag', 
		array('news'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Notify Tags', 'naiau' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Notify Tag', 'naiau' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Notify Tags', 'naiau' ), /* search title for taxomony */
				'all_items' => __( 'All Notify Tags', 'naiau' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Notify Tag', 'naiau' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Notify Tag:', 'naiau' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Notify Tag', 'naiau' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Notify Tag', 'naiau' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Notify Tag', 'naiau' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Notify Tag Name', 'naiau' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'show_in_nav_menus' => true,
		)
	);

	register_taxonomy( 'link_cat', 
		array('link'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Link Categories', 'naiau' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Link Category', 'naiau' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Link Categories', 'naiau' ), /* search title for taxomony */
				'all_items' => __( 'All Links Categories', 'naiau' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Link Category', 'naiau' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Link Category:', 'naiau' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Link Category', 'naiau' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Link Category', 'naiau' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Link Category', 'naiau' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Link Category Name', 'naiau' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'link-cat' ),
			'show_in_nav_menus' => true,
		)
	);
	
	// now let's add custom tags (these act like categories)
	
	



	

	
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
