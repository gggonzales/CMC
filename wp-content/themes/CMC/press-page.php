<?php
/**
 * Template Name: Press Page Template
 * Description: A Page Template that adds a sidebar to pages
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header('home'); ?>
<div class="banner_inner overviewimg">
    <?php
$image_id = (int)get_post_thumbnail_id($post->ID);
$image_url = wp_get_attachment_image_src($image_id, 'large', true);
//echo get_the_post_thumbnail(55, "full"); 
if($image_id > 0){
?>
    <img src="<?php echo $image_url[0]; ?>" width="1128" height="286" alt=""  /> 
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
  <?php $args = array(
                    'post_type' => 'press',
                    'showposts' => '-1',
                    'orderby' => 'menu_order',
                    'order' => 'DESC'); 
          
          ?>
  <div class="event_content_page">
    <?php
            query_posts($args);
            $n=1;
            while (have_posts()) : the_post();
            $szValue = get_post_meta($post->ID, 'charity_url', true);
            $image_id = (int)get_post_thumbnail_id($post->ID);
	    $image_url = wp_get_attachment_image_src($image_id, 'large', true);
	    $excerpt = '';
	    if($post->post_excerpt != '') {
		$excerpt = '"' . $post->post_excerpt . '"';
	    }
         ?>
          <a class="press_link" href=" <?php echo $szValue; ?>" target='_blank'>
    <div class="press_listing">
      <div class="press_listing_title">
          <h1><?php echo $post->post_title;?></h1>
      </div>
      <div class="press_listing_txt">
	 <img class="press_listing_image" src="<?php echo $image_url[0]; ?>" />
	  <div class="press_listing_excerpt"><?php echo $excerpt; ?></div>
      </div>
      <div class="clear"> </div>
    </div>
   </a>
    <?php $n++; ?>
    <?php endwhile; // end of the loop.   ?>
  </div>
  <div class="clear"></div>
</div>
</div>
<?php //get_sidebar(); ?>
<div>
<!-- Code for Action: CMC - Tracking -->
<!-- Begin Rocket Fuel Conversion Action Tracking Code Version 7 -->
<script type="text/javascript">var cache_buster = parseInt(Math.random()*99999999);document.write("<img src='http://20542995p.rfihub.com/ca.gif?rb=7571&ca=20542995&ra=" + cache_buster + "' height=0 width=0 style='display:none' alt='Rocket Fuel'/>");</script>
<noscript><iframe src='http://20542995p.rfihub.com/ca.html?rb=7571&ca=20542995&ra=' style='display:none;padding:0;margin:0' width='0' height='0'></iframe></noscript>
<!-- End Rocket Fuel Conversion Action Tracking Code Version 7 -->
</div>

<?php get_footer(); ?>
