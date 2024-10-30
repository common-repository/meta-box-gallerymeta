<?php 
function mbgm_single_sliders_shortcode($atts) {
    ob_start();
    //set attributies
    $atts = shortcode_atts(
        array( 
            'style' => ''
        ), $atts, 'helloshahin'); 
    ?>	
        <?php 
            $mbgm_single_blog = new WP_Query(array(
                'post_type'=> 'mb_slider',
                // 'post__in' => [esc_html($atts['post_id'])],
            ));
            if($atts['style'] == 1){            

            if($mbgm_single_blog->have_posts())	: 
            ?>            
            <div class="post-media">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                <?php $count = 1;?>
                <?php while($mbgm_single_blog->have_posts())	: $mbgm_single_blog->the_post(); ?>
                    <div class="carousel-item <?php echo $count == 1? 'active': '' ?>"> 
                    <?php if ( has_post_thumbnail() ) the_post_thumbnail('post-thumbnail', ['class' => 'd-block w-100', 'title' => 'Feature image']);?>
                    </div>
                <?php $count++;?>
                <?php endwhile;?>
                    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                </div> 
            </div>                  
            <?php endif;?>

        <?php }elseif($atts['style'] == 2){ ?>

          <div id="carouselExampleDark" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
                <?php $countb = 0;?>
                <?php while($mbgm_single_blog->have_posts()) : $mbgm_single_blog->the_post(); ?>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?php echo $countb;?>" class="<?php echo $countb == 0? 'active': '' ?>" aria-current="true" aria-label="<?php echo $countb;?>"></button>
                <?php $countb++;?>
                <?php endwhile;?> 
            </div>
            <div class="carousel-inner">
                <?php $count = 1;?>
                <?php while($mbgm_single_blog->have_posts())	: $mbgm_single_blog->the_post(); ?>
                    <div class="carousel-item <?php echo $count == 1? 'active': '' ?>" data-bs-interval="2000"> 
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail('post-thumbnail', ['class' => 'd-block w-100', 'title' => 'Feature image']);?>                    
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php the_title();?></h5>
                            <p><?php the_content();?></p>
                        </div>
                    </div>
                <?php $count++;?>
                <?php endwhile;?>                 
            </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php }elseif($atts['style'] == 3){ ?>
            <div class="untitled">
                <div class="untitled__slides">
                <?php while($mbgm_single_blog->have_posts())	: $mbgm_single_blog->the_post(); ?>
                    <div class="untitled__slide">
                        <div class="untitled__slideBg" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div>
                        <div class="untitled__slideContent">
                            <span><?php the_title();?></span>
                            <?php the_content();?>
                        </div>
                    </div>
                <?php endwhile;?>    
                </div>
                <div class="untitled__shutters"></div>
            </div>
        <?php }elseif($atts['style'] == 4){ ?> 
            <div class="custom-slider">
                <?php while($mbgm_single_blog->have_posts())	: $mbgm_single_blog->the_post(); ?>
                    <div class="custom-box-slider-4" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div> 
                <?php endwhile;?>  
            </div>
        <?php }elseif($atts['style'] == 5){ ?> 
        <div class="post-media">
            <div class="slider" id="slider-1">
                <?php while($mbgm_single_blog->have_posts())	: $mbgm_single_blog->the_post(); ?>
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="original">
                    <image width="100%" height="100%" preserveAspectRatio="xMidYMid slice" xlink:href="<?php the_post_thumbnail_url(); ?>" mask="url(#donutmask)"></image>
                    </svg>
                    <div class="tit"><?php the_title();?></div>
                </div>
                <?php endwhile;?>
            </div>
            <svg>
            <defs>
                <mask id="donutmask">
                <circle id="outer" cx="250" cy="250" r="400" fill="white"/>
                <circle id="inner" cx="250" cy="250" r="300"/>
                </mask>
            </defs>
            </svg>
            <div class="cursor"></div>
        </div>

        <?php }?>
                     
    <?php
        return ob_get_clean();
    }
    add_shortcode('mbgm_sliders','mbgm_single_sliders_shortcode');
?>