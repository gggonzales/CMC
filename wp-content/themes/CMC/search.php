<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
<div class="inner_mid padt0">
<div class="breadcum_blackbar">
  <div class="overviewimg_inner padt10"><a href="<?php echo home_url("/");?>">HOME</a> <span><?php printf( __( 'Search Results for: %s', 'twentyeleven' ), '' . get_search_query() . '' ); ?></span> </div>
</div>
<div class="inner_mid_inner padt35">
    <div class="clear">
      <h1 class="strenth_star"><?php printf( __( 'Search Results for: %s', 'twentyeleven' ), '' . get_search_query() . '' ); ?></h1><br/>
    </div> 
  <div class="clear">
    <div class="blog_content">
      <div class="blog_left_content">
          


			<?php if ( have_posts() ) : /* ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyeleven' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>

				<?php twentyeleven_content_nav( 'nav-above' ); */  ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>
                         <div class="blog_content_row">

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
                        </div>
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
  <div class="clear"></div>
</div>
<?php get_footer(); ?>