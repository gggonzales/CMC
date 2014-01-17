<?php
/**
 * The Template for displaying all single posts.
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
        <?php get_template_part( 'content-single', get_post_format() ); ?>
        <nav id="nav-single">
          <h3 class="assistive-text">
            <?php // _e( 'Post navigation', 'twentyeleven' ); ?>
          </h3>
          <span class="nav-previous">
          <?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?>
          </span> <span class="nav-next">
          <?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
          </span> </nav>
        <!-- #nav-single -->
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
