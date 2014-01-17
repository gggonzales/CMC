<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<div class="footer_wraper">
    <div class="footer_inner">
        <div class="footer_inner_top">
        <?php if( !is_front_page() ) { ?>
            <div class="event_block">
                <div class="next_event_block">
                    <?php
                    $args_upcoming = array(
                        'posts_per_page' => '1',
                        'post_type' => 'events'
                    );

                    function AIOThemes_joinPOSTMETA_to_WPQueryFooter($join) {
                        global $wp_query, $wpdb;


                        $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

                        return $join;
                    }

                    function edit_posts_orderbyFooter($orderby_statement) {
                        $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) ASC";
                        return $orderby_statement;
                    }

                    add_filter('posts_orderby', 'edit_posts_orderbyFooter');

                    add_filter('post_limits', 'my_post_limits');

                    function my_post_limits($limit) {

                        return 'LIMIT 0, 1';
                    }

                    add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryFooter', 10, 2);

                    add_filter('posts_where', 'my_posts_where_filterFooter', 10, 2);

                    function my_posts_where_filterFooter($where_clause, $query_object) {

                        $where_clause .= " AND meta_key='event_datetime' AND date_format(str_to_date(meta_value, '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i') > '" . date('Y-m-d H:i') . "'";
                        return $where_clause;
                    }

                    $nextevent = query_posts($args_upcoming);
                    $event_datetime = "";
                    if ($nextevent):
                        foreach ($nextevent as $post) :
                            $event_datetime = get_post_meta($post->ID, 'event_datetime', true);
                            $nextEventName  = get_the_title($post->ID);
                        endforeach;



                        $timestamp = strtotime($event_datetime);

                        $eventtime = date("F d, Y H:i:s", $timestamp);

                        

                        // wp_reset_query();
                        ?>
                        <script type="text/javascript">
                            function updateWCTime() {
                                now      = new Date();
                                kickoff  = new Date("<?php echo $eventtime; ?>");
                                diff = kickoff - now;
    	
                                days  = Math.floor( diff / (1000*60*60*24) );
                                hours = Math.floor( diff / (1000*60*60) );
                                mins  = Math.floor( diff / (1000*60) );
                                secs  = Math.floor( diff / 1000 );
    	
                                dd = days;
                                hh = hours - days  * 24;
                                mm = mins  - hours * 60;
                                ss = secs  - mins  * 60;
            
            
            
                                if(dd < 0 || hh < 0 || mm < 0 || ss < 0 ){
                
                                    document.getElementById("next_event")
                                    .innerHTML = "";
            
                                }else{
              
                                    if(dd < 10){   
                                        dd ='0'+dd;   
                                    }
            
                                    if(hh < 10){   
                                        hh ='0'+hh;   
                                    }
            
                                    if(mm < 10){   
                                        mm ='0'+mm;   
                                    }
            
                                    if(ss < 10){   
                                        ss ='0'+ss;   
                                    }
                  
                                    //document.getElementById("worldcup_countdown_time").innerHTML = dd + ' days<br/>' + hh + ' hours<br/>' + mm + ' minutes<br/>' + ss + ' seconds' ;
                                    document.getElementById("next_event")
                                    .innerHTML =
                                        dd + ' days ' +
                                        hh + ' hrs ';
                                       // mm + ' mins ' +
                                      //  ss + 's';
                                }

                            }
                            setInterval('updateWCTime()', 1000 );
            
                        </script>
<?php
endif;
wp_reset_query();

remove_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryFooter', 10, 2);
                        remove_filter('posts_where', 'my_posts_where_filterFooter', 10, 2);
                        remove_filter('post_limits', 'my_post_limits');
                        remove_filter('posts_orderby', 'edit_posts_orderbyFooter');

?>
                    <h6>Next EVENT - <?php echo $nextEventName; ?></h6>
                    <h2 id="next_event"></h2>
                   </div>
                </div>
        	<?php } ?>

                <div class="footer_inner_btm">
                <div class="floatleft"> <a href="<?php echo home_url('/');?>" class="cmc_logo"><img src="<?php bloginfo('template_url');?>/images/cmc_logo.png" alt="" /></a>
                <div class="all_right_txt"><?php dynamic_sidebar('sidebar-5'); ?></div>  </div>  
        
        <?php wp_nav_menu(array('menu' => 'footer')); ?>
                </div>
            </div>
        </div> 
    </div> </div>
<?php wp_footer();  ?>
     
        
         <script src="<?php bloginfo('template_url'); ?>/js/vikas_show.js"></script>
         <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
         <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script> 
 
        </body></html> 
