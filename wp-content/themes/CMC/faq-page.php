<?php

/**
 * Template Name: FAQ Page Template
 * Description: A Page Template that showcases Sticky Posts, Asides, and Blog Posts
 *
 * The showcase template in Twenty Eleven consists of a featured posts section using sticky posts,
 * another recent posts area (with the latest post shown in full and the rest as a list)
 * and a left sidebar holding aside posts.
 *
 * We are creating two queries to fetch the proper posts and a custom widget for the sidebar.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
// Enqueue showcase script for the slider
//wp_enqueue_script( 'twentyeleven-showcase', get_template_directory_uri() . '/js/showcase.js', array( 'jquery' ), '2011-04-28' );

get_header();
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        
        jQuery("#qasearch").click(function(){
            
            var v1=jQuery("#qasearch").attr("value");
            
            if(v1=="Search FAQs"){
                jQuery("#qasearch").attr('value','');
            }
        });
        
         jQuery("#qasearch").focusout(function(){
             var v1=jQuery("#qasearch").attr("value");
             if(v1==''){
                 jQuery("#qasearch").attr('value','Search FAQs');
             }
        });
    });
</script>

<?php while ( have_posts() ) : the_post();

  //echo "<pre>";
  //print_r($categories);

?>

<div class="banner_inner overviewimg">
    <?php
$image_id = (int)get_post_thumbnail_id($post->ID);
$image_url = wp_get_attachment_image_src($image_id, 'large', true);
//echo get_the_post_thumbnail(55, "full"); 
if($image_id > 0){
?>
    <img src="<?php echo get_bloginfo('template_url').'/timthumb.php?src='.$image_url[0].'&h=286&w=1128&zc=0'; ?>"  /> 
    <?php }else{  $header_image = get_header_image(); ?>
    <img src="<?php header_image(); ?>" width="1128" height="286" alt="" />
    <?php }?>
   
  <div class="overviewimg_inner">
    <div class="breadcum"><a href="<?php echo home_url("/");?>">HOME</a> <span><?php the_title(); ?></span>
      <h1><?php the_title(); ?></h1>
    </div>
   
  </div>
</div>
<div class="inner_mid">
  <div class="inner_mid_inner">
     <?php //wp_nav_menu( array( 'menu' => 'leftnavigation','container'=> '','container_class' => '','items_wrap'=> '<ul id="%1$s" class="event_nav">%3$s</ul>' ) ); ?> 
    <div class="event_content_page">
      <h2><?php // the_title(); ?></h2>
      
      <?php the_content();?>
    </div>
    <div class="clear"></div>
  </div>
</div>

<?php endwhile; // end of the loop. ?>

<div>
<!-- Code for Action: CMC - Tracking -->
<!-- Begin Rocket Fuel Conversion Action Tracking Code Version 7 -->
<script type="text/javascript">var cache_buster = parseInt(Math.random()*99999999);document.write("<img src='http://20542995p.rfihub.com/ca.gif?rb=7571&ca=20542995&ra=" + cache_buster + "' height=0 width=0 style='display:none' alt='Rocket Fuel'/>");</script>
<noscript><iframe src='http://20542995p.rfihub.com/ca.html?rb=7571&ca=20542995&ra=' style='display:none;padding:0;margin:0' width='0' height='0'></iframe></noscript>
<!-- End Rocket Fuel Conversion Action Tracking Code Version 7 -->
</div>

<?php get_footer(); ?>
