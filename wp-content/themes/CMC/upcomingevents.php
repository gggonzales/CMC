<?php

/**
 * Template Name: Upcoming Events Template
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
<?php while ( have_posts() ) : the_post(); ?>
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
<?php endwhile; // end of the loop. ?>

<div class="inner_mid">
  <div class="inner_mid_inner width1024">
    
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
                    'posts_per_page' => '5',
                    'post_type' => 'events'
            );
            function AIOThemes_joinPOSTMETA_to_WPQuery($join) {
                global $wp_query, $wpdb;

               
                    $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
                
                return $join;
            }
            function edit_posts_orderby($orderby_statement) {
                    $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) DESC";
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
             remove_filter( 'posts_join', 'AIOThemes_joinPOSTMETA_to_WPQuery', 10, 2 );
             remove_filter( 'posts_where', 'my_posts_where_filter', 10, 2 );
             remove_filter( 'posts_orderby', 'edit_posts_orderby' );
             
            
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
      <div class="floatleft padt20"><a class="register_btn" href="<?php echo ($values['reg_url'][0] )?>"></a></div>
      <div class="clear"></div>
    </div>
  <?php  
   endforeach; ?>    
          
         <?php endif;
	 wp_reset_query();
         ?> 
      </div> 
    
  </div>
</div>

 

<?php get_footer(); ?>