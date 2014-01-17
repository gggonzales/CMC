<?php
/**
 * Template Name: Sidebar Template
 * Description: A Page Template that adds a sidebar to pages
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

<div class="inner_mid padt0">
  <?php while ( have_posts() ) : the_post(); ?>
  <div class="breadcum_blackbar">
    <div class="overviewimg_inner padt10"><a href="<?php echo home_url("/");?>">HOME</a> <span><?php echo get_the_title();?></span> </div>
  </div>
  <div class="inner_mid_inner padt35">
  <div class="clear">
  <div class="blog_content">
  <div class="blog_left_content">
  <div class="blog_content_row">
  <?php get_template_part( 'content', 'page' ); ?>
  <?php comments_template( '', true ); ?>
  </div>
  </div>
  <div class="blog_right_content">
<?php get_sidebar(); ?>
</div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"></div>
</div>   
  <?php endwhile; // end of the loop. ?>
 <div class="clear"></div>
</div>
<?php get_footer(); ?>
