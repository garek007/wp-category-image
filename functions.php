<?php


function category_featured_image($id){
	$extra_titles = get_option('category_featured_image');
	//$extra_titles = unserialize($extra_titles);
	$extra_title = $extra_titles[$id];

	return $extra_title;
}
function get_cat_image_url($id){

	$cat_ID = $id;
	$extra_titles = get_option('category_featured_image');
	$extra_title = $extra_titles[$cat_ID];  

  $cat_img_id = $extra_title;  

  // Get the image src
  $cat_img_src = wp_get_attachment_image_src( $cat_img_id, 'full' );

  // For convenience, see if the array is valid
  $cat_has_img = is_array( $cat_img_src );


  if ( $cat_has_img ) { 
    return $cat_img_src[0];
  }
}




?>