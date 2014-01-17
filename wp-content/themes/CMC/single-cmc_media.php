<?php
/**
 * Sample template for displaying single cmc_media posts.
 * Save this file as as single-cmc_media.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */
get_header();
set_time_limit(0);
?>
<script type="text/javascript">
    jQuery("object[type='application/x-shockwave-flash']").append('<param name="wMode" value="transparent"/>')
</script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_template_directory_uri() ?>/css/coda-slider.css">
<script src="<?php echo get_template_directory_uri() ?>/js/jquery-ui-1.8.20.custom.min.js"></script>
<!-- This of course is required. The full version (not .min) is also included in the js directory -->
<script src="<?php echo get_template_directory_uri() ?>/js/jquery.coda-slider-3.0.js"></script>
<script>
    jQuery(function(){

        /* Here is the slider using default settings */
        jQuery('#slider-id').codaSlider();
        /* If you want to adjust the settings, you set an option
     as follows:

      $('#slider-id').codaSlider({
        autoSlide:true,
        autoHeight:false
      });
      
         */
    });

</script>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>
<?php $image_arr = (get_custom_field('cmc_media_image:to_array')); ?>
<?php $video_arr = get_custom_field('cmc_media_video:to_array'); ?>
<div class="banner_inner overviewimg">
  <?php
            $image_id = get_post_thumbnail_id();
            $image_url = wp_get_attachment_image_src($image_id, 'large', true);
            ?>
  <img src="<?php echo $image_url[0]; ?>"  width="1128" height="286" />
  <div class="overviewimg_inner">
    <div class="breadcum"><a href="<?php echo home_url("/");?>">HOME</a> <span>Media</span> &nbsp; <span><?php echo strip_tags(get_the_title($post->ID)); ?></span></div>
  </div>
</div>
<div class="inner_mid padt0">
  <div class="inner_mid_inner padt35">
    <div class="clear">
      <h1 class="strenth_star floatleft">media</h1>
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
    <div class="cmc_mid_block">
      <h2>
        <?php the_title(); ?>
      </h2>
      <div class="icons_links_inner"> <a href="#" class="photo_link"><?php echo count($image_arr); ?> Photos</a> <a href="#" class="video_link"><?php echo count($video_arr); ?> Videos</a> </div>
      <div class="clear"></div>
    </div>
    <div class="overview_content">
      <div class="coda-slider"  id="slider-id">
        <div>
          <h2 class="title">Page 1</h2>
          <ul class="media_inside_list">
            <?php
                                $total_count = (int) (count($image_arr) + count($video_arr));
                                $k = 1;
                                $page = 2;
                                foreach ($image_arr as $val) {
                                    $image_url1 = wp_get_attachment_image_src($val, 'large', true);
                                    $image_url2 = wp_get_attachment_image_src($val, 'media_galery', true);
                                    ?>
            <li>
              <div class="inside_media_img_box  video_icon"> <a class="various iframe" rel="example_group" title="" href="<?php echo $image_url1[0]; ?>"> <img src="<?php echo $image_url2[0]; ?>" width="238" height="238"    /></a>
                <div class="media_img_shadow"></div>
                <div class="share_div" > <?php echo get_count_share(home_url('cmc-media') . '?id=' . $val,0); ?>
                  <div class="share_uper2">
                    <div class="album_share2"> 
                      <!--FACEBOOK-->
                      <?php fb_share_single(home_url('cmc-media') . '?id=' . $val); ?>
                      <!--GOOGLE PLUS-->
                      <?php //google_plus_share($media->ID); ?>
                      <!--TWITTER-->
                      <?php twitter_share_single(home_url('cmc-media') . '?id=' . $val, $post->ID); ?>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <?php
                                    if ($k % 8 == 0 && $k != $total_count) {
                                        ?>
          </ul>
        </div>
        <div>
          <h2 class="title">Page <?php echo $page;
                                    $page++; ?></h2>
          <ul class="media_inside_list">
            <?php
                                    }
                                    $k++;
                                }
                                ?>
            <?php
                                foreach ($video_arr as $video) {
                                    $image_url2 = "http://img.youtube.com/vi/" . $video . "/mqdefault.jpg";
                                    ?>
            <li>
              <div class="inside_media_img_box video_icon"> <a href="javascript:void(0);"> <img src="http://img.youtube.com/vi/<?php echo $video; ?>/mqdefault.jpg" alt="" width="238" height="238"   /> </a>
                <div class="media_img_shadow"></div>
                <div class="share_div" > <?php echo get_count_share(home_url('cmc-video') . '?id=' . $video, 0); ?>
                  <div class="share_uper2">
                    <div class="album_share2"> 
                      <!--FACEBOOK-->
                      <?php fb_share_single(home_url('cmc-video') . '?id=' . $video); ?>
                      <!--GOOGLE PLUS-->
                      <?php //google_plus_share($media->ID); ?>
                      <!--TWITTER-->
                      <?php twitter_share_single(home_url('cmc-video') . '?id=' . $val, $post->ID); ?>
                    </div>
                  </div>
                </div>
                <a class="various iframe play_icon" rel="example_group" title="" href="http://www.youtube.com/v/<?php echo $video; ?>?fs=1&amp;autoplay=1">&nbsp;</a> </div>
            </li>
            <?php
                                if ($k % 8 == 0 && $k != $total_count) {
                                    ?>
          </ul>
        </div>
        <div>
          <h2 class="title">Page <?php echo $page;
                                 $page++; ?></h2>
          <ul class="media_inside_list">
            <?php
                                }

                                $k++;
                            }
                            ?>
          </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>
<?php endwhile;
?>

<?php get_footer(); ?>
