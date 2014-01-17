<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<div class="blog_content_row">
  <?php if ( 'post' == get_post_type() ) : ?>
  <?php /*<div class="entry-meta">
				twentyeleven_posted_on(); 
			</div><!-- .entry-meta --> */ ?>
  <?php endif; ?>
  <div class="date_text">
    <?php the_time('d'); ?>
    <br />
    <span>
    <?php the_time('M'); ?>
    </span></div>
  <h1><a href=<?php echo  get_permalink();?> >
    <?php the_title(); ?>
    </a>
    <?php $cat_arr = get_the_category();
			?>
  </h1>
  <span class="graytext">Posted in <?php echo $cat_arr[0]->cat_name;  ?> </span>
  <div class="clear"></div>
  <?php the_post_thumbnail('post_list_thumbnail'); ?>
  <?php the_content(); ?>
  <div class="comment_list">
    <div class="share_div">
      <?php $postID = get_the_ID() ;?>
      <a href="javascript:void(0);" class="reply_link share_link" ><?php echo get_count_share(get_permalink(),1); ?></a>
      <div class="share_uper">
        <div class="album_share"> 
          <!--PIN IT-->
          <?php pinit_share($postID);?>
          <!--FACEBOOK-->
          <?php fb_share($postID);?>
          <!--GOOGLE PLUS-->
          <?php //google_plus_share($media->ID);?>
          <!--TWITTER-->
          <?php twitter_share($postID);?>
        </div>
      </div>
    </div>
    <div class="floatright"><a href="<?php echo get_permalink(); ?>">
      <?php comments_number( '0 COMMENTS', '1 COMMENTS', '% COMMENTS' ); ?>
      </a> &nbsp;&nbsp;   |    &nbsp;&nbsp; <a href="<?php echo get_permalink(); ?>#respond">Leave a Comment</a></div>
    <div class="clear"></div>
  </div>
  <?php /* if ( comments_open() && ! post_password_required() ) : ?>
			<div class="comments-link">
				<?php //comments_popup_link( '<span class="leave-reply">' . __( 'Reply', 'twentyeleven' ) . '</span>', _x( '1', 'comments number', 'twentyeleven' ), _x( '%', 'comments number', 'twentyeleven' ) ); ?>
			</div>
			<?php endif; */ ?>
</div>
