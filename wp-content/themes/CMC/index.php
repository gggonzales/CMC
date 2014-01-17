<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage CMC
 */

get_header(); ?>

<div class="inner_mid padt0">
  <?php if ( have_posts() ) : ?>
  <div class="breadcum_blackbar">
    <div class="overviewimg_inner padt10"><a href="<?php echo home_url("/");?>">HOME</a> <span><?php echo get_the_title(140)?></span> </div>
  </div>
  <?php //twentyeleven_content_nav( 'nav-above' ); ?>
  <?php  $post_data = get_page(140); 
                                        //echo get_the_title(140)."<br/><br/>"; 
                                        //echo $post_data->post_content;  ?>
  <div class="inner_mid_inner padt35">
    <div class="clear">
      <h1 class="strenth_star">CMC LIVING</h1>
      <p class="padt10"><?php echo $post_data->post_content;?> </p>
    </div>                                      
  <?php /* Start the Loop */ ?>
  <div class="blog_content">
      <div class="blog_left_content">
      <?php while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'content', get_post_format() ); ?>
      <?php endwhile; ?>
      <?php twentyeleven_content_nav( 'nav-below' ); ?>
      <?php else : ?>
      <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
          <h1 class="entry-title">
            <?php _e( 'Nothing Found', 'twentyeleven' ); ?>
          </h1>
        </header>
        <!-- .entry-header -->
        
        <div class="entry-content">
          <p>
            <?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?>
          </p>
          <?php get_search_form(); ?>
        </div>
        <!-- .entry-content --> 
      </article>
      <!-- #post-0 -->
      
      <?php endif; ?>
      
  </div>
  <div class="blog_right_content">
  <?php get_sidebar(); ?>
   </div>
      <div class="clear"></div>
    </div>
</div> 
 <div class="clear"></div>
</div>

<?php get_footer(); ?>
