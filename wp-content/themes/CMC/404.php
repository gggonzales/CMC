<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>
<div class="inner_mid padt0">
    <div class="breadcum_blackbar">
        <div class="overviewimg_inner padt10"><a href="<?php echo home_url("/"); ?>">HOME</a> <span><?php echo "Category :&nbsp;" . single_cat_title('', false); ?></span> </div>
    </div>
    <div class="inner_mid_inner padt35">
        <div class="clear">
      <h1 class="strenth_star"><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'twentyeleven'); ?></h1><br/>
    </div> 
        <div class="clear">
            <div class="blog_content">
                <div class="blog_left_content">
                 <div class="blog_content_row">
                    <article id="post-0" class="post error404 not-found">
                        <?php /*<header class="entry-header">
                            <h1 class="entry-title"><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'twentyeleven'); ?></h1>
                        </header> */ ?>

                        <div class="entry-content">
                            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'twentyeleven'); ?></p>

                            <?php get_search_form(); ?>

                           

                        </div><!-- .entry-content -->
                    </article><!-- #post-0 -->
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
    <div class="clear"></div>
</div>
<?php get_footer(); ?>