<?php
/*
Plugin Name: Meta-box GalleryMeta
Plugin URI: https://wordpress.org/plugins/meta-box-gallerymeta/
Description: Drag and drop multiple image upload by meta-box gallery for WordPress. Take full control over your WordPress site, build any gallery you can imagine – no programming knowledge required.
Version: 2.3.2
Author: Md. Shahinur Islam
Author URI: https://profiles.wordpress.org/shahinurislam
*/
//--------------------- Create custom post type ---------------------------//
define( 'MBGM_PLUGIN', __FILE__ );
define( 'MBGM_PLUGIN_DIR', untrailingslashit( dirname( MBGM_PLUGIN ) ) );
require_once MBGM_PLUGIN_DIR . '/include/posttype.php';
require_once MBGM_PLUGIN_DIR . '/include/enqueue.php';
require_once MBGM_PLUGIN_DIR . '/include/medianame.php';
require_once MBGM_PLUGIN_DIR . '/include/sliders.php';
//--------------------------Create meta box filed as custom post ----------//
//-------------- Load Custom post type Single page --------------------//
 function mbgmnew_single_template( $template ) {
    global $post;
    if ( 'mb_gallery' === $post->post_type && locate_template( array( 'templates/single-mb_gallery.php' ) ) !== $template ) {
        return plugin_dir_path( __FILE__ ) . 'templates/single-mb_gallery.php';
    }
    return $template;
}
add_filter( 'single_template', 'mbgmnew_single_template' );
//-----------------------------metaboxfiled----------------------//
  function add_mbgmnew($post_type) {
    $types = array('mb_gallery');
    if (in_array($post_type, $types)) {
      add_meta_box(
        'mbgm',
        'Gallery',
        'mbgm_callback',
        $post_type,
        'normal',
        'high'
      );
    }
  }
  add_action('add_meta_boxes', 'add_mbgmnew');
  function mbgm_callback($post) {
    //for link mbgm_gallery_id
    wp_nonce_field( basename(__FILE__), 'mbgm_meta_nonce' );
    $ids = get_post_meta($post->ID, 'mbgm_gallery_id', true);
    ?>
    <table class="form-table">
      <tr><td>
        <a class="gallery-add button" href="#" data-uploader-title="<?php esc_html_e( 'Add image(s) to gallery', 'mbgm' );?>" data-uploader-button-text="<?php esc_html_e( 'Add image(s)', 'mbgm' );?>"><?php esc_html_e( 'Add image(s) and Video(s)', 'mbgm' );?></a>
        <ul id="gallery-metabox-list">
        <?php if ($ids) : 
			foreach ($ids as $key => $value) : 
			$image = wp_get_attachment_image_src($value); ?> 
          <li>
            <input type="hidden" name="mbgm_gallery_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
            <img class="image-preview" src="<?php echo esc_url($image[0]); ?>">
            <a class="change-image button button-small" href="#" data-uploader-title="<?php esc_html_e( 'Change image', 'mbgm' );?>" data-uploader-button-text="<?php esc_html_e( 'Change image', 'mbgm' );?>"><?php esc_html_e( 'Change image', 'mbgm' );?></a><br>
            <small><a class="remove-image" href="#"><?php esc_html_e( 'Remove image', 'mbgm' );?></a></small>
          </li>
        <?php endforeach; endif; ?>
        </ul>
      </td></tr>
    </table>
  <?php }
  function mbgm_save($post_id) {
    if (!isset($_POST['mbgm_meta_nonce']) || !wp_verify_nonce($_POST['mbgm_meta_nonce'], basename(__FILE__))) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(isset($_POST['mbgm_gallery_id'])) {
		$array = array_map( 'sanitize_text_field', wp_unslash( $_POST['mbgm_gallery_id'] ) );
		update_post_meta($post_id, 'mbgm_gallery_id', $array); 	
    } else {
      delete_post_meta($post_id, 'mbgm_gallery_id');
    }
  }
  add_action('save_post', 'mbgm_save');

//-------------All post show------------//
function mbgmnew_shortcode_wrapper() {
	ob_start();
	?>
	<section  data-scrollax-parent="true" class="dec-sec">
	<div class="container">
		<div class="row">
		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$metaboxesg_main_blog = new WP_Query(array(
			'post_type'=>'mb_gallery',
			'posts_per_page'=>3,
			'paged' => $paged
		));
		if($metaboxesg_main_blog->have_posts())	:	
		$count = 1;		
		while($metaboxesg_main_blog->have_posts())	: $metaboxesg_main_blog->the_post(); ?>
            <!-- post-->
            <div class="col-lg-4 col-md-4">
            	<article class="post">
            		<div class="post-media">            			
            			<?php
            				global $post;
            				//show front-end
            				$images = get_post_meta($post->ID, 'mbgm_gallery_id', true);
            				if (is_array($images) || is_object($images))	{
            				?>
                    	    <div id="gallery<?php echo $count;?>" style="display:none;">
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
                    	    <script type="text/javascript">
                        		jQuery(document).ready(function(){                        
                        			jQuery("#gallery<?php echo $count;?>").unitegallery();
									});                        		
                        	</script>                    	
	            	<?php	} ?>	            	
            			<?php  $count++;?>
            		</div>
            		<div class="post-item fl-wrap">
            			<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
					</div>
            	</article>
            </div>
            <!-- post end -->
			<?php endwhile; ?>		
	<?php endif;?>
		</div>
			<nav aria-label="Page navigation example">
			  <ul class="pagination justify-content-end  text-right">	
				<?php 
				$big = 999999999; // need an unlikely integer
				 echo paginate_links( array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $metaboxesg_main_blog->max_num_pages,
					'prev_text'          => __( '&laquo; Previous' ),
					'next_text'          => __( 'Next &raquo;' ),
					'type'               => 'plain'
				) );
				wp_reset_postdata();
				?>
			  </ul>
			</nav>
	</div>		
</section>
<?php
 return ob_get_clean();
}add_shortcode('mbg-front-show','mbgmnew_shortcode_wrapper');

//show for every post
function mbgm_single_gallery_shortcode($atts) {
ob_start();
//set attributies
$atts = shortcode_atts(
	array(
		'post_id' => '',
	), $atts, 'helloshahin'); 
?>	
	<?php 
		$mbgm_single_blog = new WP_Query(array(
			'post_type'=> 'mb_gallery',
			'post__in' => [esc_html($atts['post_id'])],
		));
		if($mbgm_single_blog->have_posts())	: 
		$count = 1;	
		while($mbgm_single_blog->have_posts())	: $mbgm_single_blog->the_post(); ?>
		
			<div class="post-media">            			
    			<?php
    				global $post;
    				//show front-end
    				$images = get_post_meta($post->ID, 'mbgm_gallery_id', true);
    				if (is_array($images) || is_object($images))	{
    				?>
            	    <div id="gallery<?php echo $count;?>" style="display:none;">
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
            	    <script type="text/javascript">
                		jQuery(document).ready(function(){                        
                			jQuery("#gallery<?php echo $count;?>").unitegallery({
										gallery_width: "100%",
										grid_num_rows:9999
									});
							});                        		
                	</script>                    	
        	<?php	} ?>	            	
    		<?php  $count++;?>
        </div> 
			 
		<?php endwhile; ?>		
	<?php endif;?>
	 			
<?php
    return ob_get_clean();
}
add_shortcode('mbgm_gallery','mbgm_single_gallery_shortcode');
// Dashboard Front Show settings page
register_activation_hook(__FILE__, 'mbgmnew_plugin_activate');
add_action('admin_init', 'mbgmnew_plugin_redirect');
function mbgmnew_plugin_activate() {
    add_option('mbgm_plugin_do_activation_redirect', true);
}
function mbgmnew_plugin_redirect() {
    if (get_option('mbgm_plugin_do_activation_redirect', false)) {
        delete_option('mbgm_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("edit.php?post_type=mb_gallery&page=mbg_settings");
        }
    }
}
//side setting link
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_action_links' );
function my_plugin_action_links( $actions ) {
   $actions[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=mb_gallery&page=mbg_settings') ) .'">Settings</a>';
   $actions[] = '<a href="https://forms.gle/EAtaCDDDxhcU5fva7" target="_blank">Support for contact</a>';
   return $actions;
}
add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page'); 
function wpdocs_register_my_custom_submenu_page() {
  //add_menu_page
  add_menu_page(  
    'Settings',
    'MB Gallery and Slider',
    'read',
    'mbg_settings',
    'wpdocs_my_custom_submenu_page_callback',
    'dashicons-schedule'    
    ); 
    add_submenu_page(
    'mbg_settings',
    'MB Gallery', 
    'Gallery',
    'manage_options',
    'edit.php?post_type=mb_gallery'   
    );
    add_submenu_page(
      'mbg_settings', // Parent slug
      'MB Slider',
      'Sliders',
      'manage_options',
      'edit.php?post_type=mb_slider' // Second custom post type slug
 );        
} 
function wpdocs_my_custom_submenu_page_callback() {
    ?>
<!-- partial:index.partial.html -->
<form method="post" action="options.php">
<?php wp_nonce_field('update-options') ?>	
<div class="mbg_body_class">
  <nav>
    <div class="mbg_wrapper">
      <div class="mbg_title">
        <h1><?php esc_html_e( 'Welcome to Meta-box GalleryMeta.', 'mbgm' ); ?></h1>
        <h4><?php esc_html_e( 'Copy and paste this shortcode here:', 'mbgm' );?></h4>
      </div>
      <div class="mbg_switch-btn">
        <div class="mbg_switch-text">
          <h3>
		  <!-- <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p> -->
		  </h3>
        </div>
        <div class="mbg_switch-slider">
          <label class="mbg_switch">
            <input type="checkbox" name="theme" />
            <span class="slider round"></span>
          </label>
        </div>
      </div>
    </div>
  </nav>
  <section>
    <div class="mbg_container mbg_title">
      <h2>Gallery Design Preview</h2>
    </div>
  </section>
  <section>
    <div class="mbg_background-top"></div>
    <div class="mbg_container">
      <div class="mbg_card mbg_facebook-card">
        <div class="mbg_card-title"> 
          <p>Classic</p>
        </div>
        <div class="mbg_card-content">
		     <img src="<?php echo plugin_dir_url( __FILE__ ). 'images/gallery.png'?>" width="90%">          
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper"> 
            <h4><?php esc_html_e( '[mbg-front-show]', 'mbgm' );?></h4>
          </div>
        </div>
      </div>
      <div class="mbg_card mbg_twitter-card">
	  	<p class="featured-ribbon">Coming Soon</p>
        <div class="mbg_card-title"> 	
          <p>Mordan</p>	
        </div>
        <div class="mbg_card-content">
		      <img src="<?php echo plugin_dir_url( __FILE__ ). 'images/coming-soon.jpg'?>" width="90%">          
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper"> 
            <h4 class="red">Coming Soon</h4>
          </div>
        </div>
      </div>
      <div class="mbg_card mbg_instagram-card">
	  	<p class="featured-ribbon">Coming Soon</p>
        <div class="mbg_card-title"> 
          <p>Premium</p>
        </div>
        <div class="mbg_card-content">
			  <img src="<?php echo plugin_dir_url( __FILE__ ). 'images/coming-soon.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper"> 
            <h4 class="red">Coming Soon</h4>
          </div>
        </div>
      </div>
      <div class="mbg_card mbg_yt-card">
	  	  <p class="featured-ribbon">Coming Soon</p>
        <div class="mbg_card-title"> 
          <p>Professional</p>
        </div>
        <div class="mbg_card-content">
			    <img src="<?php echo plugin_dir_url( __FILE__ ). 'images/coming-soon.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper">
            <div class="mbg_icon-down"></div>
            <h4 class="red">Coming Soon</h4>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="mbg_container mbg_title">
      <h2>Slider Design Preview</h2>
    </div>
  </section>
  <section>
    <div class="mbg_container mbg_marg">
      <div class="mbg_card mbg_yt-card"> 
        <div class="mbg_card-title"> 
          <p>Slider 1</p>
        </div>
        <div class="mbg_card-content">
			    <img src="<?php echo plugin_dir_url( __FILE__ ). 'slider/slider-1/slider-1.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper">
            <div class="mbg_icon-down"></div>
            <h4><?php esc_html_e( "[mbgm_sliders style='1']", 'mbgm' );?></h4>
          </div>
        </div>
      </div>
      <div class="mbg_card mbg_yt-card"> 
        <div class="mbg_card-title"> 
          <p>Slider 2</p>
        </div>
        <div class="mbg_card-content">
			    <img src="<?php echo plugin_dir_url( __FILE__ ). 'slider/slider-1/slider-2.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper">
            <div class="mbg_icon-down"></div>
            <h4><?php esc_html_e( "[mbgm_sliders style='2']", 'mbgm' );?></h4>
          </div>
        </div>
      </div>
      <div class="mbg_card mbg_yt-card"> 
        <div class="mbg_card-title"> 
          <p>Slider 3</p>
        </div>
        <div class="mbg_card-content">
			    <img src="<?php echo plugin_dir_url( __FILE__ ). 'slider/slider-3/slider-3.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper">
            <div class="mbg_icon-down"></div>
            <h4><?php esc_html_e( "[mbgm_sliders style='3']", 'mbgm' );?></h4>
          </div>
        </div>
      </div>
      <div class="mbg_card mbg_yt-card"> 
        <div class="mbg_card-title"> 
          <p>Slider 4</p>
        </div>
        <div class="mbg_card-content">
			    <img src="<?php echo plugin_dir_url( __FILE__ ). 'slider/slider-4/slider-4.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper">
            <div class="mbg_icon-down"></div>
            <h4><?php esc_html_e( "[mbgm_sliders style='4']", 'mbgm' );?></h4>
          </div>
        </div>
      </div> 
      
      <div class="mbg_card mbg_yt-card"> 
        <div class="mbg_card-title"> 
          <p>Slider 5</p>
        </div>
        <div class="mbg_card-content">
			    <img src="<?php echo plugin_dir_url( __FILE__ ). 'slider/slider-5/slider-5.jpg'?>" width="90%">
        </div>
        <div class="mbg_card-footer">
          <div class="mbg_footer-wrapper">
            <div class="mbg_icon-down"></div>
            <h4><?php esc_html_e( "[mbgm_sliders style='5']", 'mbgm' );?></h4>
          </div>
        </div>
      </div>
      
    </div>
  </section>  
</div>
</form>
<!-- partial -->
<?php
}
// remove column from posttype
// Remove the author column from the Books post type
add_filter('manage_mb_gallery_posts_columns', 'remove_author_column');
function remove_author_column($columns) {
    unset($columns['author']);
    unset($columns['date']);
    unset($columns['taxonomy-mbg_tag']);
    unset($columns['taxonomy-mbg_category']);
    unset($columns['comments']); 
    return $columns;
}
// Add a "Custom Column" column to the Books post type
add_filter('manage_mb_gallery_posts_columns', 'add_custom_column');
function add_custom_column($columns) {
    $columns['mbgmshortcode'] = __('MBGM Shortcode', 'mbgm');
    return $columns;
}
// Display custom data in the new column
add_action('manage_mb_gallery_posts_custom_column', 'display_custom_column_data', 10, 2);
function display_custom_column_data($column_name, $post_id) {
    if ($column_name == 'mbgmshortcode') {
        $custom_data = "[mbgm_gallery post_id='$post_id']"; 
        echo esc_html($custom_data);
    }
}