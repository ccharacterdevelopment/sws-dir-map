<?php
/*
Plugin Name: ZZ Interactive Map (Sharon)
Plugin URI: http://www.ccharacter.com/
Description: Interactive map of North American Division.
Version: 1.0
Author: Sharon Stromberg
Author URI: http://www.ccharacter.com
License: GPLv2
*/


require_once('create_template.php');


function add_directory_page() {
    // Create post object
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'Interactive Directory' ),
      'post_content'  => 'You can edit this.',
	  'post_excerpt'   => 'This page powers the interactive directory.',
      'post_status'   => 'publish',
      'post_author'   => 1,
	  'post_name'	=> 'Directory',
	  'post_type'     => 'page',
	  'page_template' => 'template-map.php'
    );

    // Insert the post into the database
    $dirPageID=wp_insert_post( $my_post );
	

	// Set its featured image
	$filename = plugin_dir_path( __FILE__ ) . 'assets/directory_image.jpg';
	$filetype = wp_check_filetype( basename( $filename ), null );
	$wp_upload_dir = wp_upload_dir();
	
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);
	
	// Insert the attachment.
	$attach_id = wp_insert_attachment( $attachment, $filename, $dirPageID );
	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );	
	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	set_post_thumbnail( $dirPageID, $attach_id );

}

register_activation_hook(__FILE__, 'add_directory_page');


// add stylesheets
function sws_map_enqueue_script() {   
  if ( is_page_template( 'template-map.php' ) ) {
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'assets/dir_script.js',array( 'jquery' ) );
    wp_enqueue_script( 'sew_spamSpan', plugin_dir_url( __FILE__ ) . 'assets/sew_spamspan.js' );
    wp_enqueue_style( 'mapCSS', plugin_dir_url( __FILE__ ).  'assets/dir_styles.css');
    wp_enqueue_style( 'mapCSS2', plugin_dir_url( __FILE__ ).  'assets/countries.css');
//    wp_enqueue_style( 'mapCSS3', plugin_dir_url( __FILE__ ).  'assets/unions.css');
  }
}
add_action('wp_enqueue_scripts', 'sws_map_enqueue_script');





function get_promo_code( $wp ) {
    $getVar = isset( $_GET[ 'id' ] ) ? sanitize_text_field( $_GET[ 'id' ] ) : '';
}

add_action( 'wp', 'get_promo_code' );

/*add_action('admin_menu', 'test_plugin_setup_menu');
 
function test_plugin_setup_menu(){
        add_menu_page( 'Test Plugin Page', 'Test Plugin', 'manage_options', 'test-plugin', 'test_init' );
}
 
function test_init(){
        test_handle_post();
?>
        <h1>Hello World!</h1>
        <h2>Upload a File</h2>
        <!-- Form to handle the upload - The enctype value here is very important -->
        <form  method="post" enctype="multipart/form-data">
                <input type='file' id='test_upload_pdf' name='test_upload_pdf'></input>
                <?php submit_button('Upload') ?>
        </form>
<?php
}
 
function test_handle_post(){
        // First check if the file appears on the _FILES array
        if(isset($_FILES['test_upload_pdf'])){
                $pdf = $_FILES['test_upload_pdf'];
 
                // Use the wordpress function to upload
                // test_upload_pdf corresponds to the position in the $_FILES array
                // 0 means the content is not associated with any other posts
                $uploaded=media_handle_upload('test_upload_pdf', 0);
                // Error checking using WP functions
                if(is_wp_error($uploaded)){
                        echo "Error uploading file: " . $uploaded->get_error_message();
                }else{
                        echo "File upload successful!";
                }
        }
}*/
 
 
?>