<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<!--<meta name="viewport" content="width=device-width" />-->
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">
<meta property="og:image" content="/images/fb_icon3.jpg" />
<link rel="image_src" type="image/jpeg" href="/images/fb_icon3.jpg" />
<link rel="apple-touch-icon" href="/images/apple-touch-icon-iphone.png" /> 
<link rel="apple-touch-icon" sizes="72x72" href="/images/apple-touch-icon-ipad.png" /> 
<link rel="apple-touch-icon" sizes="114x114" href="/images/apple-touch-icon-iphone4.png" />
<link rel="apple-touch-icon" sizes="144x144" href="/images/apple-touch-icon-ipad3.png" />

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/style.css" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<?php /*<script type="text/javascript" src="http://fancybox.net/js/fancybox-1.3.4/jquery.easing-1.3.pack.js"></script>
    <script type="text/javascript" src="http://fancybox.net/js/fancybox-1.3.4/jquery.mousewheel-3.0.4.pack.js"></script> */?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/popup/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
    jQuery(document).ready(function(){
        
        jQuery("#mc_mv_EMAIL").click(function(){
            
            var v1=jQuery("#mc_mv_EMAIL").attr("value");
            
            if(v1=="EMAIL ID"){
                jQuery("#mc_mv_EMAIL").attr('value','');
            }
        });
        
         jQuery("#mc_mv_EMAIL").focusout(function(){
             var v1=jQuery("#mc_mv_EMAIL").attr("value");
             if(v1==''){
                 jQuery("#mc_mv_EMAIL").attr('value','EMAIL ID');
             }
        });
    });
</script>
<script type="text/javascript">
	adroll_adv_id = "6AYM7CE6HREORMXNAF2VP7";
	adroll_pix_id = "TW2RML7J55HP3EIE2NZZFG";
	(function () {
		var oldonload = window.onload;
		window.onload = function(){
		__adroll_loaded=true;
		var scr = document.createElement("script");
		var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
		scr.setAttribute('async', 'true');
		scr.type = "text/javascript";
		scr.src = host + "/j/roundtrip.js";
		((document.getElementsByTagName('head') || [null])[0] ||
		document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
		if(oldonload){oldonload()}};
	}());
</script>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-23596556-1']);
	_gaq.push(['_trackPageview']);

  	(function() {
    		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  	})();
</script>


<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/tooltipster.css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/jquery.tooltipster.js"></script>

</head>
<?php if(isset($_GET['mq'])) { ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/mq.css" media="screen" />
<?php } ?>

<body <?php body_class(); ?>>
<div id="header">
  <div class="header_inner">
    <div class="floatleft"><a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" > <img src="<?php bloginfo( 'template_url' ); ?>/images/logo.png" alt="" /></a></div>
    <div class="header_right">
      <div class="clear">
        <?php wp_nav_menu( array( 'menu' => 'header-home0','container'=> '','container_class' => '','items_wrap'=> '<ul id="%1$s" class="top_links">%3$s</ul>' ) ); ?>
        <?php dynamic_sidebar( 'home_heaer_social_links' ) ;?>
        <div class="floatright"><a href="<?php echo get_permalink(96)?>" class="register_now_btn"></a></div>
        <div class="clear"></div>
      </div>
      <div class="main_navigation">
        <?php wp_nav_menu( array( 'menu' => 'header-home' ) ); ?>
           <?php
            $args_upcoming_menu = array(
                'posts_per_page' => '4',
                'post_type' => 'events'
            );

            function AIOThemes_joinPOSTMETA_to_WPQueryMenu($join) {
                global $wp_query, $wpdb;


                $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

                return $join;
            }

            function edit_posts_orderbyMenu($orderby_statement) {
                $orderby_statement = "(DATE_FORMAT( STR_TO_DATE( meta_value,  '%Y-%m-%d %H:%i' ) ,  '%Y-%m-%d %H:%i' )) ASC";
                return $orderby_statement;
            }

            add_filter('posts_orderby', 'edit_posts_orderbyMenu');
            add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryMenu', 10, 2);

            add_filter('posts_where', 'my_posts_where_filterMenu', 10, 2);

            function my_posts_where_filterMenu($where_clause, $query_object) {

                $where_clause .= " AND meta_key='event_datetime' AND date_format(str_to_date(meta_value, '%Y-%m-%d %H:%i'), '%Y-%m-%d %H:%i') > '" . date('Y-m-d H:i') . "'";
                return $where_clause;
            }

            $upcoming_menu = query_posts($args_upcoming_menu);
            //echo $GLOBALS['wp_query']->request;  

            remove_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQueryMenu', 10, 2);
            remove_filter('posts_where', 'my_posts_where_filterMenu', 10, 2);
            remove_filter('posts_orderby', 'edit_posts_orderbyMenu');

          
                ?>
          
        <?php
      //  print_r($upcoming_menu);
                    if ($upcoming_menu) {
        ?>
          <script type="text/javascript">
          jQuery(document).ready(function(){
              
          var menu_str='<ul class="sub-menu"><li class="drop_top"></li>';
            
            <?php
                    foreach ($upcoming_menu as $post) {
                        
                        ?>
          menu_str=menu_str+'<li class="menu-item menu-item-type-post_type menu-item-object-post"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo (get_the_title()); ?> </a></li>';
        <?php 
        
        } ?>
            
        menu_str=menu_str+'</ul>';
       
      
      jQuery("li.events_menu a").after(menu_str);
  
          });   
  </script>
      <?php
                    }
                    
            wp_reset_query();
                     
            ?>
      </div>
    </div>
  </div>
</div>
