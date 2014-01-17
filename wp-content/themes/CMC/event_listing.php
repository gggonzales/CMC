<?php
/**
 * Template Name: Event Listing Template
 */


get_header();
?> 
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("ul.eventlinks li").click(function(){
            var li_id=this.id;
            
            jQuery("ul.eventlinks li").each(function(){
              
                jQuery("#"+this.id).attr('class','');
                 jQuery("#"+this.id+"_div").hide();
            });
            
            
            jQuery('#'+li_id).addClass('current');
            jQuery("#"+li_id+"_div").show();
        });
        
    });
    
 </script>   
<div class="banner_inner overviewimg height280"><?php  
 
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
        $image_attributes = wp_get_attachment_image_src($post_thumbnail_id,'large');
?>
 <img src="<?php echo $image_attributes[0]; ?>" 
              alt="<?php echo  (get_the_title()); ?>" 
              title="<?php echo  (get_the_title()); ?>" 
                 />
 
  <div class="overviewimg_inner">
    <div class="breadcum"><a href="<?php echo home_url();?>">HOME</a> <span><?php the_title();?></span>
      <h1><?php the_title();?></h1>
    </div>
  </div>
</div>
<div class="inner_mid">
  <div class="inner_mid_inner">
    <ul class="eventlinks">
        <li class="current" id="upcoming_events"><a href="javascript:void(0);">UPCOMING EVENTS</a></li>
        <li id="past_events"><a href="javascript:void(0);">PAST EVENTS</a></li>
    </ul>
    <div class="event_list_heading">
      <div class="event_block1">
        <h2>EVENT</h2>
      </div>
      <div class="course_block">
        <h2>COURSE</h2>
      </div>
      <div class="location_block">
        <h2>LOCATION</h2>
      </div>
      <div class="date_block">
        <h2>DATE</h2>
      </div>
      <div class="clear"></div>
    </div>
       <div id="upcoming_events_div">
            <?php
            $args_upcoming=array(
                    'posts_per_page' => '100',
                    'post_type' => 'events'
            );
            function AIOThemes_joinPOSTMETA_to_WPQuery($join) {
                global $wp_query, $wpdb;

               
                    $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
                
                return $join;
            }
            function edit_posts_orderby($orderby_statement) {
                    $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) ASC";
                    return $orderby_statement;
            }
                   add_filter('posts_orderby', 'edit_posts_orderby'); 
                   
           /* add_filter( 'post_limits', 'my_post_limits' );
            
            function my_post_limits( $limit ) {
                
                    return 'LIMIT 0, 1';
             
            }   */
            
            add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQuery', 10, 2);

            add_filter( 'posts_where', 'my_posts_where_filter', 10, 2 );
            
            function my_posts_where_filter( $where_clause, $query_object ){

                $where_clause .= " AND meta_key='event_datetime' AND date_format(str_to_date(meta_value, '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i') > '" . date('Y-m-d H:i') . "'";
                return $where_clause;
            }

            $upcoming= query_posts($args_upcoming);
            //echo $GLOBALS['wp_query']->request;  
           
             remove_filter( 'posts_where', 'my_posts_where_filter', 10, 2 );
             
            
            if ($upcoming ):
            ?> 
           <?php  
   	foreach( $upcoming as $post ) : 
            $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
            $image_attributes = wp_get_attachment_image_src($post_thumbnail_id,'home_banner');
            $values = get_post_custom( $post->ID );  
            $edate = isset( $values['event_datetime'] ) ? esc_attr( $values['event_datetime'][0] ) :'';
            $edate = explode(' ',$edate);
            $date_exp=explode('-',$edate[0]);
            $unix=mktime(0, 0, 0, $date_exp[1],$date_exp[2],$date_exp[0]);
           $term_list = wp_get_post_terms($post->ID, 'event-categories', array("fields" => "all"));
    ?>
    <div class="event_list_row">
       
        <div onclick="location.href='<?php echo get_permalink($post->ID); ?>';" style="cursor: pointer;">  
      <div class="event_block1">
        <div class="floatleft padl15">
            <a href="<?php echo get_permalink($post->ID); ?>">
                <img src="<?php echo z_taxonomy_image_url($term_list[0]->term_id);?>" alt="<?php echo  (get_the_title()); ?>" 
              title="<?php echo  (get_the_title()); ?>"  width="94" height="80" />
         
     </a>
            </div>
      </div>
      <div class="course_block">
          <h3> <a href="<?php echo get_permalink($post->ID); ?>" style="text-decoration: none; color:black;"><?php echo  (get_the_title()); ?></a></h3>
      </div>
      <div class="location_block">
        <h3><a href="<?php echo get_permalink($post->ID); ?>" style="text-decoration: none; color:black;"><?php echo nl2br($values['event_location'][0] )?></a></h3>
      </div>
      <div class="date_block">
        <h3><a href="<?php echo get_permalink($post->ID); ?>" style="text-decoration: none; color:black;"><?php  echo date("M d,",$unix);?><br />
          <?php  echo date("Y",$unix);?></a></h3>
      </div> 
      </div>
      <div class="floatleft padt20"><a class="register_btn" href="<?php echo get_permalink($post->ID); ?>"></a></div>
      <div class="clear"></div>
    </div>
  <?php  
   endforeach; ?>    
          
         <?php endif;
	 wp_reset_query();
         ?> 
      </div> 
      
      
      <div id="past_events_div" style="display: none;">
      <?php

            function edit_posts_orderby2($orderby_statement) {
                    $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) DESC";
                    return $orderby_statement;
            }
                   add_filter('posts_orderby', 'edit_posts_orderby2'); 
              
            add_filter( 'posts_where', 'my_posts_after_where_filter', 10, 2 );
 
            function my_posts_after_where_filter( $where_clause, $query_object ){

                $where_clause .= " AND meta_key='event_datetime' AND date_format(str_to_date(meta_value, '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i') <= '" . date('Y-m-d H:i') . "'";
                return $where_clause;
            }

            $upcoming= query_posts($args_upcoming);
           // echo $GLOBALS['wp_query']->request;
            remove_filter( 'posts_where', 'my_posts_after_where_filter', 10, 2 );
           // remove_filter( 'post_limits', 'my_post_limits', 10, 2 );
            remove_filter( 'posts_orderby', 'edit_posts_orderby', 10, 2 );
            remove_filter( 'posts_orderby', 'edit_posts_orderby2', 10, 2 );
           
            remove_filter( 'posts_join', 'AIOThemes_joinPOSTMETA_to_WPQuery', 10, 2 );
            
            if ($upcoming ):
            ?> 
           <?php  
   	foreach( $upcoming as $post ) : 
            $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
            $image_attributes = wp_get_attachment_image_src($post_thumbnail_id,'home_banner');
            $values = get_post_custom( $post->ID );  
            $edate = isset( $values['event_datetime'] ) ? esc_attr( $values['event_datetime'][0] ) :'';
            $edate = explode(' ',$edate);
            $date_exp=explode('-',$edate[0]);
            $unix=mktime(0, 0, 0, $date_exp[1],$date_exp[2],$date_exp[0]);
            $term_list = wp_get_post_terms($post->ID, 'event-categories', array("fields" => "all"));
           
    ?>
    <div class="event_list_row">
        
      <div onclick="location.href='<?php echo get_permalink($post->ID); ?>';" style="cursor: pointer;">
      <div class="event_block1">
        <div class="floatleft padl15">
            <a href="<?php echo get_permalink($post->ID); ?>">
         <img src="<?php echo z_taxonomy_image_url($term_list[0]->term_id);?>" 
              alt="<?php echo  (get_the_title()); ?>" 
              title="<?php echo  (get_the_title()); ?>" 
                width="94" height="80"/>
     </a>
            </div>
      </div>
      <div class="course_block">
        <h3> <a href="<?php echo get_permalink($post->ID); ?>" style="text-decoration: none; color:black;"><?php echo  (get_the_title()); ?></a></h3>
      </div>
      <div class="location_block">
        <h3> <a href="<?php echo get_permalink($post->ID); ?>" style="text-decoration: none; color:black;"><?php echo nl2br($values['event_location'][0] )?></a></h3>
      </div>
      <div class="date_block">
        <h3> <a href="<?php echo get_permalink($post->ID); ?>" style="text-decoration: none; color:black;"><?php  echo date("M d,",$unix);?><br />
          <?php  echo date("Y",$unix);?></a></h3>
      </div> 
      </div>  
      <div class="floatleft padt20"><a class="result_btn" href="<?php echo get_permalink($post->ID); ?>"></a></div>
      <div class="clear"></div>
    </div>
  <?php  
   endforeach; ?>    
          
         <?php else:
             echo' <div class="event_list_row">No Event Found.</div>';
             endif;
	 wp_reset_query();
         ?> 
      </div> 
  </div>
</div>
</div>
<div>
<!-- Code for Action: CMC - Tracking -->
<!-- Begin Rocket Fuel Conversion Action Tracking Code Version 7 -->
<script type="text/javascript">var cache_buster = parseInt(Math.random()*99999999);document.write("<img src='http://20542995p.rfihub.com/ca.gif?rb=7571&ca=20542995&ra=" + cache_buster + "' height=0 width=0 style='display:none' alt='Rocket Fuel'/>");</script>
<noscript><iframe src='http://20542995p.rfihub.com/ca.html?rb=7571&ca=20542995&ra=' style='display:none;padding:0;margin:0' width='0' height='0'></iframe></noscript>
<!-- End Rocket Fuel Conversion Action Tracking Code Version 7 -->
</div>
    
    
    <?php get_footer(); ?>
