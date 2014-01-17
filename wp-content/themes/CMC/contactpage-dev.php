<?php

/**
 * Template Name: Contact Page DEV Template
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
 
<div class="banner_inner overviewimg">
    <?php
$image_id = (int)get_post_thumbnail_id($post->ID);
$image_url = wp_get_attachment_image_src($image_id, 'large', true);
//echo get_the_post_thumbnail(55, "full"); 
if($image_id > 0){
?>
    <img src="<?php echo $image_url[0]; ?>" width="1128" height="286" alt="" /> 
    <?php }else{  $header_image = get_header_image(); ?>
    <img src="<?php header_image(); ?>" width="1128" height="286" alt="" />
    <?php }?>
   
  <div class="overviewimg_inner">
    <div class="breadcum"><a href="<?php echo home_url("/");?>">HOME</a> <span><?php the_title(); ?></span>
      <h1 id="titlehead">
          <?php if($_REQUEST['form']=='vendors')
              echo'VENDORS';
          elseif($_REQUEST['form']=='volunteers')
              echo 'VOLUNTEERS';
          else
              the_title();?>
          </h1>
    </div>
   
  </div>
</div>
<?php while ( have_posts() ) : the_post(); ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        
       // var hash = window.location.hash;
       // var idarr = hash.split('#');
        //alert(hash);
        
        //var idli =idarr[1];
   var idli = '<?php echo $_REQUEST['form'];?>';
        
         if(idli =='vendors'){
                
                jQuery("#vendors").addClass("current"); 
                jQuery("#contact").removeClass("current"); 
                jQuery("#volunteers").removeClass("current");
                jQuery("#preregister").removeClass("current");
                
                jQuery("#titlehead").html("VENDORS");
                
               jQuery("#contact_div").css("display","none");
               jQuery("#vendors_div").css("display","block");
               jQuery("#volunteers_div").css("display","none");
               jQuery("#preregister_div").css("display","none");
                
            }else if(idli =='volunteers'){
                
                jQuery("#volunteers").addClass("current"); 
                jQuery("#contact").removeClass("current"); 
                jQuery("#vendors").removeClass("current");
                jQuery("#preregister").removeClass("current");
                
                 jQuery("#titlehead").html("VOLUNTEERS");
                
               jQuery("#contact_div").css("display","none");
               jQuery("#vendors_div").css("display","none");
               jQuery("#volunteers_div").css("display","block");
               jQuery("#preregister_div").css("display","none");
             
            }else if(idli =='preregister'){
                
                jQuery("#preregister").addClass("current");
                jQuery("#volunteers").removeClass("current");
                jQuery("#contact").removeClass("current"); 
                jQuery("#vendors").removeClass("current");
                
                 jQuery("#titlehead").html("PREREGISTER");
                
               jQuery("#preregister_div").css("display","block");
               jQuery("#contact_div").css("display","none");
               jQuery("#vendors_div").css("display","none");
               jQuery("#volunteers_div").css("display","none");
             
            } else{
               jQuery("#contact").addClass("current");
               jQuery("#vendors").removeClass("current"); 
               jQuery("#volunteers").removeClass("current"); 
               jQuery("#preregister").removeClass("current");
               
                jQuery("#titlehead").html("CONTACT");
               
               jQuery("#contact_div").css("display","block");
               jQuery("#vendors_div").css("display","none");
               jQuery("#volunteers_div").css("display","none");
               jQuery("#preregister_div").css("display","none");
           
            }
            
        jQuery("ul.eventlinks li").click(function(){
            var li_id=this.id;
            
            
            
            jQuery("ul.eventlinks li").each(function(){
              
                jQuery("#"+this.id).attr('class','');
                 jQuery("#"+this.id+"_div").hide();
            });
            
            
            jQuery('#'+li_id).addClass('current');
            jQuery("#titlehead").html(li_id);
            jQuery("#"+li_id+"_div").show();
        });
        
        jQuery("input:radio[name=rdlSpecialNeeds]").click(function() {
                var value = jQuery(this).val();
               
                if(value=='No'){
                     jQuery("textarea[name=txtSpecialNeeds]").val("");
                     jQuery("textarea[name=txtSpecialNeeds]").attr('disabled','disabled');                   
                    //jQuery('.txtSpecialNeeds').hide();
                    //jQuery('.txtarea_big').hide();
                    
                }else{
                    jQuery("textarea[name=txtSpecialNeeds]").removeAttr('disabled'); 
                     //jQuery('.txtSpecialNeeds').show();
                    //jQuery('.txtarea_big').show();
                    
                }
            });
        
    });
    
 </script>
<div class="inner_mid">
  <div class="inner_mid_inner">
        <ul class="eventlinks">
        <li id="contact"><a href="javascript:void(0);">Contact</a></li>
        <li id="vendors"><a href="javascript:void(0);">Vendors</a></li>
        <li id="volunteers"><a href="javascript:void(0);">Volunteers</a></li>
        <li id="preregister"><a href="javascript:void(0);">Preregister</a></li>
        </ul>
     <?php //wp_nav_menu( array( 'menu' => 'leftnavigation','container'=> '','container_class' => '','items_wrap'=> '<ul id="%1$s" class="event_nav">%3$s</ul>' ) ); ?>
 <div class="event_content_page">   
      <div id="contact_div" style="display: none;">
          
          <?php echo do_shortcode('[contact-form-7 id="379" title="Contact form 1"]'); ?>
            
      </div> 
     
      <div id="vendors_div" style="display: none;">
          <?php echo do_shortcode('[contact-form-7 id="449" title="Vendors"]'); ?>

      </div>
      
      <div id="volunteers_div" style="display: none;">
          <?php echo do_shortcode('[contact-form-7 id="450" title="Volunteers"]'); ?>

      </div>
      
      <div id="preregister_div" style="display: none;">

<div class="event_list_heading">

<h2 class="race_title padt20">Preregister</h2>
<p class="race_txt">

Combiners, preregister for any of the events below and when registration opens, you will receive an email with the race specific details and a discount code!


</p>

</div>

<div style="width:100%; text-align:left;" ><iframe  src="http://www.eventbrite.com/tickets-external?eid=9814963821&ref=etckt&v=2" frameborder="0" height="600" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe><div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" ><a style="color:#ddd; text-decoration:none;" target="_blank" href="http://www.eventbrite.com/r/etckt">Sell Tickets Online</a> <span style="color:#ddd;">through</span> <a style="color:#ddd; text-decoration:none;" target="_blank" href="http://www.eventbrite.com?ref=etckt">Eventbrite</a></div></div>

<div>
<small>PLEASE NOTE: Although we are planning to host events in many new areas, Civilian Military Combine does not guarantee that we will host a 2014 event in all the regions listed on this page.</small>

</div>
















      </div>
    
      
      
    </div>
    <div class="clear"></div>
  </div>
    <div class="clear"></div>
</div>
</div>

<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
