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

$args = array(
                        'sort_order' => 'ASC',
                        'sort_column' => 'menu_order',
                        'hierarchical' => 1,
                        'exclude' => '',
                        'include' => '',
                        'meta_key' => '',
                        'meta_value' => '',
                        'authors' => '',
                        'child_of' => 0,
                        'parent' => -1,
                        'exclude_tree' => '',
                        'number' => '',
                        'offset' => 0,
                        'post_type' => 'page',
                        'post_status' => 'publish'
                ); 
              $pages = get_pages($args);
              $pageid_inleftnavi = array();
              //echo "<pre>";
              //print_r($pages);
              for($g=0; $g< count($pages); $g++){
                  
                   $meta_value = get_post_meta($pages[$g]->ID, 'leftnavigation_onhomepage',true);
                   if($meta_value ==1){
                       $pageid_inleftnavi[] = $pages[$g]->ID;
                   }
                  
              }
              //echo "===--=-><pre>";
              //print_r(implode("|",$pageid_inleftnavi));
?>
<!-- bxSlider CSS file -->
<link href="<?php bloginfo('template_url'); ?>/css/jquery.bxslider.css" rel="stylesheet" />
<div class="wraper">
<div class="banner_content" >
<div id="showcase" >
<div id="quickNav">
  <div class="main" id="main_menu_nav" style="display:none;">
    <div class="banner_nav navItems"  >
      <ul>
        <?php if(get_option( 'upcoming_events_inleftnavigationonhomepage_id' ) == 1){?>  
        <li class="quickstartSection">Upcoming Events</li>
        <?php } for($d=0;$d< count($pageid_inleftnavi); $d++){ ?>
           <li class="<?php echo $pageid_inleftnavi[$d];?>_Section"><?php echo get_the_title($pageid_inleftnavi[$d]);?></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
<div id="infoBox" >
  <?php if(get_option( 'upcoming_events_inleftnavigationonhomepage_id' ) == 1){?>
  <div class="twoColumnShell shadow" id="quickstartSection">
    <h1>Upcoming Events</h1>
    <?php
            $args_upcoming_home_popup = array(
                'posts_per_page' => '6',
                'post_type' => 'events'
            );

            function AIOThemes_joinPOSTMETA_to_WPQueryHomePopup($join) {
                global $wp_query, $wpdb;


                $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

                return $join;
            }

            function edit_posts_orderbyHomePopup($orderby_statement) {
                $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) ASC";
                return $orderby_statement;
            }

            add_filter('posts_orderby', 'edit_posts_orderbyHomePopup');
            add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryHomePopup', 10, 2);

            add_filter('posts_where', 'my_posts_where_filterHomePopup', 10, 2);

            function my_posts_where_filterHomePopup($where_clause, $query_object) {

                $where_clause .= " AND meta_key='event_datetime' AND date_format(str_to_date(meta_value, '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i') > '" . date('Y-m-d H:i') . "'";
                return $where_clause;
            }

            $upcoming_home_popup = query_posts($args_upcoming_home_popup);
            //echo $GLOBALS['wp_query']->request;  

            remove_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryHomePopup', 10, 2);
            remove_filter('posts_where', 'my_posts_where_filterHomePopup', 10, 2);
            remove_filter('posts_orderby', 'edit_posts_orderbyHomePopup');

          
                ?>
    <div id="EventsSectionLeftColumn" class="leftColumn">
      <div class="upcomingEvents">
        <div id="upcomingEventsContainer">
          <?php
                    if ($upcoming_home_popup) {
                     $k=0;   
                    foreach ($upcoming_home_popup as $post) {
                        $event_location_home = get_post_meta($post->ID, 'event_location', true);
                        $event_datetime_home = get_post_meta($post->ID, 'event_datetime', true);
                        $timestamp_home = strtotime($event_datetime_home);
                        $eventtime_home = date("F d, Y ", $timestamp_home);
                        if($k!=0 && $k%3==0){
                            echo '</div></div></div><div id="EventsSectionRightColumn" class="rightColumn">';
                        }
                       
                        ?>
          <div class="upcomingEventRow textMain">
            <div class="calendarImage multi">
              <div class="month"><?php echo date("M",$timestamp_home);?></div>
              <div class="day"><?php echo date("d",$timestamp_home);?></div>
            </div>
           <div class="floatright padl15"> <div class="clear"><a href="<?php echo get_permalink($post->ID); ?>" class="upcomingEventTxt linkMain"> <?php echo (get_the_title()); ?></a></div>
             <div class="clear"><p class="upcomingDateLoc textMain"><?php echo $event_location_home; ?></p></div></div>
          </div>
          <?php $k++; } 
                    }
                    if( $k>3){
                            echo '</div>';
                        }
                   else
                        echo '</div></div></div>';
                       
            ?>
          
          <!--          <div id="EventsSectionRightColumn" class="rightColumn">          
          </div>-->
          <?php  if ($upcoming_home_popup) { ?>
          <div class="clear"></div>
          <div class="sell_all_event_link"> <a name="linkComingEventsSeeAll" id="seeAllEvents" href="<?php echo home_url("/");?>events" class="submit_btn">See All Events</a> </div>
          <?php } 
           
            wp_reset_query();
            ?>
        </div>
        <?php } for($s=0;$s< count($pageid_inleftnavi); $s++){ ?>
        
          
          
        <div class="twoColumnShell shadow" id="<?php echo $pageid_inleftnavi[$s]; ?>_Section">
          <h1><?php echo get_the_title($pageid_inleftnavi[$s]);?></h1>
          <?php
                    $cmc_living_page_details = get_page($pageid_inleftnavi[$s]);
                    ?>
          <div style="padding:10px 20px;"> <?php echo $content_cmc_living = apply_filters('the_content', $cmc_living_page_details->post_content);
                        ?></div>
        </div>
     
         
          <?php } ?>
          
      </div>
    </div>
  </div>
  <div style="height:506px; width:100%;">
    <ul class="bxslider">
      <?php
        $args = array(
            'post_type' => 'homepage_slider',
            'showposts' => '-1',
            'orderby' => 'ID',
            'order' => 'DESC');
        ?>
      <?php
        query_posts($args);
        $n = 1;
        while (have_posts()) : the_post();
            $desc = get_post_meta($post->ID, 'slider_banner_description', true);

            $title = "<div class=banner_content>
        <div class=slide_content>
          <h1>" . get_the_title() . "</h1>
          <p>" . $desc . "</p>
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
  <div class="event_main_block">
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
    <div class="slider">
      <?php
            $args2 = array(
                'post_type' => 'homepage_carousel',
                'showposts' => '-1',
                'orderby' => 'ID',
                'order' => 'DESC');
            ?>
      <div class="arrow_wraper"> <a href="javascript:void(0);" id="slider-next" class="" ></a> <a href="javascript:void(0);" id="slider-prev" class=""></a> </div>
      <ul class="carousel">
        <?php
                query_posts($args2);
                //echo $GLOBALS['wp_query']->request; 
                $j = 1;
                while (have_posts()) : the_post();
                    $link = get_post_meta($post->ID, 'page_link', true);

                    if (has_post_thumbnail()) {
                        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'carousel-image');
                        echo '<li><div class="heading_box2" style="padding-left:0!important;">
                        <h1><a href="' . $link . '" >';
                        ?>
        <img src="<?php echo $large_image_url[0] ?>" />
        <?php
                        echo '</a></h1>
                    </div>
                </li>';
                    }
                    ?>
        <?php $j++; ?>
        <?php endwhile; // end of the loop.     ?>
        <?php wp_reset_query(); ?>
      </ul>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<?php //get_sidebar();   ?>
<?php get_footer(); ?>
