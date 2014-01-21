<?php
/**
 * Template Name: Home Page Template
 * Description: A Page Template that adds a sidebar to pages
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>
<!-- bxSlider CSS file -->
<link href="<?php bloginfo('template_url'); ?>/css/jquery.bxslider.css" rel="stylesheet" />
<div class="wraper">
<div class="banner_content" >
<!--<div class="video">
<a class="various iframe" rel="example_group" title="CMC Inspired" href="http://www.youtube.com/embed/Fs-0G1v04hs?fs=1&amp;autoplay=1&amp;rel=0"><img src="/wp-content/themes/CMC/images/video_box2.png" alt=""></a>
<a class="various iframe" style="display:none;" rel="example_group" title="CMC Intrepid" href="http://www.youtube.com/embed/nd9joqFyLd0?fs=1&amp;autoplay=1&amp;rel=0"></a>
<a class="various iframe" style="display:none;" rel="example_group" title="CMC 2013" href="http://www.youtube.com/embed/Fs-0G1v04hs?fs=1&amp;autoplay=1&amp;rel=0"></a>
</div>-->
<div id="showcase" >
<div id="quickNav">
  <div class="main" id="main_menu_nav" style="display:none;">
    <div class="banner_nav navItems mini_banner">
		<div class="banner_content_wrapper">
			<?php 
				$page_data = get_page( 2 );
				echo apply_filters('the_content',$page_data->post_content);
			?>
		</div>
	</div>
  </div>
</div>
    </div>
  </div>
  <div style="height:506px; width:100%; border-bottom: 2px solid #4b310e;">
    <ul class="bxslider">
      <?php
        $args = array(
            'post_type' => 'homepage_slider',
            'showposts' => '-1',
            'orderby' => 'menu_order',
            'order' => 'ASC');
        ?>
      <?php
        query_posts($args);
        $n = 1;
        while (have_posts()) : the_post();
            $desc = get_post_meta($post->ID, 'slider_banner_description', true);

            $title = "<div class=banner_content>
        <div class=slide_content>
         <!-- <h1>" . get_the_title() . "</h1> -->
          <h1>" . $desc . "</h1>
        </div>
      </div>";
            if (has_post_thumbnail()) {
                $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'homepage_banner');
                $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'homepage_banner');
                echo '<li>';
                ?>
      <img src="<?php echo $large_image_url[0] ?>" alt="<?php echo $title; ?>"  width="1902" height="506" />
      <?php
                echo '</li>';
            }
            ?>
      <?php $n++; ?>
      <?php endwhile; // end of the loop.     ?>
    </ul>
  </div>
  <?php wp_reset_query(); ?>
  <div class="tagline_main_block">
	<h1><?php bloginfo('description'); ?></h1>
  </div>
  <div class="event_main_block">

    <div class="event_box">
            <h1>GIVE BACK</h1>
	    <div style="width:295px;color:#FFFFFF;margin: 5px; margin-left: 10px; padding-top: 0px;">
		Donate to organizations that make a difference in the lives of military families.
	    </div>
	    <div style="margin: 5px; width:295px;text-align:center; margin-top:6px;">
	    <a href="/charities/"><img src="<?php bloginfo('template_url'); ?>/images/otof2.png"></a>
	    </div>
   </div>

    <div class="event_box">
      <?php
            $args_upcoming_home = array(
                'posts_per_page' => '4',
                'post_type' => 'events'
            );

            function AIOThemes_joinPOSTMETA_to_WPQueryHome($join) {
                global $wp_query, $wpdb;


                $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

                return $join;
            }

            function edit_posts_orderbyHome($orderby_statement) {
                $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) ASC";
                return $orderby_statement;
            }

            add_filter('posts_orderby', 'edit_posts_orderbyHome');
            add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryHome', 10, 2);

            add_filter('posts_where', 'my_posts_where_filterHome', 10, 2);

            function my_posts_where_filterHome($where_clause, $query_object) {

                $where_clause .= " AND meta_key='event_datetime' AND date_format(str_to_date(meta_value, '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i') > '" . date('Y-m-d H:i') . "'";
                return $where_clause;
            }

            $upcoming_home = query_posts($args_upcoming_home);
            //echo $GLOBALS['wp_query']->request;  

            remove_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryHome', 10, 2);
            remove_filter('posts_where', 'my_posts_where_filterHome', 10, 2);
            remove_filter('posts_orderby', 'edit_posts_orderbyHome');

          
                ?>
      <h1>UPCOMING EVENTS</h1>
      <ul>
        <?php
                    if ($upcoming_home) {
                    foreach ($upcoming_home as $post) {
                        $event_datetime_home = get_post_meta($post->ID, 'event_datetime', true);
                        $timestamp_home = strtotime($event_datetime_home);
                        $eventtime_home = date("M d, Y ", $timestamp_home);
                        ?>
        <li><a href="<?php echo get_permalink($post->ID); ?>">
          <div class="date_txt"><?php echo $eventtime_home; ?></div>
          <span><?php echo (get_the_title()); ?></span></a></li>
        <?php } 
                    }else{?>
        <li><a href="javascript:void(0)"> <span><?php echo "No Event"; ?></span></a></li>
        <?php } ?>
      </ul>
      <?php
           
            wp_reset_query();
            ?>
    </div>

          <div class="event_box" style="color: white;">
            
<h1>INTRO TO THE 2014 PIT</h1>
            <div style="padding-right: 7px; padding-left: 7px; padding-top: 15px;">
<!-- <a style="width:135px; height:74px; position:relative; float:left; margin: 6px;" class="various iframe" rel="example_group" title="CMC PIT - Movements" href="http://www.youtube.com/v/v1MfTOkuxs0?fs=1&amp;autoplay=1"> <img src="http://img.youtube.com/vi/v1MfTOkuxs0/1.jpg" alt="" width="135" height="74"> <img src="http://www.civilianmilitarycombine.com/wp-content/themes/CMC/images/video_transparent_img.png" alt="" style="position:absolute; top:0; left:0;"> </a> -->
                <span style="color:#FFFFFF;">2014 PIT Training Video COMING SOON!</span>


</div>
                <div style="padding:5px; padding-left: 7px;">
                </div>
          </div>

	  <div class="event_box" style="color: white;">
            <h1>AS FEATURED IN</h1>
		<div style="padding:5px;">
		<a href="/press/"><image src="/wp-content/themes/CMC/images/pressFrontPage.png" /></a>
		</div>
          </div>

    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<?php //get_sidebar();   ?>

<div>
<!-- Code for Action: CMC - Tracking -->
<!-- Begin Rocket Fuel Conversion Action Tracking Code Version 7 -->
<script type="text/javascript">var cache_buster = parseInt(Math.random()*99999999);document.write("<img src='http://20542995p.rfihub.com/ca.gif?rb=7571&ca=20542995&ra=" + cache_buster + "' height=0 width=0 style='display:none' alt='Rocket Fuel'/>");</script>
<noscript><iframe src='http://20542995p.rfihub.com/ca.html?rb=7571&ca=20542995&ra=' style='display:none;padding:0;margin:0' width='0' height='0'></iframe></noscript>
<!-- End Rocket Fuel Conversion Action Tracking Code Version 7 -->
</div>

<?php get_footer(); ?>
