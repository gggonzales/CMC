<?php
/**
 * Template Name: Media Sigle Image Template
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
                                    <!--FACEBOOK-->
                                    <?php fb_share_single(home_url('cmc-media').'?id='.$id);?>
                                    <!--GOOGLE PLUS-->
                                    <?php  google_plus_share(home_url('cmc-media').'?id='.$id);?>
                                    <!--TWITTER-->
                                    <?php twitter_share_single(home_url('cmc-media').'?id='.$id,$post->ID);?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="overview_content" style="text-align:center;">

            <?php
            
                $image_url1 = wp_get_attachment_image_src($id, 'large', true);
                $image_url2 = wp_get_attachment_image_src($id, 'media_galery', true);
                ?>
                <a class="various iframe" rel="example_group" title="" href="<?php echo $image_url1[0]; ?>">  <img src="<?php echo $image_url2[0]; ?>"   />   </a>
                 



            <div class="clear"></div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
