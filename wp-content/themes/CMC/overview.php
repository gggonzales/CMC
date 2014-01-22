<?php
/**
 * Template Name: Overview Template
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
jQuery("object[type='application/x-shockwave-flash']").append('<param name="wMode" value="transparent"/>')
</script>

<div class="banner_inner overviewimg">
  <?php
$image_id = get_post_thumbnail_id(55);
$image_url = wp_get_attachment_image_src($image_id, 'large', true);
//echo get_the_post_thumbnail(55, "full"); 
?>
  <img src="<?php echo $image_url[0]; ?>"  width="1128" height="286" />
  <div class="overviewimg_inner">
    <div class="breadcum"><a href="<?php echo home_url("/"); ?>">HOME</a> <span><?php echo strip_tags(get_the_title($post->ID)); ?></span>
      <h1>About</h1>
      <ul class="tab_star">
        <li id="tab1_star"><a href="#" class="on"></a></li>
        <li id="tab2_star"><a href="#"></a></li>
        <li id="tab3_star"><a href="#"></a></li>
        <li id="tab4_star"><a href="#"></a></li>
      </ul>
    </div>
  </div>
</div>
<div class="overview_tabing">
  <div class="overview_tabing_inner">
    <?php while (have_posts()) : the_post(); ?>
    <div class="text-container">
      <div class="text-content short-text">
        <?php the_content(); ?>
      </div>
    </div>
    <?php endwhile; // end of the loop.   ?>
    <div id="tabs" class="overview_tab" >
      <ul>
        <?php
                $pages = get_pages(array('child_of' => $post->ID, 'sort_column' => 'menu_order'));


                for ($i = 0; $i < count($pages); $i++) {
                    $postid = $pages[$i]->ID;
                    $tab_id = $i + 1;
                    $posttitle =$pages[$i]->post_title;
                    $subtitle = get_post_meta($postid,'page_subtilte',true);
                    if($posttitle =='CMC RULES' || $posttitle == 'CMC SCORING'){
                        
                        $titleArr = explode(" ",$posttitle);
                        $posttitle= $titleArr[0]; 
                        
                    }
                    echo "<li id='tab$tab_id'><a href='javascript:void(0);'></br>
          <span>".$subtitle."</span><b></b></a></li>";
                }
                ?>
      </ul>
      <div class="clear"></div>
    </div>
    <!--<div class="tab_block">
      <div class="tab1"><img src="<?php //bloginfo('template_url') ?>/images/tab_arrow.png" alt="" /></div>
    </div>-->
  </div>
  <div class="clear"></div>
</div>
<div class="inner_mid mid-active">
  <div class="inner_mid_inner">
    <div id="tabs">
      <?php
            for ($i = 0; $i < count($pages); $i++) {
                $postid = $pages[$i]->ID;
                ?>
      <div id="div_tab<?php echo $i + 1; ?>">
        <div style=" visibility: hidden; height: 1px; width: 1px; display: none;" id="tab_thumbnail_tab<?php echo $i + 1; ?>"><?php echo get_the_post_thumbnail($postid, "large"); ?></div>
        <?php //echo get_the_post_thumbnail($postid, "large"); ?>
		<?php if($pages[$i]->post_title == "The PIT") : ?>
			<?php 
			$slug_to_get = 'strengthen-element';
			$args=array(
			  'name' => $slug_to_get,
			  'post_type' => 'page',
			  'post_status' => 'publish',
			  'showposts' => 1,
			  'caller_get_posts'=> 1
			);
			$pagesObj = get_posts($args);		
			echo apply_filters('the_content',$pagesObj[0]->post_content);
			?>
			<div class="challenge_category">
			
			<?php 
					$args = array('numberposts' => '4', 'category_name' => 'pit' , 'orderby' => 'date', 'order'=>'DESC' );
					$pits = get_posts( $args );
					?>
				<ul class="category-tip">
					<?php
					foreach($pits as $pit){
						echo "<li>";
						echo "<h3>" . $pit->post_title . "</h3>";
						echo apply_filters("the_content",$pit->post_content);
						echo "</li>";					
					}
					?>								
				</ul>
				<br class="clearboth"/>
			</div>
		<?php else: ?>
        <h1 class="strenth_star"><?php echo $pages[$i]->post_title; ?></h1>
        <?php
                    echo apply_filters('the_content',$pages[$i]->post_content);

                    if ($postid == 55) {
                        $terms = get_terms("pit_overview_category", array('orderby' => 'custom_sort', 'hide_empty' => 0, 'order' => 'ASC'));
                        //echo "<pre>";
                        //print_r($terms);
                        
                        ?>
         <div class="overview_content">
          <?php
                            for ($m = 0; $m < count($terms); $m++) {
                            
                                global $wpdb;
                                $query = "SELECT * FROM $wpdb->posts LEFT JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
                                LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->term_taxonomy.taxonomy = 'pit_overview_category' AND $wpdb->term_taxonomy.term_id = '" . $terms[$m]->term_id . "' ORDER BY ID ASC ";
                               
                               $results = $wpdb->get_results($query);
                               
                                ?>
             <div class="overview_list">
            <div class="overview_imgthumb"><img src="<?php echo z_taxonomy_image_url($terms[$m]->term_id); ?>" alt="" /></div>
            <div class="overview_imglist">
              <h2><?php echo $terms[$m]->name; ?></h2>
              <p><?php echo $terms[$m]->description; ?></p>
              <ul>
               <?php
                                            if (!empty($results)) {
              //echo "<pre>"; echo "===>".count($results);print_r($results);
              for ($k = 0; $k < count($results); $k++) { 
              
              $video_code = get_post_meta($results[$k]->ID, 'video_code', true);
             ?>
                <li><?php echo $results[$k]->post_title;
                                                    if ($video_code != "" && $video_code != "null" ) { ?> <a style="width:135px; height:74px; position:relative; float:left;" class="various iframe" rel="example_group" 
                                                               title="<?php echo $results[$k]->post_title; ?>" 
                                                               href="http://www.youtube.com/v/<?php echo $video_code; ?>?fs=1&amp;autoplay=1"> <img src="http://img.youtube.com/vi/<?php echo $video_code; ?>/1.jpg" alt="" width="135" height="74" /> <img src="<?php bloginfo('template_url'); ?>/images/video_transparent_img.png" alt="" style="position:absolute; top:0; left:0;" /> </a>
                  <?php
                                                        }
                                                        $image_id1 = (int) get_post_thumbnail_id($results[$k]->ID);
                                                        $image_url1 = wp_get_attachment_image_src($image_id1, 'large', true);
//echo get_the_post_thumbnail(55, "full"); 
                                                        if ($image_id1 > 0) {
                                                            ?>
                  <a rel="example_group" title="<?php echo $results[$k]->post_title; ?>" href="<?php echo $image_url1[0]; ?>"> <img src="<?php echo $image_url1[0]; ?>"  width="135" height="74" /></a>
                  <?php } echo $results[$k]->post_content; ?>
                </li>
               
                <?php
              
              }
              }?>
              </ul>
              </div>
            <div class="clear"></div>
          </div>
             
              <?php
                        }
                        ?>
        </div>
   
        <?php } ?>
		<?php endif; ?>
      </div>
      <?php
}
?>
    </div>
  </div>
  <div class="score_banner" style="display:none;"> </div>
</div>
<script>
jQuery(document).ready(function(){
jQuery('.inner_mid_inner #tabs > div:first').show();
       
                jQuery('#tabs ul li:first').addClass('current');
                jQuery(".overview_tab ul li").click(function(){
                    var tab_id=jQuery(this).attr("id");
                    //alert(tab_id);
                    jQuery(".tab_block div").removeClass().addClass(tab_id);
            
                    jQuery('.overview_tab ul li').each(function(){
                        var myText = "";

                        // At this point I need to loop all li items and get the text inside
                        // depending on the class attribute
                
                        //alert(tab_id);
                        //alert(this.id);
                
                        if(this.id==tab_id){
                            jQuery('#'+tab_id).addClass('current');
                            jQuery('li#'+tab_id+"_star a").addClass('on');
                        }else{
                            jQuery('#'+this.id).removeClass(); 
                            jQuery('li#'+this.id+"_star a").removeClass();
                        }

                    });
            
           
            
            
            
                    jQuery("#tabs div").hide();
                    jQuery("#div_"+tab_id).show();
                    jQuery("#tab_thumbnail1"+tab_id).show();
                    jQuery("#div_"+tab_id).children().css('display','block');
                    jQuery("div.overview_content div").css('display','block');
                    jQuery("div.clear").css('display','block');
                    jQuery("#linkevent").css('display','inline');
              
                    if(tab_id =='tab4'){
                        jQuery(".score_banner").css('display','block');
                    }else{ jQuery(".score_banner").css('display','none');}
                    var image_path = jQuery("#tab_thumbnail_"+tab_id).children("img").attr("src");
             
                    jQuery(".overviewimg").children("img").attr("src",image_path);
             
             
                });    

});

</script>

<div>
<!-- Code for Action: CMC - Tracking -->
<!-- Begin Rocket Fuel Conversion Action Tracking Code Version 7 -->
<script type="text/javascript">var cache_buster = parseInt(Math.random()*99999999);document.write("<img src='http://20542995p.rfihub.com/ca.gif?rb=7571&ca=20542995&ra=" + cache_buster + "' height=0 width=0 style='display:none' alt='Rocket Fuel'/>");</script>
<noscript><iframe src='http://20542995p.rfihub.com/ca.html?rb=7571&ca=20542995&ra=' style='display:none;padding:0;margin:0' width='0' height='0'></iframe></noscript>
<!-- End Rocket Fuel Conversion Action Tracking Code Version 7 -->
</div>

<?php get_footer(); ?>
