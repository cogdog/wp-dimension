<?php
/* Functions and stuff for the WP-Dimension theme
   
   Based on HTML5up html5up.net
   
   mods by and blame go to http://cog.dog
*/


// better title support https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
function dimension_setup() {
   add_theme_support( 'title-tag' );
   
   // give us thumbnails and righteous sizes
	add_theme_support( 'post-thumbnails' ); 
	set_post_thumbnail_size( 480, 200, true );
	add_image_size( 'page-thumb', 960, 400, true );
	
	// give us custom headers (that we will sneakily use as background
	$defaults = array(
		'default-image'          => '',
		'width'                  => 1568,
		'height'                 => 1024,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => false,
	);

add_theme_support( 'custom-header', $defaults );

}

add_action( 'after_setup_theme', 'dimension_setup' );



// add menu order to posts
function dimension_posts_order() {
    add_post_type_support( 'post', 'page-attributes' );
}

add_action( 'admin_init', 'dimension_posts_order' );


// add post order to posts
function dimension_columns_show_columns($name) {
    global $post;

    switch ($name) {
        case 'order':
            $views = $post->menu_order;
            echo $views;
            break;
    }
}

add_action('manage_posts_custom_column',  'dimension_columns_show_columns');

/* Sort posts in posts view by menu_order in ascending or descending order. */

// h/t http://wordpress.stackexchange.com/questions/66455/how-to-change-order-of-posts-in-admin
function custom_post_order($query){
    /* 
        Set post types.
        _builtin => true returns WordPress default post types. 
        _builtin => false returns custom registered post types. 
    */
    $post_types = get_post_types(array('_builtin' => true), 'names');
    /* The current post type. */
    $post_type = $query->get('post_type');
    /* Check post types. */
    if(in_array($post_type, $post_types)){
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
            $query->set('orderby', 'menu_order');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'ASC');
        }
    }
}

if (is_admin()){
    add_action('pre_get_posts', 'custom_post_order');
}

// organize the admin view; removed date / category, insert slide order columns
// h/t http://stackoverflow.com/questions/27602116/how-to-add-order-column-in-page-admin-wordpress


add_filter('manage_posts_columns', 'dimension_columns');

function dimension_columns($columns) {

	$dimension_columns = array(); 

	foreach( $columns as $key => $value) { 
		
		if ( $key != 'date' and $key != 'categories' ) $dimension_columns[$key] = $value; 
		if ( $key== 'title' ) { 
			$dimension_columns['order'] = ' Box Order';
		} 
	}
	
    return $dimension_columns;
}






// enqueue the scripts'n styles... do it right!

function dimension_scripts() {

	// dimension CSS
	wp_register_style( 'dimension-style', get_stylesheet_directory_uri() . '/assets/css/main.css' );
	wp_enqueue_style( 'dimension-style' );
	
	// dimension no script CSS
	wp_register_style( 'dimension-scriptless-style', get_stylesheet_directory_uri() . '/assets/css/noscript.css' );
	wp_enqueue_style( 'dimension-scriptless-style' );
	
	// custom jquery down in the footer you go
	wp_register_script( 'dimension-skel' , get_stylesheet_directory_uri() . '/assets/js/skel.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'dimension-skel' );
	
	wp_register_script( 'dimension-util' , get_stylesheet_directory_uri() . '/assets/js/util.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'dimension-util' );


	wp_register_script( 'dimension-main' , get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'dimension-main' );
	
}

add_action( 'wp_enqueue_scripts', 'dimension_scripts' );




/*** Customizer settings to allow editing of a front quote, customizing the footer, and ivon ***/

add_action( 'customize_register', 'dimension_register_theme_customizer' );

// register custom customizer stuff

function dimension_register_theme_customizer( $wp_customize ) {
	// Create custom panel.
	$wp_customize->add_panel( 'text_blocks', array(
		'priority'       => 500,
		'theme_supports' => '',
		'title'          => __( 'Dimension Front Text', 'dimension' ),
		'description'    => __( 'Set editable text for front page content. Title and tagline are drawn from blog settings', 'dimension' ),
	) );

	// Add section for quote
	$wp_customize->add_section( 'custom_quote_text' , array(
		'title'    => __('Edit Custom Quote','dimension'),
		'panel'    => 'text_blocks',
		'priority' => 10
	) );
	// Add setting for quote
	$wp_customize->add_setting( 'quote_text_block', array(
		 'default'           => __( '', 'dimension' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control for quote
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'quote_text_block',
		    array(
		        'label'    => __( 'Quote Text', 'dimension' ),
		        'section'  => 'custom_quote_text',
		        'settings' => 'quote_text_block',
		        'type'     => 'textarea'
		    )
	    )
	);

	// Add section for custom footer
	$wp_customize->add_section( 'custom_footer_text' , array(
		'title'    => __('Change Footer Text','dimension'),
		'panel'    => 'text_blocks',
		'priority' => 20
	) );
	// Add setting for footer
	$wp_customize->add_setting( 'footer_text_block', array(
		 'default'           => __( '', 'dimension' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control for footer
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text',
		    array(
		        'label'    => __( 'Footer Text', 'dimension' ),
		        'section'  => 'custom_footer_text',
		        'settings' => 'footer_text_block',
		        'type'     => 'text'
		    )
	    )
	);
	
	// add section for custom logo
	// ----- h/t https://kwight.ca/2012/12/02/adding-a-logo-uploader-to-your-wordpress-site-with-the-theme-customizer/
	$wp_customize->add_section( 'dimension_logo_section' , array(
		'title'       => __( 'Dimension Logo', 'dimension' ),
		'priority'    => 510,
		'description' => 'Upload your own logo to replace the little gears',
) );

	// add setting for logo
	$wp_customize->add_setting( 'dimension_logo' );
	
	// add controller for logo
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'dimension_logo', array(
		'label'    => __( 'Logo', 'dimension' ),
		'section'  => 'dimension_logo_section',
		'settings' => 'dimension_logo',
) ) );



 	// Sanitize text
	function sanitize_text( $text ) {
	    return sanitize_text_field( $text );
	}
}


function dimension_footer_text() {
	 if ( get_theme_mod( 'footer_text_block') != "" ) {
	 	echo get_theme_mod( 'footer_text_block') . ' &bull; ';
	 }	else {
	 	echo '';
	 }
}

function dimension_quote_text() {
	 if ( get_theme_mod( 'quote_text_block') != "" ) {
	 	echo '<p>' . get_theme_mod( 'quote_text_block') . '</p>';
	 }	
}

/* post meta boxes 
	https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
*/

function dimension_add_meta_boxes( $post ){
	add_meta_box( 'dimension_meta_box', __( 'Link Info', 'dimension' ), 'dimension_build_meta_box', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'dimension_add_meta_boxes' );

function dimension_build_meta_box( $post ){
	
	wp_nonce_field( basename( __FILE__ ), 'dimension_meta_box_nonce' );
	
	// retrieve the _dimension_link current value
	$current_link = get_post_meta( $post->ID, '_dimension_link', true );
	
	// retrieve the _link_fa_icon current value
	$current_link_icon = get_post_meta( $post->ID, '_link_fa_icon', true );
	if ( empty( $current_link_icon ) ) $current_link_icon = 'fa-share';
	
	?>
			<p>
			<label for="dimension_link" style="font-weight:bold">Destination URL</label><br />
			<input type="text" name="dimension_link" value="<?php echo $current_link; ?>" style="width:100%" />
			</p>
			
			<p>

			<label for="link_fa_icon"  style="font-weight:bold">Font Awesome Button Icon</label><br />
			Use a <a href="http://fontawesome.io/icons/" target="_blank">Font Awesome icon</a> on the link button, enter class name e.g. <em>fa-car</em> or <em>fa-share</em><br />
			<input type="text" name="link_fa_icon" value="<?php echo $current_link_icon; ?>" /> 
			</p>

<?php
}

function dimension_save_meta_boxes_data( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    
    // got nonce?    
    $is_valid_nonce = ( isset( $_POST[ 'dimension_meta_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'dimension_meta_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits if faux save status 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;
	
	// editors only
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	
	// update link meta data
	if ( isset( $_REQUEST['dimension_link'] ) ) {
		update_post_meta( $post_id, '_dimension_link', sanitize_text_field( $_POST['dimension_link'] ) );
	}
	
	// update icon meta data
	if ( isset( $_REQUEST['link_fa_icon'] ) ) {
		update_post_meta( $post_id, '_link_fa_icon', sanitize_text_field( $_POST['link_fa_icon'] ) );
	}
	
}

add_action( 'save_post', 'dimension_save_meta_boxes_data', 10, 2 );



/* --- shortcodes --------------------------------------------------------------------- */


// generate a numbered list of slides
add_shortcode("linkbutton", "dimension_button");  

function dimension_button( $atts ) {  
 	
 	// use the theme styles to insert a link button. 
 	extract( shortcode_atts( array( "url" => "#", "text" => "Go", "special" => "", "icon" => ""), $atts ) );  

	$button_class = 'button';
	if ( !empty( $special ) ) $button_class .= ' special';
	if ( !empty( $icon ) ) $button_class .= ' icon ' . $icon;
	
	return ('<p class="align-center"><a href="' . $url . '" class="' . $button_class . '">' . $text . '</a></p>');

}
?>