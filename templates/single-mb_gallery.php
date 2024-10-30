<?php get_header();	
	while(have_posts())	: the_post();
?>
<section  data-scrollax-parent="true">
	<div class="container">
	    <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-4 text-center"><h3><?php the_title();?></h3></div>
          <div class="col-sm-4"></div>
        </div>
		<div class="row">
		   <div class="col-lg-12 col-md-12">
              	<?php
				global $post;
				//show front-end
				$images = get_post_meta($post->ID, 'mbgm_gallery_id', true);
				if (is_array($images) || is_object($images))	{
				?>
        	    <div id="gallery" style="display:none;">
        	   <?php
        	        foreach ( $images as $image) {
				    $image_obj = get_post($image);
				    if(!empty($image_obj->mbgm_youtube_url)){ 
				?>
				   <img alt="<?php echo $image_obj->post_excerpt;?>"
            		    data-type="youtube"  src="<?php echo esc_url(wp_get_attachment_url( $image ));?>"
            		     data-image="<?php echo esc_url(wp_get_attachment_url( $image ));?>"
            		     data-description="<?php echo $image_obj->post_excerpt;?>"
            		     data-videoid="<?php echo $image_obj->mbgm_youtube_url;?>" style="display:none">
				  <?php  }else{ ?>
				    <img alt="<?php echo $image_obj->post_excerpt;?>"
            		     src="<?php echo esc_url(wp_get_attachment_url( $image ));?>"
            		     data-image="<?php echo esc_url(wp_get_attachment_url( $image ));?>"
            		     data-description="<?php echo $image_obj->post_excerpt;?>"
            		     style="display:none">
				  <?php  }  
				  } ?>
        	     </div>
        	     	<?php	} ?>
            </div>
		</div>
	</div>
</section>
<?php endwhile;  ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#gallery").unitegallery({
			gallery_width: "100%",
			grid_num_rows:9999
		});
	});
</script>
<?php get_footer()?>