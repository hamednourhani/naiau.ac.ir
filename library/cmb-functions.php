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

 add_action( 'cmb2_init', 'naiau_is_sub_page_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function naiau_is_sub_page_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_naiau_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'sub_mother',
		'title'         => __( 'Page Kind', 'naiau' ),
		'object_types'  => array( 'page' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );


	
	$cmb_demo->add_field( array(
		'name'         => __( 'Mother or Sub', 'naiau' ),
		'desc'         => __( 'is this page a mother or a sub page?', 'naiau' ),
		'id'           => $prefix . 'sub_mother_page',
		'type'         => 'radio_inline',
		'options'	   => array(
			'mother'	=> __('Mother Page','naiau'),
			'sub'		=> __('Sub Page','naiau'),
			'none'		=> __('None of them','naiau'),
			),
		'default' => 'none',
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
		'name'       => __( 'show tabs', 'naiau' ),
		'desc'       => __( 'show tabs or not', 'naiau' ),
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




