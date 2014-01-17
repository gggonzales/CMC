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
    <div id="showcase" >
      <div id="quickNav">
        <div class="main" id="main_menu_nav" style="display:none;">
          <div class="banner_nav navItems"  >
            <ul>
              <li class="quickstartSection">Upcoming Events</li>
              <li class="whatsNewSection">CMC Living</li>
              <li class="communitySection">The Race</li>
              <li class="eventsSection">CMC Citizens</li>
              <li class="bikesSection">Shop</li>
            </ul>
          </div>
        </div>
      </div>
      <div id="infoBox" >
        <div class="twoColumnShell" id="quickstartSection">
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
                        $event_datetime_home = get_post_meta($post->ID, 'event_datetime', true);
                        $timestamp_home = strtotime($event_datetime_home);
                        $eventtime_home = date("F d, Y ", $timestamp_home);
                        if($k!=0 && $k%3==0){
                            echo '</div></div></div><div id="EventsSectionRightColumn" class="rightColumn">';
                        }
                       
                        ?>
         
                           <div class="upcomingEventRow textMain">
                            <div class="calendarImage multi">
                                <div class="month"><?php echo date("F",$timestamp_home);?></div>
                                <div class="day"><?php echo date("d",$timestamp_home);?></div>
                            </div>
                           <a href="<?php echo get_permalink($post->ID); ?>" class="upcomingEventTxt linkMain"> <?php echo (get_the_title()); ?></a>
                           <p class="upcomingDateLoc textMain"><?php echo $eventtime_home; ?> </p>
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
          <div class="sell_all_event_link"> <a name="linkComingEventsSeeAll" id="seeAllEvents" href="<?php echo home_url("/");?>events" class="linkMain linkMainTxt">See All Events</a> </div>
          <?php
           
            wp_reset_query();
            ?>
        </div>
        <div class="twoColumnShell" id="whatsNewSection">
          <h1>CMC Living</h1>
          <?php
                    $cmc_living_page_details = get_page(359);
                    ?>
          <div style="padding:10px 20px;"> <?php echo $content_cmc_living = apply_filters('the_content', $cmc_living_page_details->post_content);
                        ?></div>
        </div>
        <div class="twoColumnShell" id="communitySection">
          <h1>The Race</h1>
          <?php
                    $therace_page_details = get_page(194);
                    ?>
          <?php echo $content_therace_page = apply_filters('the_content', $therace_page_details->post_content); ?> </div>
        <div class="twoColumnShell" id="eventsSection">
          <h1>CMC Citizens</h1>
          <?php
                    $page_details = get_page(17);
                    ?>
          <div style="padding:10px 20px;"> <?php echo $content = apply_filters('the_content', $page_details->post_content);
                        ?></div>
        </div>
        <div class="twoColumnShell" id="bikesSection">
          <h1>Shop</h1>
          <?php
                    $shop_page_details = get_page(21);
                    ?>
          <?php echo $content_shop_page = apply_filters('the_content', $shop_page_details->post_content); ?> </div>
      </div>
    </div>
  </div>
  <div style="height:706px; width:100%; overflow: hidden;">
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
                $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                echo '<li>';
                ?>
      <img src="<?php echo $large_image_url[0] ?>" alt="<?php echo $title; ?>"  height="<?php echo $image_attributes[2]; ?>" />
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
                        $eventtime_home = date("F d, Y ", $timestamp_home);
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
      <div class="slider" style="overflow: hidden;">
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
