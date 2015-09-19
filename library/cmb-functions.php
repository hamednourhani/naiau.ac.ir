<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the naiau directory)
 *
 * Be sure to replace all instances of 'naiau_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_naiau
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/naiau
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}


function ed_metabox_include_front_page( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'] ) ) {
        return $display;
    }

    if ( 'front-page' !== $meta_box['show_on']['key'] ) {
        return $display;
    }

    $post_id = 0;

    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }

    if ( ! $post_id ) {
        return !$display;
    }

    // Get ID of page set as front page, 0 if there isn't one
    $front_page = get_option( 'page_on_front' );

    // there is a front page set and we're on it!
    return $post_id == $front_page;
}
//add_filter( 'cmb2_show_on', 'ed_metabox_include_front_page', 10, 2 );
/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' naiau_box parameter
 *
 * @param  naiau object $cmb naiau object
 *
 * @return bool             True if metabox should show
 */
function naiau_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  naiau_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function naiau_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  naiau_Field object $field      Field object
 */
function naiau_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}



/******************************************************************/
/*------------Mother Page and Sub page Maker----------------------*/
/******************************************************************/

 add_action( 'cmb2_init', 'naiau_page_has_content_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function naiau_page_has_content_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'sub_mother',
		'title'         => __( 'Page has Content', 'naiau' ),
		'object_types'  => array( 'page' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );


	
	$cmb_demo->add_field( array(
		'name'         => __( 'Page Contnet', 'naiau' ),
		'desc'         => __( 'does page has Content or show the first subpage content?', 'naiau' ),
		'id'           => $prefix . 'sub_mother_page',
		'type'         => 'radio_inline',
		'options'	   => array(
			'has_content'	=> __('Page has Content','naiau'),
			'show_first_subpage'		=> __('Show first SubPage','naiau'),
			'redirect_to'   => __('Redirect to Other Page','naiau'),
			
			),
		'default' => 'show_first_subpage',
	) );

	$cmb_demo->add_field( array(
		'name'         => __( 'Redirect To Page', 'naiau' ),
		'desc'         => __( 'enter the page url', 'naiau' ),
		'id'           => $prefix . 'redirect_to',
		'type'         => 'text_url',
		
	) );
	

}


add_action( 'cmb2_init', 'naiau_select_subpage_metabox' );
function naiau_select_subpage_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_group_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'sub',
		'title'        => __( 'Sub Pages Layout', 'naiau' ),
		'object_types' => array( 'page'),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'sub_pages',
		'type'        => 'group',
		'description' => __( 'Layout sub pages', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'sub page {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add sub page', 'naiau' ),
			'remove_button' => __( 'Remove sub page', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	
	
	
 	

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'List Name', 'naiau' ),
		'desc'    => __( 'The name of sub page in List ', 'naiau' ),
		'id'      => 'list_name',
		'type'    => 'text',
		
			
	) );

	
	
	
		$post_id = ($_GET['post'])?($_GET['post']):"";
	
	$args = array(
	    'child_of'     => $post_id,
	    'sort_order'   => 'ASC',
	    'sort_column'  => 'post_title',
	    'post_type' => 'page',
		'post_status' => 'publish',
		'hierarchical' => 1,
		'parent' => $post_id,
	);

	 $sub_pages_list = get_pages($args);

	 $sub_array = array();
	 $sub_array['none'] = '--';
	foreach ( $sub_pages_list as $page ) : setup_postdata( $page );
			$sub_array[$page->ID] = $page->post_title;
 	endforeach; 




	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Sub Page', 'naiau' ),
		'desc'    => __( 'Select The sub page', 'naiau' ),
		'id'      => 'sub_id',
		'type'    => 'select',
		'options' =>  $sub_array,
		'default' => 'none',
			
	) );


	
}


add_action( 'cmb2_init', 'naiau_select_related_pages_metabox' );
function naiau_select_related_pages_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_group_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'related',
		'title'        => __( 'Related Pages Layout', 'naiau' ),
		'object_types' => array( 'page'),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'related_pages',
		'type'        => 'group',
		'description' => __( 'Layout Related pages', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Related page {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Related page', 'naiau' ),
			'remove_button' => __( 'Remove Related page', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	
	
	
 	

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'List Name', 'naiau' ),
		'desc'    => __( 'The name of Related page in List ', 'naiau' ),
		'id'      => 'list_name',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Link Type', 'naiau' ),
		'desc'    => __( 'is this a page or a link ', 'naiau' ),
		'id'      => 'link_or_page',
		'type'    => 'radio_inline',
		'options' => array(
			'link' =>__('Link','naiau'),
			'page' => __('page','naiau'),
			),
		'default' => 'page'
					
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Link url', 'naiau' ),
		'desc'    => __( 'Enter the link url ', 'naiau' ),
		'id'      => 'link_url',
		'type'    => 'text_url',
		
					
	) );

	
    
		$post_id = ($_GET['post'])?($_GET['post']):"";
		
	// global $post;
	// $post_id = $post->ID;
	
	$args = array(
	    'child_of'     => $post_id,
	    'sort_order'   => 'ASC',
	    'sort_column'  => 'post_title',
	    'post_type' => 'page',
		'post_status' => 'publish',
		'hierarchical' => 1,
		'parent' => $post_id,
	);

	 $sub_pages_list = get_pages($args);

	 $sub_array = array();
	 $sub_array['none'] = '--';
	foreach ( $sub_pages_list as $page ) : setup_postdata( $page );
			$sub_array[$page->ID] = $page->post_title;
 	endforeach; 




	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Related Page', 'naiau' ),
		'desc'    => __( 'Select The Related page', 'naiau' ),
		'id'      => 'sub_id',
		'type'    => 'select',
		'options' =>  $sub_array,
		'default' => 'none',
			
	) );

	}

/******************************************************************/
/*--------------------Link Page-----------------------------------*/
/******************************************************************/

add_action('cmb2_init','naiau_register_link_metabox');
// add_action('cmb2_init','naiau_register_tour_information_metabox');
function naiau_register_link_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'link_metabox',
		'title'         => __( 'Link Information', 'naiau' ),
		'object_types'  => array( 'link' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'link address', 'naiau' ),
		'desc'       => __( 'the web address of link', 'naiau' ),
		'id'         => $prefix . 'link_url',
		'type'       => 'text_url',
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	
}


/******************************************************************/
/*--------------------Link Page-----------------------------------*/
/******************************************************************/

add_action('cmb2_init','naiau_register_download_metabox');
// add_action('cmb2_init','naiau_register_tour_information_metabox');
function naiau_register_download_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'download_metabox',
		'title'         => __( 'Download Information', 'naiau' ),
		'object_types'  => array( 'download' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'download file address', 'naiau' ),
		'desc'       => __( 'the web address of download', 'naiau' ),
		'id'         => $prefix . 'download_url',
		'type'       => 'text_url',
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	
}


/******************************************************************/
/*--------------------Gallery Page-----------------------------------*/
/******************************************************************/


 add_action( 'cmb2_init', 'naiau_register_gallery_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function naiau_register_gallery_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'gallery_metabox',
		'title'         => __( 'Gallery Images', 'naiau' ),
		'object_types'  => array( 'gallery' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );


	
	$cmb_demo->add_field( array(
		'name'         => __( 'Images', 'naiau' ),
		'desc'         => __( 'Upload or add multiple images/attachments.', 'naiau' ),
		'id'           => $prefix . 'image_list',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	

}

/******************************************************************/
/*--------------------Tab Maker Page-------------------------------*/
/******************************************************************/
 add_action( 'cmb2_init', 'naiau_register_tab_maker_metabox' );
function naiau_register_tab_maker_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_group_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'tab_metabox',
		'title'        => __( 'Tabs', 'naiau' ),
		'object_types' => array( 'tab', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix.'tab',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Sub Tab {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Sub Tab', 'naiau' ),
			'remove_button' => __( 'Remove Sub Tab', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	// WP_Query arguments
	
	
	$sub_tabs = get_posts(array(
			'post_type' => 'sub_tab',
			// 'posts_per_page' => -1,
			)
	);
	

	
	$sub_array = array();
	foreach ( $sub_tabs as $sub_tab ) : setup_postdata( $sub_tab );
			$sub_array[$sub_tab->ID] = $sub_tab->post_title;
 	endforeach; 
 	//wp_reset_postdata();
	
	// $cmb_group->add_group_field( $group_field_id, array(
	// 	'name'        => __( 'Tab Title', 'naiau' ),
	// 	'description' => __( 'Enter Tab Title', 'naiau' ),
	// 	'id'          => 'tab_title',
	// 	'type'        => 'text',
	// ) );

	
 	
 	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Sub Tab Name', 'naiau' ),
		'desc'    => __( 'write the sub tab name ', 'naiau' ),
		'id'      => 'tab_name',
		'type'    => 'text',
		
			
	) );
	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Choose a sub Tab ', 'naiau' ),
		'desc'    => __( 'Choose a  the sub tab from list ', 'naiau' ),
		'id'      => 'tab_id',
		'type'    => 'select',
		'options' => $sub_array,
			
	) );
	
	
}
/******************************************************************/
/*--------------------Section Maker-------------------------------*/
/******************************************************************/

add_action('cmb2_init','naiau_register_section_maker_metabox');
// add_action('cmb2_init','naiau_register_tour_information_metabox');
function naiau_register_section_maker_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'section_maker_metabox',
		'title'         => __( 'Section Selection', 'naiau' ),
		'object_types'  => array( 'post','page','news' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	

	$cmb_demo->add_field( array(
		'name'       => __( 'news slider', 'naiau' ),
		'desc'       => __( 'show news slider', 'naiau' ),
		'id'         => $prefix . 'slider_show',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			
		),	
		
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$news_array = array();
	$news_array['none'] = "---";
	$news_cats = get_terms('news_cat');
	if(count($news_cats)>0){
		foreach($news_cats as $news_cat){
				$news_array[$news_cat->term_id] = $news_cat->name;
		}
	}
	$cmb_demo->add_field( array(
		'name'       => __( 'News Category', 'naiau' ),
		'desc'       => __( 'which news category?', 'naiau' ),
		'id'         => $prefix . 'news_cat',
		'type'       => 'select',
		'options'          => $news_array,
	));

	
	$cmb_demo->add_field( array(
		'name'       => __( 'hide content', 'naiau' ),
		'desc'       => __( 'hide page content', 'naiau' ),
		'id'         => $prefix . 'content',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			
			
			
			
		),
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'show comments', 'naiau' ),
		'desc'       => __( 'show  page coments', 'naiau' ),
		'id'         => $prefix . 'comments',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			
			
			
			
		),
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	





	// var_dump($news_cats);
	$cmb_demo->add_field( array(
		'name'       => __( 'hide sidebar', 'naiau' ),
		'desc'       => __( 'hide page sidebar', 'naiau' ),
		'id'         => $prefix . 'sidebar',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			
			
			
			
		),
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'show tabs', 'naiau' ),
		'desc'       => __( 'show tabs or not', 'naiau' ),
		'id'         => $prefix . 'show_tabs',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
		),
	) );

	
	$tabs_list = get_posts(array(
			'post_type' => 'tab',
			'posts_per_page' => '100',
			)
	);
	

	
	$tab_array = array();
	foreach ( $tabs_list as $tab ) : setup_postdata( $tab );
			$tab_array[$tab->ID] = $tab->post_title;
 	endforeach; 


	$cmb_demo->add_field( array(
		'name'       => __( 'tabs category', 'naiau' ),
		'desc'       => __( 'which tab category?', 'naiau' ),
		'id'         => $prefix . 'tab_id',
		'type'       => 'select',
		'options'          => $tab_array,

		
	));
	

	$cmb_demo->add_field( array(
		'name'       => __( 'show related links', 'naiau' ),
		'desc'       => __( 'show related links or not', 'naiau' ),
		'id'         => $prefix . 'related_links',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			
			
			
		),
		
	) );

	$link_array = array();
	$link_array['none'] = "---";
	$link_cats = get_terms('link_cat');
	if(count($link_cats)>0){
		foreach($link_cats as $link_cat){
				$link_array[$link_cat->term_id] = $link_cat->name;
		}
	}
	$cmb_demo->add_field( array(
		'name'       => __( 'Links Category', 'naiau' ),
		'desc'       => __( 'which Link category?', 'naiau' ),
		'id'         => $prefix . 'links_cat',
		'type'       => 'select',
		'options'          => $link_array,
	));

	
}

/******************************************************************/
/*--------------------Tab Maker Page-------------------------------*/
/******************************************************************/
 add_action( 'cmb2_init', 'naiau_register_management_maker_metabox' );
function naiau_register_management_maker_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_group_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'management_metabox',
		'title'        => __( 'Pages', 'naiau' ),
		'object_types' => array( 'management', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'sub_page',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Page {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Page', 'naiau' ),
			'remove_button' => __( 'Remove Page', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	
	
	$pages = get_posts(array(
			'post_type' => 'sub_management',
			'posts_per_page' => '100',
			)
	);
	

	
	$sub_array = array();
	foreach ( $pages as $page ) : setup_postdata( $page );
			$sub_array[$page->ID] = $page->post_title;
 	endforeach; 
 	

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Page Name', 'naiau' ),
		'desc'    => __( 'The name of Sub Page ', 'naiau' ),
		'id'      => 'sub_name',
		'type'    => 'text',
		
			
	) );

	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Page', 'naiau' ),
		'desc'    => __( 'choose a sub page ', 'naiau' ),
		'id'      => 'sub_id',
		'type'    => 'select',
		'options' => $sub_array,
			
	) );
	
	
}




 add_action( 'cmb2_init', 'naiau_register_education_maker_metabox' );
function naiau_register_education_maker_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_group_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'education_metabox',
		'title'        => __( 'Pages', 'naiau' ),
		'object_types' => array( 'education', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'sub_page',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Page {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Page', 'naiau' ),
			'remove_button' => __( 'Remove Page', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

		
	
	$pages = get_posts(array(
			'post_type' => 'sub_education',
			'posts_per_page' => '100',
			)
	);
	

	
	$sub_array = array();
	foreach ( $pages as $page ) : setup_postdata( $page );
			$sub_array[$page->ID] = $page->post_title;
 	endforeach; 
 	//wp_reset_postdata();
	
	

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Page Name', 'naiau' ),
		'desc'    => __( 'The name of Sub Page ', 'naiau' ),
		'id'      => 'sub_name',
		'type'    => 'text',
		
			
	) );

	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Page', 'naiau' ),
		'desc'    => __( 'choose a sub page ', 'naiau' ),
		'id'      => 'sub_id',
		'type'    => 'select',
		'options' => $sub_array,
			
	) );
	
	
}

add_action( 'cmb2_init', 'naiau_register_related_widget_metabox' );
function naiau_register_related_widget_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_group_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'related_widget',
		'title'        => __( 'Related Links', 'naiau' ),
		'object_types' => array( 'management','education' ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'related_links',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Link {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Link', 'naiau' ),
			'remove_button' => __( 'Remove Link', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	
	
	
 	

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Link Name', 'naiau' ),
		'desc'    => __( 'The name of related link ', 'naiau' ),
		'id'      => 'link_name',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Link Url', 'naiau' ),
		'desc'    => __( 'The Url of Link ', 'naiau' ),
		'id'      => 'link_url',
		'type'    => 'text_url',
		
			
	) );
}
/******************************************************************/
/*--------------------Scientifc Board user Profile ----------------*/
/******************************************************************/
global $user_ID,$pagenow;

$current_user_id = get_current_user_id();


// if ( $role == "administrator" || $role == 'editor' || $role == 'sciences_board') {
// 	add_action('cmb2_init','naiau_science_article_metabox');
// }
// =======
if($pagenow == 'profile.php' || $pagenow == 'user-edit.php'){


	if (isset($_GET['user_id']) && is_user_logged_in()){
		
		$userProfile = get_userdata( $_GET['user_id']);
		$roles = $userProfile->roles;
		$current_role = array_shift($roles);

	}elseif(isset($current_user_id) && is_user_logged_in()){
		$userProfile = get_userdata($current_user_id);
		$roles = $userProfile->roles;
		$current_role = array_shift($roles);


	}
	if (isset($current_role) &&  ($current_role == 'scientific_board' || $current_role == 'administrator') ) {
			add_action('cmb2_init','naiau_science_extra_info_metabox');
			add_action('cmb2_init','naiau_science_study_metabox');
			add_action('cmb2_init','naiau_science_articles_metabox');
			add_action('cmb2_init','naiau_science_conf_articles_metabox');
			add_action('cmb2_init','naiau_science_research_projects_metabox');
			add_action('cmb2_init','naiau_science_books_metabox');
		}
}

function naiau_science_extra_info_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_user_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'section_maker_metabox',
		'title'         => __( 'Section Selection', 'naiau' ),
		'object_types'  => array( 'user' ), // Post type
		'new_user_section' => 'add-exiting-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
		
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Profile Picture', 'naiau' ),
		'desc'       => __( 'Upload profile picture or enter the url', 'naiau' ),
		'id'         => $prefix . 'picture',
		'type'       => 'file',
		
		)
		
	);
	$cmb_demo->add_field( array(
		'name'       => __( 'Science Degree', 'naiau' ),
		'desc'       => __( 'enter the science degree ', 'naiau' ),
		'id'         => $prefix . 'degree',
		'type'       => 'text',
		
		)
		
	);

	$cmb_demo->add_field( array(
		'name'       => __( 'Educational Group', 'naiau' ),
		'desc'       => __( 'select educational group ', 'naiau' ),
		'id'         => $prefix . 'edu_group',
		'type'       => 'select',
		'options'    => array(

								'electronic' => __('Electronic','naiau'),
								'mechanic' => __('Mechanic','naiau'),
								'building' => __('Building','naiau'),
								'material' => __('Material','naiau'),
								'computer' => __('Computer','naiau'),
								'public' => __('Public','naiau'),
			),
		
		)
		
	 );
	
	$cmb_demo->add_field( array(
		'name'       => __( 'Emails', 'naiau' ),
		'desc'       => __( 'enter the Email Addresses sepeprate with comma eg. info@gmail.com , info@yahoo.com ', 'naiau' ),
		'id'         => $prefix . 'emails',
		'type'       => 'text',
		
		)
		
	 );
	
	$cmb_demo->add_field( array(
		'name'       => __( 'Description', 'naiau' ),
		'desc'       => __( 'Enter Description', 'naiau' ),
		'id'         => $prefix . 'description',
		'type' => 'wysiwyg',
	    'options' => array(
	        // 'wpautop' => true, // use wpautop?
	        // 'media_buttons' => true, // show insert/upload button(s)
	        // 'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
	        // 'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
	        // 'tabindex' => '',
	        // 'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
	        // 'editor_class' => '', // add extra class(es) to the editor textarea
	        // 'teeny' => false, // output the minimal editor config used in Press This
	        // 'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
	        // 'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
	        // 'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()  
	    )
	));

	
}

function naiau_science_study_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_study_';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'main',
		'title'        => __( 'Study Experinces', 'naiau' ),
		'object_types' => array( 'user' ),
		'new_user_section' => 'add-exiting-user', // where form will show on new user page. 'add-existing-user' is only other valid option.

	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'exp',
		'type'        => 'group',
		'description' => __( 'Layout study experiences', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'experince {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another experince', 'naiau' ),
			'remove_button' => __( 'Remove Experince', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Study Degree', 'naiau' ),
		'desc'    => __( 'enter the study degree ', 'naiau' ),
		'id'      => 'study_degree',
		'type'    => 'text',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'study Course', 'naiau' ),
		'desc'    => __( 'enter the study course ', 'naiau' ),
		'id'      => 'study_course',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Study University', 'naiau' ),
		'desc'    => __( 'enter the study university ', 'naiau' ),
		'id'      => 'study_uni',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Study year', 'naiau' ),
		'desc'    => __( 'enter the jalali study year eg. : 1390', 'naiau' ),
		'id'      => 'study_year',
		'type'    => 'text',
		
			
	) );

}

function naiau_science_articles_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_article_';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'main',
		'title'        => __( 'Magazine Articles', 'naiau' ),
		'object_types' => array( 'user' ),
		'new_user_section' => 'add-exiting-user', // where form will show on new user page. 'add-existing-user' is only other valid option.

	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'art',
		'type'        => 'group',
		'description' => __( 'Layout Magazine Articles', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'article {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another article', 'naiau' ),
			'remove_button' => __( 'Remove article', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Article Title', 'naiau' ),
		'desc'    => __( 'enter the Article Title ', 'naiau' ),
		'id'      => 'article_title',
		'type'    => 'textarea',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Publisher', 'naiau' ),
		'desc'    => __( 'enter the Publisher Name ', 'naiau' ),
		'id'      => 'publisher',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'magazine degree', 'naiau' ),
		'desc'    => __( 'enter the magazine degree ', 'naiau' ),
		'id'      => 'mag_degree',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Publish Date', 'naiau' ),
		'desc'    => __( 'enter the publish date ', 'naiau' ),
		'id'      => 'publish_date',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Jalali Publish year', 'naiau' ),
		'desc'    => __( 'enter the jalali publish year eg. : 1390', 'naiau' ),
		'id'      => 'jalali_publish_year',
		'type'    => 'text',
		
			
	) );

}
	
function naiau_science_conf_articles_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_conf_article_';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'main',
		'title'        => __( 'Conferences Articles', 'naiau' ),
		'object_types' => array( 'user' ),
		'new_user_section' => 'add-exiting-user', // where form will show on new user page. 'add-existing-user' is only other valid option.

	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'art',
		'type'        => 'group',
		'description' => __( 'Layout Conference Articles', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'article {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another article', 'naiau' ),
			'remove_button' => __( 'Remove article', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Article Title', 'naiau' ),
		'desc'    => __( 'enter the Article Title ', 'naiau' ),
		'id'      => 'article_title',
		'type'    => 'textarea',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Conference Title', 'naiau' ),
		'desc'    => __( 'enter the Conference Title ', 'naiau' ),
		'id'      => 'conf_title',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Conference Level', 'naiau' ),
		'desc'    => __( 'enter the Conference Level ', 'naiau' ),
		'id'      => 'conf_level',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Conference Location', 'naiau' ),
		'desc'    => __( 'enter the Conference Location ', 'naiau' ),
		'id'      => 'conf_location',
		'type'    => 'text',
		
			
	) );
	

	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Conference Date', 'naiau' ),
		'desc'    => __( 'enter the Conference date ', 'naiau' ),
		'id'      => 'conference_date',
		'type'    => 'text',
		
			
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Conference Jalali Year', 'naiau' ),
		'desc'    => __( 'enter the jalali Conference year eg. : 1390 ', 'naiau' ),
		'id'      => 'conference_year',
		'type'    => 'text',
		
			
	) );

}	

function naiau_science_research_projects_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_res_projects_';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'main',
		'title'        => __( 'Research Projects', 'naiau' ),
		'object_types' => array( 'user' ),
		'new_user_section' => 'add-exiting-user', // where form will show on new user page. 'add-existing-user' is only other valid option.

	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'res',
		'type'        => 'group',
		'description' => __( 'Layout Projects', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'project {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another project', 'naiau' ),
			'remove_button' => __( 'Remove project', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Project Title', 'naiau' ),
		'desc'    => __( 'enter the project Title ', 'naiau' ),
		'id'      => 'project_title',
		'type'    => 'textarea',
		
			
	) );
	

	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Approval authority', 'naiau' ),
		'desc'    => __( 'enter the Approval authority', 'naiau' ),
		'id'      => 'approval_authority',
		'type'    => 'text',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Naiau project', 'naiau' ),
		'desc'    => __( 'is naiau approved this project?', 'naiau' ),
		'id'      => 'naiau_project',
		'type'    => 'radio_inline',
		'options' => array(
							'no' => __('No','naiau'),
							'yes' => __('Yes','naiau'),
			),
		'default' => 'no',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Project Duration', 'naiau' ),
		'desc'    => __( 'enter the Project Duration', 'naiau' ),
		'id'      => 'project_duration',
		'type'    => 'text',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Project End Jalali Date', 'naiau' ),
		'desc'    => __( 'enter the Project End Jalali Date eg. : 1390', 'naiau' ),
		'id'      => 'project_end_date',
		'type'    => 'text',
		
			
	) );
	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Project status', 'naiau' ),
		'desc'    => __( 'select the project status', 'naiau' ),
		'id'      => 'project_status',
		'type'    => 'radio_inline',
		'options' => array(
							'in_proccess' =>__('In Proccess','naiau'),
							'cleared' =>__('Cleared','naiau'),
			),
		
			
	) );
	

}

	
function naiau_science_books_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_books_';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'main',
		'title'        => __( 'Books', 'naiau' ),
		'object_types' => array( 'user' ),
		'new_user_section' => 'add-exiting-user', // where form will show on new user page. 'add-existing-user' is only other valid option.

	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'books',
		'type'        => 'group',
		'description' => __( 'Layout books', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Book {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another book', 'naiau' ),
			'remove_button' => __( 'Remove book', 'naiau' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'book Title', 'naiau' ),
		'desc'    => __( 'enter the project Title ', 'naiau' ),
		'id'      => 'book_title',
		'type'    => 'text',
		
			
	) );
	

	
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Author', 'naiau' ),
		'desc'    => __( 'enter the book Author', 'naiau' ),
		'id'      => 'author',
		'type'    => 'text',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Translator', 'naiau' ),
		'desc'    => __( 'enter translator name', 'naiau' ),
		'id'      => 'translator',
		'type'    => 'text',
		
			
	) );
	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Publisher', 'naiau' ),
		'desc'    => __( 'enter the Publisher Name', 'naiau' ),
		'id'      => 'publisher',
		'type'    => 'text',
		
			
	) );
	

}	




