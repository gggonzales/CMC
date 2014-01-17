<?php
/**
 * Sample template for displaying single events posts.
 * Save this file as as single-events.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */
get_header();

$phase = get_post_meta($post->ID, 'phase', true);

$date_time =  get_post_meta($post->ID, 'event_datetime', true);
    $eventtimestamp = '';
    $todaytimestamp = '';
if($date_time!=""){
    $dateArr = explode(" ", $date_time);
    
    $dateArr1 = explode("-",$dateArr[0]);
    $timeArr = explode(":",$dateArr[1]);
    
    
    $year= $dateArr1[0];
    $month =$dateArr1[1] ;
    $day =$dateArr1[2];
    
    $hour= $timeArr[0];
    $min= $timeArr[1];
    
    $eventtimestamp = mktime($hour,$min,0,$month,$day,$year);
    $todaytimestamp = mktime(date('h'),date('i'),0,date('m'),date('d'),date('Y'));
    
    
}


$div_compi = "none;";

$div_map = 'none;';
$div_travel = 'none;';
$div_race = 'none;';
$div_media = 'none;';


$default_attr = array('class' => "event_top_banner");

if (trim($phase) != '') {
    if ($phase == 'signup') {

        $competition = get_post_meta($post->ID, 'signup_competition', true);
        $competition2 = get_post_meta($post->ID, 'signup_competition2', true);
        $competition3 = get_post_meta($post->ID, 'signup_competition3', true);
        $competition_map = get_post_meta($post->ID, 'signup_competition_map', true);
        $travel_info = get_post_meta($post->ID, 'signup_travel_info', true);
        $raceday_info = get_post_meta($post->ID, 'signup_raceday_info', true);
        $media_results = get_post_meta($post->ID, 'signup_media_results', true);
        $media_album = get_post_meta($post->ID, 'signup_media_album', true);

        $competition_header_image_id = get_post_meta($post->ID, 'signup_competition_header_image_id', true);
        $competition_map_header_image_id = get_post_meta($post->ID, 'signup_competition_map_header_image_id', true);
        $travel_info_header_image_id = get_post_meta($post->ID, 'signup_travel_info_header_image_id', true);
        $raceday_info_header_image_id = get_post_meta($post->ID, 'signup_raceday_info_header_image_id', true);
        $media_results_header_image_id = get_post_meta($post->ID, 'signup_media_results_header_image_id', true);



//        $competition_header_image        = str_replace('.jpg', '-1128x286.jpg' , $competition_header_image);
//        $competition_map_header_image    = str_replace('.jpg', '-1128x286.jpg' , $competition_map_header_image);
//        $travel_info_header_image        = str_replace('.jpg', '-1128x286.jpg' , $travel_info_header_image);
//        $raceday_info_header_image       = str_replace('.jpg', '-1128x286.jpg' , $raceday_info_header_image);
//        $media_results_header_image      = str_replace('.jpg', '-1128x286.jpg' , $media_results_header_image);



        $competition_header_image = wp_get_attachment_image($competition_header_image_id, 'inner_page_header', 0, $default_attr);
        $competition_map_header_image = wp_get_attachment_image($competition_map_header_image_id, 'inner_page_header', 0, $default_attr);
        $travel_info_header_image = wp_get_attachment_image($travel_info_header_image_id, 'inner_page_header', 0, $default_attr);
        $raceday_info_header_image = wp_get_attachment_image($raceday_info_header_image_id, 'inner_page_header', 0, $default_attr);
        $media_results_header_image = wp_get_attachment_image($media_results_header_image_id, 'inner_page_header', 0, $default_attr);



        $show_default = get_post_meta($post->ID, 'signup_show_default', true);

	if(isset($_GET['default'])) {
		$show_default = 'signup_' . $_GET['default'];
	}

        //echo wp_get_attachment_image( 381 ,'inner_page_header');die;
        if ($show_default == 'signup_competition') {
            $li_compi = "current";
            $a_compi = "current";
            $tab = "tab1";
            $div_compi = "block";
            $top_banner_url = $competition_header_image;
        } elseif ($show_default == 'signup_competition_map') {
            $top_banner_url = $competition_map_header_image;
            $li_map = "current";
            $a_map = "current";
            $tab = "tab2";
            $div_map = "block";
        } elseif ($show_default == 'signup_travel_info') {
            $top_banner_url = $travel_info_header_image;
            $li_travel = "current";
            $a_travel = "current";
            $tab = "tab3";
            $div_travel = "block";
        } elseif ($show_default == 'signup_raceday_info') {
            $top_banner_url = $raceday_info_header_image;
            $li_race = "current";
            $a_race = "current";
            $tab = "tab4";
            $div_race = "block";
        } elseif ($show_default == 'signup_media_results') {
            $top_banner_url = $media_results_header_image;
            $li_media = "current";
            $a_media = "current";
            $tab = "tab5";
            $div_media = "block";
        } else {
            $li_compi = "current";
            $a_compi = "current";
            $tab = "tab1";
            $div_compi = "block";
            $top_banner_url = $competition_header_image;
        }
    }

    if ($phase == 'closedprerace') {

        $competition = get_post_meta($post->ID, 'cpr_competition', true);
        $competition2 = get_post_meta($post->ID, 'cpr_competition2', true);
        $competition3 = get_post_meta($post->ID, 'cpr_competition3', true);
        $competition_map = get_post_meta($post->ID, 'cpr_competition_map', true);
        $travel_info = get_post_meta($post->ID, 'cpr_travel_info', true);
        $raceday_info = get_post_meta($post->ID, 'cpr_raceday_info', true);
        $media_results = get_post_meta($post->ID, 'cpr_media_results', true);
        $media_album = get_post_meta($post->ID, 'cpr_media_album', true);

        $competition_header_image_id = get_post_meta($post->ID, 'cpr_competition_header_image_id', true);
        $competition_map_header_image_id = get_post_meta($post->ID, 'cpr_competition_map_header_image_id', true);
        $travel_info_header_image_id = get_post_meta($post->ID, 'cpr_travel_info_header_image_id', true);
        $raceday_info_header_image_id = get_post_meta($post->ID, 'cpr_raceday_info_header_image_id', true);
        $media_results_header_image_id = get_post_meta($post->ID, 'cpr_media_results_header_image_id', true);

        $show_default = get_post_meta($post->ID, 'cpr_show_default', true);


//        $competition_header_image        = str_replace('.jpg', '-1128x286.jpg' , $competition_header_image);
//        $competition_map_header_image    = str_replace('.jpg', '-1128x286.jpg' , $competition_map_header_image);
//        $travel_info_header_image        = str_replace('.jpg', '-1128x286.jpg' , $travel_info_header_image);
//        $raceday_info_header_image       = str_replace('.jpg', '-1128x286.jpg' , $raceday_info_header_image);
//        $media_results_header_image      = str_replace('.jpg', '-1128x286.jpg' , $media_results_header_image);

        $competition_header_image = wp_get_attachment_image($competition_header_image_id, 'inner_page_header', 0, $default_attr);
        $competition_map_header_image = wp_get_attachment_image($competition_map_header_image_id, 'inner_page_header', 0, $default_attr);
        $travel_info_header_image = wp_get_attachment_image($travel_info_header_image_id, 'inner_page_header', 0, $default_attr);
        $raceday_info_header_image = wp_get_attachment_image($raceday_info_header_image_id, 'inner_page_header', 0, $default_attr);
        $media_results_header_image = wp_get_attachment_image($media_results_header_image_id, 'inner_page_header', 0, $default_attr);



        if ($show_default == 'cpr_competition') {
            $li_compi = "current";
            $a_compi = "current";
            $tab = "tab1";
            $div_compi = "block";
            $top_banner_url = $competition_header_image;
        } elseif ($show_default == 'cpr_competition_map') {
            $top_banner_url = $competition_map_header_image;
            $li_map = "current";
            $a_map = "current";
            $tab = "tab2";
            $div_map = "block";
        } elseif ($show_default == 'cpr_travel_info') {
            $top_banner_url = $travel_info_header_image;
            $li_travel = "current";
            $a_travel = "current";
            $tab = "tab3";
            $div_travel = "block";
        } elseif ($show_default == 'cpr_raceday_info') {
            $top_banner_url = $raceday_info_header_image;
            $li_race = "current";
            $a_race = "current";
            $tab = "tab4";
            $div_race = "block";
        } elseif ($show_default == 'cpr_media_results') {
            $top_banner_url = $media_results_header_image;
            $li_media = "current";
            $a_media = "current";
            $tab = "tab5";
            $div_media = "block";
        } else {
            $li_compi = "current";
            $a_compi = "current";
            $tab = "tab1";
            $div_compi = "block";
            $top_banner_url = $competition_header_image;
        }
    }

    if ($phase == 'closedpostrace') {

        $competition = get_post_meta($post->ID, 'cpr2_competition', true);
        $competition2 = get_post_meta($post->ID, 'cpr2_competition2', true);
        $competition3 = get_post_meta($post->ID, 'cpr2_competition3', true);
        $competition_map = get_post_meta($post->ID, 'cpr2_competition_map', true);
        $travel_info = get_post_meta($post->ID, 'cpr2_travel_info', true);
        $raceday_info = get_post_meta($post->ID, 'cpr2_raceday_info', true);
        $media_results = get_post_meta($post->ID, 'cpr2_media_results', true);
        $media_album = get_post_meta($post->ID, 'cpr2_media_album', true);

        $competition_header_image_id = get_post_meta($post->ID, 'cpr2_competition_header_image_id', true);
        $competition_map_header_image_id = get_post_meta($post->ID, 'cpr2_competition_map_header_image_id', true);
        $travel_info_header_image_id = get_post_meta($post->ID, 'cpr2_travel_info_header_image_id', true);
        $raceday_info_header_image_id = get_post_meta($post->ID, 'cpr2_raceday_info_header_image_id', true);
        $media_results_header_image_id = get_post_meta($post->ID, 'cpr2_media_results_header_image_id', true);

        $show_default = get_post_meta($post->ID, 'cpr2_show_default', true);

//        $competition_header_image        = str_replace('.jpg', '-1128x286.jpg' , $competition_header_image);
//        $competition_map_header_image    = str_replace('.jpg', '-1128x286.jpg' , $competition_map_header_image);
//        $travel_info_header_image        = str_replace('.jpg', '-1128x286.jpg' , $travel_info_header_image);
//        $raceday_info_header_image       = str_replace('.jpg', '-1128x286.jpg' , $raceday_info_header_image);
//        $media_results_header_image      = str_replace('.jpg', '-1128x286.jpg' , $media_results_header_image); 


        $competition_header_image = wp_get_attachment_image($competition_header_image_id, 'inner_page_header', 0, $default_attr);
        $competition_map_header_image = wp_get_attachment_image($competition_map_header_image_id, 'inner_page_header', 0, $default_attr);
        $travel_info_header_image = wp_get_attachment_image($travel_info_header_image_id, 'inner_page_header', 0, $default_attr);
        $raceday_info_header_image = wp_get_attachment_image($raceday_info_header_image_id, 'inner_page_header', 0, $default_attr);
        $media_results_header_image = wp_get_attachment_image($media_results_header_image_id, 'inner_page_header', 0, $default_attr);


        if ($show_default == 'cpr2_competition') {
            $li_compi = "current";
            $a_compi = "current";
            $tab = "tab1";
            $div_compi = "block";
            $top_banner_url = $competition_header_image;
        } elseif ($show_default == 'cpr2_competition_map') {
            $top_banner_url = $competition_map_header_image;
            $li_map = "current";
            $a_map = "current";
            $tab = "tab2";
            $div_map = "block";
        } elseif ($show_default == 'cpr2_travel_info') {
            $top_banner_url = $travel_info_header_image;
            $li_travel = "current";
            $a_travel = "current";
            $tab = "tab3";
            $div_travel = "block";
        } elseif ($show_default == 'cpr2_raceday_info') {
            $top_banner_url = $raceday_info_header_image;
            $li_race = "current";
            $a_race = "current";
            $tab = "tab4";
            $div_race = "block";
        } elseif ($show_default == 'cpr2_media_results') {
            $top_banner_url = $media_results_header_image;
            $li_media = "current";
            $a_media = "current";
            $tab = "tab5";
            $div_media = "block";
        } else {
            $li_compi = "current";
            $a_compi = "current";
            $tab = "tab1";
            $div_compi = "block";
            $top_banner_url = $competition_header_image;
        }
    }
} else {
    $li_compi = "current";
    $a_compi = "current";
    $tab = "tab1";
    $div_compi = "block";

    $div_map = 'none;';
    $div_travel = 'none;';
    $div_race = 'none;';
    $div_media = 'none;';

    $competition = get_post_meta($post->ID, 'signup_competition', true);
    $competition2 = get_post_meta($post->ID, 'signup_competition2', true);
    $competition3 = get_post_meta($post->ID, 'signup_competition3', true);
    $competition_map = get_post_meta($post->ID, 'signup_competition_map', true);
    $travel_info = get_post_meta($post->ID, 'signup_travel_info', true);
    $raceday_info = get_post_meta($post->ID, 'signup_raceday_info', true);
    $media_results = get_post_meta($post->ID, 'signup_media_results', true);
    $media_album = get_post_meta($post->ID, 'signup_media_album', true);

    $competition_header_image_id = get_post_meta($post->ID, 'signup_competition_header_image_id', true);
    $competition_map_header_image_id = get_post_meta($post->ID, 'signup_competition_map_header_image_id', true);
    $travel_info_header_image_id = get_post_meta($post->ID, 'signup_travel_info_header_image_id', true);
    $raceday_info_header_image_id = get_post_meta($post->ID, 'signup_raceday_info_header_image_id', true);
    $media_results_header_image_id = get_post_meta($post->ID, 'signup_media_results_header_image_id', true);

    $show_default = get_post_meta($post->ID, 'signup_show_default', true);

//        $competition_header_image        = str_replace('.jpg', '-1128x286.jpg' , $competition_header_image);
//        $competition_map_header_image    = str_replace('.jpg', '-1128x286.jpg' , $competition_map_header_image);
//        $travel_info_header_image        = str_replace('.jpg', '-1128x286.jpg' , $travel_info_header_image);
//        $raceday_info_header_image       = str_replace('.jpg', '-1128x286.jpg' , $raceday_info_header_image);
//        $media_results_header_image      = str_replace('.jpg', '-1128x286.jpg' , $media_results_header_image); 

    $competition_header_image = wp_get_attachment_image($competition_header_image_id, 'inner_page_header', 0, $default_attr);
    $competition_map_header_image = wp_get_attachment_image($competition_map_header_image_id, 'inner_page_header', 0, $default_attr);
    $travel_info_header_image = wp_get_attachment_image($travel_info_header_image_id, 'inner_page_header', 0, $default_attr);
    $raceday_info_header_image = wp_get_attachment_image($raceday_info_header_image_id, 'inner_page_header', 0, $default_attr);
    $media_results_header_image = wp_get_attachment_image($media_results_header_image_id, 'inner_page_header', 0, $default_attr);




    if ($show_default == 'signup_competition') {
        $li_compi = "current";
        $a_compi = "current";
        $tab = "tab1";
        $div_compi = "block";
        $top_banner_url = $competition_header_image;
    } elseif ($show_default == 'signup_competition_map') {
        $top_banner_url = $competition_map_header_image;
        $li_map = "current";
        $a_map = "current";
        $tab = "tab2";
        $div_map = "block";
    } elseif ($show_default == 'signup_travel_info') {
        $top_banner_url = $travel_info_header_image;
        $li_travel = "current";
        $a_travel = "current";
        $tab = "tab3";
        $div_travel = "block";
    } elseif ($show_default == 'signup_raceday_info') {
        $top_banner_url = $raceday_info_header_image;
        $li_race = "current";
        $a_race = "current";
        $tab = "tab4";
        $div_race = "block";
    } elseif ($show_default == 'signup_media_results') {
        $top_banner_url = $media_results_header_image;
        $li_media = "current";
        $a_media = "current";
        $tab = "tab5";
        $div_media = "block";
    } else {
        $li_compi = "current";
        $a_compi = "current";
        $tab = "tab1";
        $div_compi = "block";
        $top_banner_url = $competition_header_image;
    }
}




if (trim($top_banner_url) == '')
    $top_banner_url = "<img src='" . home_url('wp-content/themes/CMC/images/event_top_banner_default.jpg') . "'>";

function test($data) {
    //apply here any content modification then return new content
    return $data;
}
?>

<script type="text/javascript">

jQuery(document).ready(function(){
    //alert('hi');

//open popup
jQuery(".register_big_btn").click(function(){
     //alert('Hello');
  jQuery("#overlay_form").fadeIn(1000);
  positionPopup();
});

//close popup
jQuery("#close").click(function(){
	jQuery("#overlay_form").fadeOut(500);
});
});

//position the popup at the center of the page
function positionPopup(){
  if(!jQuery("#overlay_form").is(':visible')){
    return;
  } 
  jQuery("#overlay_form").css({
      left: (jQuery(window).width() - jQuery('#overlay_form').width()) / 2,
      top: (jQuery(window).width() - jQuery('#overlay_form').width()) / 7,
      position:'absolute'
  });
}

//maintain the popup at center of the page when browser resized
jQuery(window).bind('resize',positionPopup);

</script>
<style>
#overlay_form{
/*	position: absolute;
	border: 5px solid gray;
	padding: 10px;
	background: white;
	width: 270px;
	height: 190px;*/
}
#pop{
	display: block;
/*	border: 1px solid gray;
	width: 65px;
	text-align: center;
	padding: 6px;
	border-radius: 5px;
	text-decoration: none;
	margin: 0 auto;*/
}
</style>
<script type="text/javascript">
    jQuery(document).ready(function(){
        
        jQuery(".competition_tab li").click(function(){
            
            var li_id  =   this.id;
            jQuery("#signup_competition").hide();
            jQuery("#signup_competition_map").hide();
            jQuery("#signup_travel_info").hide();
            jQuery("#signup_raceday_info").hide();
            jQuery("#signup_media_results").hide();
            
            jQuery("#tab1_star > a").attr("class","");
            jQuery("#tab2_star > a").attr("class","");
            jQuery("#tab3_star > a").attr("class","");
            jQuery("#tab4_star > a").attr("class","");
            jQuery("#tab5_star > a").attr("class","");
            
            jQuery("#signup_"+li_id).show();
            //alert(jQuery("#signup_"+li_id).childern("div.top_banner_image").attr("class"));
            
            jQuery(".competition_tab li").each(function(){
                jQuery("#"+this.id).attr("class","");
                jQuery("#"+this.id).children('a').attr("class","");
            });
              
            jQuery("#"+li_id).attr("class","current");
            jQuery("#"+li_id).children('a').attr("class","current");
              
            if(li_id=='competition'){
                jQuery(".tab_block div").attr("class","competition_tab1");
                jQuery("#tab1_star > a").attr("class","on");
            }
            if(li_id=='competition_map'){
                jQuery(".tab_block div").attr("class","competition_tab2");
                jQuery("#tab2_star > a").attr("class","on");
            }
            if(li_id=='travel_info'){
                jQuery(".tab_block div").attr("class","competition_tab3");
                jQuery("#tab3_star > a").attr("class","on");
            }
            if(li_id=='raceday_info'){
                jQuery(".tab_block div").attr("class","competition_tab4");
                jQuery("#tab4_star > a").attr("class","on");
            }
            if(li_id=='media_results'){
                jQuery(".tab_block div").attr("class","competition_tab5");
                jQuery("#tab5_star > a").attr("class","on");
            }
            var top_banner_url = jQuery(".top_banner_"+li_id+" > img").attr("src");
              
            if (!top_banner_url) {
                jQuery("#div_event_top_banner").html("<img src='<?php echo home_url('wp-content/themes/CMC/images/competition_img.jpg'); ?>'>");
            }else{  
                if(top_banner_url!='')
                {
                    jQuery("#div_event_top_banner").html("<img src='"+top_banner_url+"'>");
                }
                else{
                    jQuery("#div_event_top_banner").html("<img src='<?php echo home_url('wp-content/themes/CMC/images/competition_img.jpg'); ?>'>");
                }
            }
        });
        
        jQuery(".register_big_btn").click(function(){
        
            jQuery(this).next("div.top_div_ticketsocket").show();
        
        });
        jQuery(".a_close").click(function(){
           jQuery(".top_div_ticketsocket").hide(); 
        });
    });
</script>

<div class="banner_inner overviewimg">
    <div id="div_event_top_banner" style="height: 286px;"><?php echo $top_banner_url; ?></div>

    <div class="overviewimg_inner">
        <div class="breadcum"><a href="<?php echo home_url(); ?>">HOME</a> <span>Events</span>
            <h1>EVENTS</h1>
            <ul class="tab_star">
                <li id="tab1_star"><a href="javascript:void(0);" class="on"></a></li>
                <li id="tab2_star"><a href="javascript:void(0);"></a></li>
                <li id="tab3_star"><a href="javascript:void(0);"></a></li>
                <li id="tab4_star"><a href="javascript:void(0);"></a></li>
                <li id="tab5_star"><a href="javascript:void(0);"></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="overview_tabing">
    <div class="overview_tabing_inner">
        <div class="clear">
            <div class="state_mountain_block">
                <?php
                while (have_posts()) : the_post();
                    $edate = get_post_meta($post->ID, 'event_datetime', true);
                    $edate = explode(' ', $edate);
                    $date_exp = explode('-', $edate[0]);
                    $unix = mktime(0, 0, 0, $date_exp[1], $date_exp[2], $date_exp[0]);
                    ?>
                    <h1><?php the_title() ?> <br />
                        <span><?php echo date("M dS, Y", $unix) ?></span> </h1>
                    <?php
                    $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                    $image_attributes = wp_get_attachment_image_src($post_thumbnail_id, 'event_featured_image');

                endwhile; // end of the loop. 
                ?>
            </div>
            <div class="floatright">
                <?php $term_list = wp_get_post_terms($post->ID, 'event-categories', array("fields" => "all")); ?>
                <img src="<?php echo $image_attributes[0]; ?>" 
                     alt="<?php echo (get_the_title()); ?>" 
                     title="<?php echo (get_the_title()); ?>"
		     height="100" 
                     />
            </div>
            <div class="clear"></div>
        </div>
        <div class="overview_tab competition_tab">
            <ul>
                <li id="competition"  class="<?php echo $li_compi; ?>"><a href="javascript:void(0);" class="<?php echo $a_compi; ?>">Competition<br />
                        <span>DETAILS</span><b></b> </a></li>
                <li id="competition_map"  class="<?php echo $li_map; ?>"><a href="javascript:void(0);" class="<?php echo $a_map; ?>">COMPETITION<br />
                        <span>MAP</span> <b></b></a></li>
                <li id="travel_info"  class="<?php echo $li_travel; ?>"><a href="javascript:void(0);" class="<?php echo $a_travel; ?>">TRAVEL<br />
                        <span>INFO</span> <b></b></a></li>
                <li id="raceday_info"  class="<?php echo $li_race; ?>"><a href="javascript:void(0);" class="<?php echo $a_race; ?>">Race Day<br />
                        <span>INFO</span> <b></b></a></li>
                <li id="media_results"  class="<?php echo $li_media; ?>"><a href="javascript:void(0);" class="<?php echo $a_media; ?>">MEDIA &amp;<br />
                        <span>RESULTS</span><b></b> </a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="tab_block">
            <div class="competition_<?php echo $tab; ?>"><img src="<?php bloginfo('template_url') ?>/images/tab_arrow.png" alt="" /></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="inner_mid">
    <div id="signup_competition" style="display:<?php echo $div_compi; ?>;">
        <div style="visibility: hidden; height: 1px; width: 1px;" class="top_banner_competition"><?php echo $competition_header_image; ?></div> 
        <div class="event_list_heading" style="padding-top: 0px;">
            <div class="inner_mid_inner">
                <div class="clear">
                    <h1 class="strenth_star floatleft">Event OVERVIEW</h1>
                    <div class="floatright">
                        <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?> 
                    </div>
                    <div class="clear"></div>
                </div>
                <?php the_content($post->ID); ?>
            </div>
        </div>
 
        <div class="event_list_heading">
            <div class="inner_mid_inner">
                <div class="clear">
                    <h1 class="strenth_star floatleft">Competition DETAILS</h1>
                    <div class="clear"></div>
                </div>
                <?php
                $content = apply_filters('the_content', $competition);
                echo $content = str_replace(']]>', ']]&gt;', $content);
                ?>
            </div>
        </div>

        <?php
        $content2 = apply_filters('the_content', $competition2);
        $content2 = str_replace(']]>', ']]&gt;', $content2);
        if (trim($content2) != '') {
            echo'<div class="event_list_heading"><div class="inner_mid_inner"><h1 class="awards_img">Awards</h1>' . $content2 . ' </div><div class="clear"> </div></div>';
        }


        $content3 = apply_filters('the_content', $competition3);
        $content3 = str_replace(']]>', ']]&gt;', $content3);
        if (trim($content3) != '') {
            echo'<div class="inner_mid_inner"><h1 class="strenth_star">Price per Participant</h1>' . $content3 . '<p class="button_block"> </p><div class="clear"> </div></div>';
        }
        ?>
        
        <div class="button_block">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--         <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>-->
    </div>
        
        <div class="clear"></div>
    </div>
    <div id="signup_competition_map" style="display:<?php echo $div_map; ?>;">
        <div style="visibility: hidden; height: 1px; width: 1px;" class="top_banner_competition_map"><?php echo $competition_map_header_image; ?></div> 
        <div class="inner_mid_inner">
            <div class="clear">
                <h1 class="strenth_star floatleft">Competition MAP</h1>
                <div class="floatright">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--                <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>-->
                </div>
                <div class="clear"></div>
            </div>
            <?php
            $content = apply_filters('the_content', $competition_map);
            echo $content = str_replace(']]>', ']]&gt;', $content);
            ?>
           <div class="button_block">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--            <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>-->
           </div>
            <div class="clear"></div>

        </div>
    </div>
    <div id="signup_travel_info" style="display:<?php echo $div_travel; ?>;">
        <div style="visibility: hidden; height: 1px; width: 1px;" class="top_banner_travel_info"><?php echo $travel_info_header_image; ?></div> 

        <div class="inner_mid_inner">
            <div class="clear">
                <h1 class="strenth_star floatleft">Travel INFO</h1>
                <div class="floatright">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--                <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>-->
                </div>
                <div class="clear"></div>
            </div>
            <?php echo $travel_info; ?>
            <div class="button_block">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--            <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>--></div>
            <div class="clear"></div>

        </div> </div>
    <div id="signup_raceday_info" style="display:<?php echo $div_race; ?>;">
        <div style="visibility: hidden; height: 1px; width: 1px;" class="top_banner_raceday_info"><?php echo $raceday_info_header_image; ?></div> 
        <div class="inner_mid_inner">
            <div class="clear">
                <h1 class="strenth_star floatleft">Race Day INFO</h1>
                <div class="floatright">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--                <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>-->
                </div>
                <div class="clear"></div>
            </div>
            <?php echo $raceday_info; ?>
           <div class="button_block">  <?php if($eventtimestamp >= $todaytimestamp){ ?> 
                        <a href="javascript:void(0);" class="register_big_btn"  ></a>  
                        <?php }?>
<!--            <div class="top_div_ticketsocket"> <?php //echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div>-->
           </div>
            <div class="clear"></div>

        </div></div>
    <div id="signup_media_results" style="display:<?php echo $div_media; ?>;">
        <div style="visibility: hidden; height: 1px; width: 1px;" class="top_banner_media_results"><?php echo $media_results_header_image; ?></div> 
        <div class="inner_mid_inner">
            
             <div class="clear">
                <h1 class="strenth_star floatleft">MEDIA</h1>
                 <?php /* ?> <div class="floatright">  <a href="javascript:void(0);" class="register_big_btn" ></a> 
                <div class="top_div_ticketsocket"> <?php echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div> </div><?php */ ?>
                
                <div class="floatright mart20" id="top_social"> 
                    <!--FACEBOOK-->
                    <?php fb_share($post->ID); ?>
                    <!--GOOGLE PLUS-->
                    <?php google_plus_share($post->ID); ?>
                    <!--TWITTER-->
                    <?php twitter_share($post->ID); ?>
                </div>
                <div class="clear"></div>
            </div>
            
            
            

            <?php
            if($media_album){

            $media = new WP_Query(array(
                        'p' => $media_album,
                        'post_type' => 'cmc_media'
                    ));

            while ($media->have_posts()) : $media->the_post();
                ?>
                <?php $image_arr = (get_custom_field('cmc_media_image:to_array')); ?>
                <?php $video_arr = get_custom_field('cmc_media_video:to_array'); 
                
                ?>
            <div class="cmc_mid_block">
      <h2>
        <?php the_title(); ?>
      </h2>
      <div class="icons_links_inner"> <a href="#" class="photo_link"><?php echo count($image_arr); ?> Photos</a> <a href="#" class="video_link"><?php echo count($video_arr); ?> Videos</a> </div>
      <div class="clear"></div>
    </div>

             
                <div class="overview_content"><?php the_content(); ?>
                     <ul class="media_inside_list">
                        <?php
                        foreach ($image_arr as $val) {
                            $image_url1 = wp_get_attachment_image_src($val, 'large', true);
                            $image_url2 = wp_get_attachment_image_src($val, 'media_galery', true);
                            ?>  
                            <li>
                                <div class="inside_media_img_box  video_icon"> <a  title="" class="various iframe" rel="example_group" title="" href="<?php echo $image_url1[0]; ?>"> <img src="<?php echo $image_url2[0]; ?>" width="238" height="238"    /></a>
                                    <div class="media_img_shadow"></div>

                                       <div class="share_div" > <a class="video_share" href="javascript:void(0);">
									<img alt="" src="<?php echo get_template_directory_uri()?>/images/share_icon_white.png" />
									</a>
                                        <div class="share_uper2">
                                            <div class="album_share2"> 
                                            <!--FACEBOOK-->
                                            <?php fb_share_single(home_url('cmc-media') . '?id=' . $val); ?>
                                            
                                            <!--TWITTER-->
                                            <?php twitter_share_single(home_url('cmc-media') . '?id=' . $val, $media_album); ?>
                                            </div>
                                        </div>
                                        </div>
                                    
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        foreach ($video_arr as $video) {
                            ?>



                            <li>
                                <div class="inside_media_img_box video_icon">  <a href="javascript:void(0);">
                                        <img src="http://img.youtube.com/vi/<?php echo $video; ?>/mqdefault.jpg" alt="" width="238" height="238"   />

                                    </a>
                                    <div class="media_img_shadow"></div>
                                    <div class="share_div" > <a class="video_share" href="javascript:void(0);">
									<img alt="" src="<?php echo get_template_directory_uri()?>/images/share_icon_white.png" />
									</a>
                                        <div class="share_uper2">
                                            <div class="album_share2"> 
                                            <!--FACEBOOK-->
                                            <?php fb_share_single(home_url('cmc-video') . '?id=' . $video); ?>
                                             
                                            <!--TWITTER-->
                                            <?php twitter_share_single(home_url('cmc-video') . '?id=' . $val,$media_album); ?>
                                            </div>
                                        </div>
                                        </div>
                                    <a class="various iframe play_icon" rel="example_group" title="" href="http://www.youtube.com/v/<?php echo $video; ?>?fs=1&amp;autoplay=1">&nbsp;</a>
                                </div>
                            </li>
                        <?php } ?>


                    </ul>
                    <div class="clear padt35">
                        <h1 class="strenth_star">Results</h1>
                        <div class="clear"></div>
                    </div><?php echo $media_results; ?>
                    <div class="clear"></div>

                </div>
            <?php
            endwhile;
            wp_reset_query(); 
            }else{
                ?><div class="overview_content">
                     <div class="clear padt35">
                        <h1 class="strenth_star">Result</h1>
                        <div class="clear"></div>
                    </div><?php echo $media_results; ?>
                    <div class="clear"></div>
                </div>
             <?php }/* ?>
           <div class="button_block"> <a class="register_big_btn"  href="javascript:void(0);"></a>
            <div class="top_div_ticketsocket"> <?php echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?></div></div> <?php */ ?>
            <div class="clear"></div></div></div>
            
            <div class="top_div_ticketsocket" id="overlay_form" style="display:none" > <?php echo do_shortcode(get_post_meta($post->ID, 'reg_url', true)); ?>
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
