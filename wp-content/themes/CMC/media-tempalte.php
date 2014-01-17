<?php
/**
 * Template Name: Media Template
 */
get_header();

?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>

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

<div class="inner_mid padt0">
  
  <div class="inner_mid_inner padt35">
    <div class="clear">
      <h1 class="strenth_star floatleft"><span><?php echo strip_tags(get_the_title($post->ID)); ?></span></h1>
      <div class="floatright mart20" id="top_social"> 
        <!--FACEBOOK-->
        <?php fb_share($post->ID);?>
        <!--GOOGLE PLUS-->
        <?php google_plus_share($post->ID);?>
        <!--TWITTER-->
        <?php twitter_share($post->ID);?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="overview_content">
      <ul class="media_list">
        <?php
                        $media = new WP_Query(array(
                                    'post_type' => 'cmc_media',
                                    'posts_per_page' => -1
                                ));
$kk=1;
                        while ($media->have_posts()) : $media->the_post();
                            ?>
        <?php $image_arr = (get_custom_field('cmc_media_image:to_array')); ?>
        <?php $video_arr = get_custom_field('cmc_media_video:to_array');
		
		if($kk%3==0){
			$class="padr0";
			}
			else{
				$class='';
				}
		$kk++;
                            ?>
        <li class="<?php echo $class;?>">
          <div class="media_img_box">
            <?php if (get_post_meta(get_the_ID(), 'apply_new', true) == 1) { ?>
            <div class="newimg_rabin"></div>
            <?php } ?>
            <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($media->ID, "event-thumbnail") ?></a>
            <a href="<?php echo get_permalink(); ?>"><div class="view_album">VIEW ALBUM</div></a>
          </div>
          <h2><a href="<?php echo get_permalink(); ?>">
            <?php the_title(); ?>
            </a></h2>
          <div class="icons_links"> <a href="<?php echo get_permalink(); ?>" class="photo_link"><?php echo count($image_arr); ?> Photos</a> <a href="<?php echo get_permalink(); ?>" class="video_link"> <?php echo count($video_arr); ?> Videos</a> 
		  <div class="share_div" >
		  <?php echo get_count_share(get_permalink(),1); ?>
            <div class="share_uper"><div class="album_share"> 
              <!--FACEBOOK-->
              <?php fb_share($media->ID);?>
              <!--GOOGLE PLUS-->
              <?php //google_plus_share($media->ID);?>
              <!--TWITTER-->
              <?php twitter_share($media->ID);?>
            </div></div>
            </div>
          </div>
        </li>
        <?php endwhile; ?>
        </select>
        <?php wp_reset_query();
                        ?>
      </ul>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"></div>
  <div style="width:90%; text-align:center;">
	&nbsp;<br/>
	&nbsp;<br/>
	&nbsp;<br/>
	<b>CMC Event Photography by</b><br/>
	<a href="http://www.nuvisionactionimage.com/" target="_blank"><img style="width:150px;" src="/wp-content/themes/CMC/images/nuvisionLogo.png"/></a>
  </div>
</div>
<?php endwhile;
?>

<?php get_footer(); ?>
