
	<div id="content" class="site-content">
		<?php 
      //Stan Alachniewicz added featured image to hero on sub pages.
      $category = get_queried_object();

    
      if (category_featured_image( $category->term_id )!= "null")
            { 
              $heroClass = "subpage-hero";
              $has_featured_image = true;
            }else{
              $heroClass = "";
            }    
    
      ?>
		<div class="page-header <?php echo $heroClass; ?>" <?php if ($has_featured_image == true){ ?>
		style="background:url(<?php echo get_cat_image_url($category->term_id); ?>);"
      <?php } ?> >
			