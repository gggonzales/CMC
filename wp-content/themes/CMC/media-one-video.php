<?php
/**
 * Template Name: Media Sigle Video Template
 */
get_header();
 
$id = $_REQUEST['id'];
?>

<div class="banner_inner overviewimg">
    <?php
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, 'large', true);
    ?>
    <img src="<?php echo $image_url[0]; ?>"  width="1128" height="286" />
    <div class="overviewimg_inner">
        <div class="breadcum"><a href="#">HOME</a> <span>Media</span>  </div>
    </div>
</div>
<div class="inner_mid padt0">
    <div class="inner_mid_inner padt35">
        <div class="clear">
            <h1 class="strenth_star floatleft">media</h1>
            <div class="floatright mart20" id="top_social">
                
                                    <?php 
                                     $image_url2="http://img.youtube.com/vi/".$id."/mqdefault.jpg";
                                     
                                    <!--FACEBOOK-->
                                    <?php fb_share_single(home_url('cmc-video').'?id='.$id);?>
                                    <!--GOOGLE PLUS-->
                                    <?php  google_plus_share(home_url('cmc-video').'?id='.$id);?>
                                    <!--TWITTER-->
                                    <?php twitter_share_single(home_url('cmc-video').'?id='.$id,$post->ID);?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="overview_content" style="text-align:center">
        
            <a class="various iframe" rel="example_group" title="" href="http://www.youtube.com/v/<?php echo $id; ?>?fs=1&amp;autoplay=1">
             <img src="http://img.youtube.com/vi/<?php echo $id; ?>/mqdefault.jpg" alt="" width="238" height="238"   />
            </a>
                <!--<object width="560" height="315">
                    <param name="movie" value="http://www.youtube.com/v/<?php //echo $id; ?>?version=3&amp;hl=en_GB"></param>
                    <param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                    <embed src="http://www.youtube.com/v/<?php //echo $id; ?>?version=3&amp;hl=en_GB" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
                    
                    </embed></object>
-->
           



            <div class="clear"></div>
        </div>
    </div>
</div>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
<?php get_footer(); ?>
