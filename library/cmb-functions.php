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

//add_action( 'cmb2_init', 'naiau_register_background_image_metabox' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
// function naiau_register_background_image_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$prefix = '_naiau_';

// 	/**
// 	 * Metabox to be displayed on a single page ID
// 	 */
// 	$cmb_background = new_cmb2_box( array(
// 		'id'           => $prefix . 'background_metabox',
// 		'title'        => __( 'Background Image', 'naiau' ),
// 		'object_types' => array( 'page','post','hotel','tour' ), // Post type
// 		'context'      => 'normal',
// 		'priority'     => 'high',
// 		'show_names'   => true, // Show field names on the left
// 		//'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
// 	) );

// 	$cmb_background->add_field( array(
// 		'name' => __( 'Backgournd Image', 'naiau' ),
// 		'desc' => __( 'Upload an image or enter a URL.', 'naiau' ),
// 		'id'   => $prefix . 'background_image',
// 		'type' => 'file',
// 	) );

// }

// add_action( 'cmb2_init', 'naiau_register_hotel_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
// function naiau_register_hotel_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$prefix = '_naiau_';

// 	/**
// 	 * Sample metabox to demonstrate each field type included
// 	 */
// 	$cmb_demo = new_cmb2_box( array(
// 		'id'            => $prefix . 'hotel_metabox',
// 		'title'         => __( 'Hotel Information', 'naiau' ),
// 		'object_types'  => array( 'hotel' ), // Post type
// 		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
// 		// 'context'    => 'normal',
// 		// 'priority'   => 'high',
// 		// 'show_names' => true, // Show field names on the left
// 		// 'cmb_styles' => false, // false to disable the CMB stylesheet
// 		// 'closed'     => true, // true to keep the metabox closed by default
// 	) );

// 	$cmb_demo->add_field( array(
// 		'name'       => __( 'Region', 'naiau' ),
// 		'desc'       => __( 'Region input field', 'naiau' ),
// 		'id'         => $prefix . 'hotel_region',
// 		'type'       => 'text',
// 		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
// 		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
// 		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
// 		// 'on_front'        => false, // Optionally designate a field to wp-admin only
// 		// 'repeatable'      => true,
// 	) );

// 	$cmb_demo->add_field( array(
// 		'name' => __( 'hotel rank', 'naiau' ),
// 		'desc' => __( 'number between 0 to 10', 'naiau' ),
// 		'id'   => $prefix . 'hotel_rank',
// 		'type' => 'text',
// 		// 'repeatable' => true,
// 	) );

// 	$cmb_demo->add_field( array(
// 		'name' => __( 'hotel degree', 'naiau' ),
// 		'desc' => __( 'number between 1 to 7', 'naiau' ),
// 		'id'   => $prefix . 'hotel_degree',
// 		'type' => 'text',
// 		// 'repeatable' => true,
// 	) );

	
// 	$cmb_demo->add_field( array(
// 		'name'         => __( 'Slider Images', 'naiau' ),
// 		'desc'         => __( 'Upload or add multiple images/attachments.', 'naiau' ),
// 		'id'           => $prefix . 'image_list',
// 		'type'         => 'file_list',
// 		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
// 	) );

	

// }
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
		'object_types' => array( 'tab_maker', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'tab_maker',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'naiau' ),
		'options'     => array(
			'group_title'   => __( 'Tab {#}', 'naiau' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Tab', 'naiau' ),
			'remove_button' => __( 'Remove Tab', 'naiau' ),
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
	
	$args = array (
		'post_type'              => array( 'notify' ),
		'posts_per_page'         => '20',
	);


	// The Query
	$notify_list = get_posts( $args );
	//var_dump($hotel_list);
	$package_hotels = array();
	foreach ( $notify_list as $post ) : setup_postdata( $post );
			$package_hotels[$post->ID] = $post->post_title;
 	endforeach; 
 	//wp_reset_postdata();
	
	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Tab Title', 'naiau' ),
		'description' => __( 'Enter Tab Title', 'naiau' ),
		'id'          => 'tab_title',
		'type'        => 'text',
	) );

	

	$cmb_group->add_group_field($group_field_id , array(
		'name'             => __( 'Show excerpt', 'naiau' ),
		'desc'             => __( 'show excerpt of items or not', 'naiau' ),
		'id'               => 'show_excerpt',
		'type'             => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'false' => __( 'No', 'naiau' ),
			'true' => __( 'Yes', 'naiau' ),
			
			
		),
	) );

	$cmb_group->add_group_field($group_field_id , array(
		'name'    => __( 'Notify Category', 'naiau' ),
		'desc'    => __( 'choose Notify Category ', 'naiau' ),
		'id'      => 'notify_category',
		'type'    => 'select',
		'options' => $package_hotels,
			
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
		'object_types'  => array( 'post','page','gallery','notify','news' ), // Post type
		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'show news slider', 'naiau' ),
		'desc'       => __( 'show news slider or not', 'naiau' ),
		'id'         => $prefix . 'news_slider',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'false' => __( 'No', 'naiau' ),
			'true' => __( 'Yes', 'naiau' ),
			
			
		),
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'news category', 'naiau' ),
		'desc'       => __( 'which news category to show', 'naiau' ),
		'id'         => $prefix . 'news_category',
		'type'       => 'select',
		'show_option_none' => true,
		'options'          => array(),
			
			
		
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );
	$cmb_demo->add_field( array(
		'name'       => __( 'show important links', 'naiau' ),
		'desc'       => __( 'show important links or not', 'naiau' ),
		'id'         => $prefix . 'important_links',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			'false' => __( 'No', 'naiau' ),
			
			
		),
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );
	$cmb_demo->add_field( array(
		'name'       => __( 'show related links', 'naiau' ),
		'desc'       => __( 'show related links or not', 'naiau' ),
		'id'         => $prefix . 'related_links',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'true' => __( 'Yes', 'naiau' ),
			'false' => __( 'No', 'naiau' ),
			
			
		),
		//'show_on_cb' => 'naiau_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	
}


// add_action('cmb2_init','naiau_register_tab_metabox');

// function naiau_register_tab_metabox(){
// 	$prefix2 ='_naiau_';
// 	/**
// 	 * Repeatable Field Groups
// 	 */
// 	$cmb_tour = new_cmb2_box( array(
// 		'id'            => $prefix2 . 'tour_metabox',
// 		'title'         => __( 'Tour Information', 'naiau' ),
// 		'object_types'  => array( 'tour' ), // Post type
// 		// 'show_on_cb' => 'naiau_show_if_front_page', // function should return a bool value
// 		// 'context'    => 'normal',
// 		// 'priority'   => 'high',
// 		// 'show_names' => true, // Show field names on the left
// 		// 'cmb_styles' => false, // false to disable the CMB stylesheet
// 		// 'closed'     => true, // true to keep the metabox closed by default
// 	) );

// 	$cmb_tour->add_field( array(
// 		'name'       => __( 'Airline', 'naiau' ),
// 		'desc'       => __( 'the name of airline', 'naiau' ),
// 		'id'         => $prefix2 . 'tour_airline',
// 		'type'       => 'text',
		
// 	) );

// 	$cmb_tour->add_field( array(
// 		'name'       => __( 'Pickup time', 'naiau' ),
// 		'desc'       => __( 'the pickup time', 'naiau' ),
// 		'id'         => $prefix2 . 'pick_up_time',
// 		'type'       => 'text',
		
// 	) );

// 	$cmb_tour->add_field( array(
// 		'name'       => __( 'Landing time', 'naiau' ),
// 		'desc'       => __( 'the landing time', 'naiau' ),
// 		'id'         => $prefix2 . 'landing_time',
// 		'type'       => 'text',
		
// 	) );
// }


 
// function naiau_register_intro_page_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$prefix = '_naiau_intro_';

// 	/**
// 	 * Metabox to be displayed on a single page ID
// 	 */
// 	$cmb_intro_page = new_cmb2_box( array(
// 		'id'           => $prefix . 'metabox',
// 		'title'        => __( 'Intro Page Links Metabox', 'naiau' ),
// 		'object_types' => array( 'page', ), // Post type
// 		'context'      => 'normal',
// 		'priority'     => 'high',
// 		'show_names'   => true, // Show field names on the left
// 		//'show_on'      => 'ed_metabox_include_front_page',//array( 'key' => 'page-template', 'value' => 'template-contact.php' ),, // Specific post IDs to display this metabox
// 	) );

// 	$cmb_intro_page->add_field( array(
// 		'name' => __( 'Internal Tour', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'internal_tours',
// 		'type' => 'text_url',
// 	) );
// 	$cmb_intro_page->add_field( array(
// 		'name' => __( 'External Tour', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'external_tours',
// 		'type' => 'text_url',
// 	) );

// }

// add_action( 'cmb2_init', 'naiau_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
// function naiau_register_user_profile_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$prefix = '_naiau_user_';

// 	/**
// 	 * Metabox for the user profile screen
// 	 */
// 	$cmb_user = new_cmb2_box( array(
// 		'id'               => $prefix . 'edit',
// 		'title'            => __( 'User Profile Metabox', 'naiau' ),
// 		'object_types'     => array( 'user' ), // Tells naiau to use user_meta vs post_meta
// 		'show_names'       => true,
// 		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
// 	) );

// 	$cmb_user->add_field( array(
// 		'name'     => __( 'Extra Info', 'naiau' ),
// 		'desc'     => __( 'field description (optional)', 'naiau' ),
// 		'id'       => $prefix . 'extra_info',
// 		'type'     => 'title',
// 		'on_front' => false,
// 	) );

// 	$cmb_user->add_field( array(
// 		'name'    => __( 'Avatar', 'naiau' ),
// 		'desc'    => __( 'field description (optional)', 'naiau' ),
// 		'id'      => $prefix . 'avatar',
// 		'type'    => 'file',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Facebook URL', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'facebookurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Twitter URL', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'twitterurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Google+ URL', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'googleplusurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'Linkedin URL', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'linkedinurl',
// 		'type' => 'text_url',
// 	) );

// 	$cmb_user->add_field( array(
// 		'name' => __( 'User Field', 'naiau' ),
// 		'desc' => __( 'field description (optional)', 'naiau' ),
// 		'id'   => $prefix . 'user_text_field',
// 		'type' => 'text',
// 	) );

// }

// add_action( 'cmb2_init', 'naiau_register_theme_options_metabox' );
// /**
//  * Hook in and register a metabox to handle a theme options page
//  */
// function naiau_register_theme_options_metabox() {

// 	// Start with an underscore to hide fields from custom fields list
// 	$option_key = '_naiau_theme_options';

// 	/**
// 	 * Metabox for an options page. Will not be added automatically, but needs to be called with
// 	 * the `naiau_metabox_form` helper function. See wiki for more info.
// 	 */
// 	$cmb_options = new_cmb2_box( array(
// 		'id'      => $option_key . 'page',
// 		'title'   => __( 'Theme Options Metabox', 'naiau' ),
// 		'hookup'  => false, // Do not need the normal user/post hookup
// 		'show_on' => array(
// 			// These are important, don't remove
// 			'key'   => 'options-page',
// 			'value' => array( $option_key )
// 		),
// 	) );

// 	/**
// 	 * Options fields ids only need
// 	 * to be unique within this option group.
// 	 * Prefix is not needed.
// 	 */
// 	$cmb_options->add_field( array(
// 		'name'    => __( 'Site Background Color', 'naiau' ),
// 		'desc'    => __( 'field description (optional)', 'naiau' ),
// 		'id'      => 'bg_color',
// 		'type'    => 'colorpicker',
// 		'default' => '#ffffff',
// 	) );

// }
