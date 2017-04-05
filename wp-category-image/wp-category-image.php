<?php
/**
 * Plugin Name: Category Featured Image
 * Plugin URI: https://garek007.wordpress.com/
 * Description: Category Image Plugin allows you to add the featured image to a category.
 * Version: 1.0.0
 * Author: Stan Alachniewicz
 * Author URI: https://garek007.wordpress.com/
 * License: GPLv2
 */

/**
  REFERENCE 
  https://developer.wordpress.org/reference/functions/add_meta_box/
  https://codex.wordpress.org/Javascript_Reference/wp.media
  http://wordpress.stackexchange.com/questions/8736/add-custom-field-to-category
 */


add_action ( 'category_edit_form_fields', 'media_selector_settings_page_callback');
add_action('edited_category', 'taxonomy_meta_form');

function taxonomy_meta_form() {
	if ( !current_user_can( 'manage_options' ) ) //make sure user has appropriate permissions
		return;

	if($_POST['custom-img-id']){
		$extra_title = sanitize_text_field($_POST['custom-img-id']); //make sure nothing malicious
		$extra_titles = get_option('category_featured_image');
		//$extra_titles = unserialize($extra_titles);

		$cat_ID = (int)$_POST['tag_ID'];

		$extra_titles[$cat_ID] = $extra_title;   //update the value for this category's ID

		update_option('category_featured_image', $extra_titles);  //store the array, WP handles the serialization
	}
}

function media_selector_settings_page_callback($tag) {
  wp_enqueue_media();
  
	$cat_ID = $tag->term_id;
	$extra_titles = get_option('category_featured_image');
	$extra_title = $extra_titles[$cat_ID];  

  
  global $post;

  // Get WordPress' media upload URL
  $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

  // See if there's a media id already saved as post meta
  //$cat_img_id = get_post_meta( $post->ID, '_your_img_id', true );
  $cat_img_id = $extra_title;  

  // Get the image src
  $cat_img_src = wp_get_attachment_image_src( $cat_img_id, 'full' );

  // For convenience, see if the array is valid
  $cat_has_img = is_array( $cat_img_src );
  

  include 'tablerow-start.html';
  
  echo '<div class="custom-img-container">';
  if ( $cat_has_img ) { echo '<img src="'.$cat_img_src[0].'" alt="" style="max-width:50%;" />'; }
  echo '</div>';
  
  if($cat_has_img){
    $hide_setter = 'hidden';
  }else{
    $hide_remover = 'hidden';
  }
  


  echo '
  <!-- Add & remove image links -->
  <p class="hide-if-no-js">
    <a class="upload-custom-img '.$hide_setter.'" href="'.$upload_link.'">Set custom image</a>   
    <a class="delete-custom-img '.$hide_remover.'" href="#">Remove this image</a>
  </p>
 <!-- A hidden input to set and post the chosen image id -->
 <input class="custom-img-id" name="custom-img-id" type="hidden" value="'.esc_attr( $cat_img_id ).'" />
  
</td></tr>';
  
  wp_enqueue_script('scripts', plugin_dir_url(__FILE__) . 'scripts.js', array('jquery'), '1.0', true);

}








?>