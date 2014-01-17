<?php
/**
 * Twenty Eleven functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyeleven_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width))
    $content_width = 584;

/**
 * Tell WordPress to run twentyeleven_setup() when the 'after_setup_theme' hook is run.
 */
add_action('after_setup_theme', 'twentyeleven_setup');

if (!function_exists('twentyeleven_setup')):

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override twentyeleven_setup() in a child theme, add your own twentyeleven_setup to your child theme's
     * functions.php file.
     *
     * @uses load_theme_textdomain() For translation/localization support.
     * @uses add_editor_style() To style the visual editor.
     * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
     * 	and backgrounds, and post formats.
     * @uses register_nav_menus() To add support for navigation menus.
     * @uses register_default_headers() To register the default custom header images provided with the theme.
     * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_setup() {

        /* Make Twenty Eleven available for translation.
         * Translations can be added to the /languages/ directory.
         * If you're building a theme based on Twenty Eleven, use a find and replace
         * to change 'twentyeleven' to the name of your theme in all the template files.
         */
        load_theme_textdomain('twentyeleven', get_template_directory() . '/languages');

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Load up our theme options page and related code.
        require( get_template_directory() . '/inc/theme-options.php' );

        // Grab Twenty Eleven's Ephemera widget.
        require( get_template_directory() . '/inc/widgets.php' );

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support('automatic-feed-links');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menu('primary', __('Primary Menu', 'twentyeleven'));

        // Add support for a variety of post formats
        add_theme_support('post-formats', array('aside', 'link', 'gallery', 'status', 'quote', 'image'));

        $theme_options = twentyeleven_get_theme_options();
        if ('dark' == $theme_options['color_scheme'])
            $default_background_color = '1d1d1d';
        else
            $default_background_color = 'e2e2e2';

        // Add support for custom backgrounds.
        add_theme_support('custom-background', array(
            // Let WordPress know what our default background color is.
            // This is dependent on our current color scheme.
            'default-color' => $default_background_color,
        ));

        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
        add_theme_support('post-thumbnails');

        // Add support for custom headers.
        $custom_header_support = array(
            // The default header text color.
            'default-text-color' => '000',
            // The height and width of our custom header.
            'width' => apply_filters('twentyeleven_header_image_width', 1000),
            'height' => apply_filters('twentyeleven_header_image_height', 288),
            // Support flexible heights.
            'flex-height' => true,
            // Random image rotation by default.
            'random-default' => true,
            // Callback for styling the header.
            'wp-head-callback' => 'twentyeleven_header_style',
            // Callback for styling the header preview in the admin.
            'admin-head-callback' => 'twentyeleven_admin_header_style',
            // Callback used to display the header preview in the admin.
            'admin-preview-callback' => 'twentyeleven_admin_header_image',
        );

        add_theme_support('custom-header', $custom_header_support);

        if (!function_exists('get_custom_header')) {
            // This is all for compatibility with versions of WordPress prior to 3.4.
            define('HEADER_TEXTCOLOR', $custom_header_support['default-text-color']);
            define('HEADER_IMAGE', '');
            define('HEADER_IMAGE_WIDTH', $custom_header_support['width']);
            define('HEADER_IMAGE_HEIGHT', $custom_header_support['height']);
            add_custom_image_header($custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback']);
            add_custom_background();
        }

        // We'll be using post thumbnails for custom header images on posts and pages.
        // We want them to be the size of the header image that we just defined
        // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
        set_post_thumbnail_size($custom_header_support['width'], $custom_header_support['height'], true);

        // Add Twenty Eleven's custom image sizes.
        // Used for large feature (header) images.
        add_image_size('large-feature', $custom_header_support['width'], $custom_header_support['height'], true);
        // Used for featured posts if a large-feature doesn't exist.
        add_image_size('small-feature', 500, 300);

        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        register_default_headers(array(
            'wheel' => array(
                'url' => '%s/images/headers/wheel.jpg',
                'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Wheel', 'twentyeleven')
            ),
            'shore' => array(
                'url' => '%s/images/headers/shore.jpg',
                'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Shore', 'twentyeleven')
            ),
            'trolley' => array(
                'url' => '%s/images/headers/trolley.jpg',
                'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Trolley', 'twentyeleven')
            ),
            'pine-cone' => array(
                'url' => '%s/images/headers/pine-cone.jpg',
                'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Pine Cone', 'twentyeleven')
            ),
            'chessboard' => array(
                'url' => '%s/images/headers/chessboard.jpg',
                'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Chessboard', 'twentyeleven')
            ),
            'lanterns' => array(
                'url' => '%s/images/headers/lanterns.jpg',
                'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Lanterns', 'twentyeleven')
            ),
            'willow' => array(
                'url' => '%s/images/headers/willow.jpg',
                'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Willow', 'twentyeleven')
            ),
            'hanoi' => array(
                'url' => '%s/images/headers/hanoi.jpg',
                'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Hanoi Plant', 'twentyeleven')
            )
        ));
    }

endif; // twentyeleven_setup

if (!function_exists('twentyeleven_header_style')) :

    /**
     * Styles the header image and text displayed on the blog
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_header_style() {
        $text_color = get_header_textcolor();

        // If no custom options for text are set, let's bail.
        if ($text_color == HEADER_TEXTCOLOR)
            return;

        // If we get this far, we have custom styles. Let's do this.
        ?>
<?php
    }

endif; // twentyeleven_header_style

if (!function_exists('twentyeleven_admin_header_style')) :

    /**
     * Styles the header image displayed on the Appearance > Header admin panel.
     *
     * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_admin_header_style() {
        ?>
<style type="text/css">
.appearance_page_custom-header #headimg {
	border: none;
}
#headimg h1, #desc {
	font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
}
#headimg h1 {
	margin: 0;
}
#headimg h1 a {
	font-size: 32px;
	line-height: 36px;
	text-decoration: none;
}
#desc {
	font-size: 14px;
	line-height: 23px;
	padding: 0 0 3em;
}
#headimg img {
	max-width: 1000px;
	height: auto;
	width: 100%;
}
</style>
<?php
    }

endif; // twentyeleven_admin_header_style

if (!function_exists('twentyeleven_admin_header_image')) :

    /**
     * Custom header image markup displayed on the Appearance > Header admin panel.
     *
     * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_admin_header_image() {
        ?>
<div id="headimg">
  <?php
            $color = get_header_textcolor();
            $image = get_header_image();
            if ($color && $color != 'blank')
                $style = ' style="color:#' . $color . '"';
            else
                $style = ' style="display:none"';
            ?>
  <h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url(home_url('/')); ?>">
    <?php bloginfo('name'); ?>
    </a></h1>
  <div id="desc"<?php echo $style; ?>>
    <?php bloginfo('description'); ?>
  </div>
  <?php if ($image) : ?>
  <img src="<?php echo esc_url($image); ?>" alt="" />
  <?php endif; ?>
</div>
<?php
    }

endif; // twentyeleven_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function twentyeleven_excerpt_length($length) {
    return 40;
}

add_filter('excerpt_length', 'twentyeleven_excerpt_length');

if (!function_exists('twentyeleven_continue_reading_link')) :

    /**
     * Returns a "Continue Reading" link for excerpts
     */
    function twentyeleven_continue_reading_link() {
        return ' <a href="' . esc_url(get_permalink()) . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven') . '</a>';
    }

endif; // twentyeleven_continue_reading_link

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyeleven_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function twentyeleven_auto_excerpt_more($more) {
    return ' &hellip;' . twentyeleven_continue_reading_link();
}

add_filter('excerpt_more', 'twentyeleven_auto_excerpt_more');

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function twentyeleven_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= twentyeleven_continue_reading_link();
    }
    return $output;
}

add_filter('get_the_excerpt', 'twentyeleven_custom_excerpt_more');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function twentyeleven_page_menu_args($args) {
    if (!isset($args['show_home']))
        $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'twentyeleven_page_menu_args');

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

    register_widget('Twenty_Eleven_Ephemera_Widget');


    register_sidebar(array(
        'name' => __('Home Header Social Links', 'twentyeleven'),
        'id' => 'home_heaer_social_links',
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => '',
    ));


    register_sidebar(array(
        'name' => __('Left Navigation Menu', 'twentyeleven'),
        'id' => 'left_navigation_menu',
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Inner Page Header Social Links', 'twentyeleven'),
        'id' => 'innerpage_heaer_social_links',
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => '',
    ));


    register_sidebar(array(
        'name' => __('Main Sidebar', 'twentyeleven'),
        'id' => 'sidebar-1',
        'before_widget' => '<div class="page_list">',
        'after_widget' => "</div>",
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Showcase Sidebar', 'twentyeleven'),
        'id' => 'sidebar-2',
        'description' => __('The sidebar for the optional Showcase Template', 'twentyeleven'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area One', 'twentyeleven'),
        'id' => 'sidebar-3',
        'description' => __('An optional widget area for your site footer', 'twentyeleven'),
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '<h6>',
        'after_title' => '</h6>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area Two', 'twentyeleven'),
        'id' => 'sidebar-4',
        'description' => __('An optional widget area for your site footer', 'twentyeleven'),
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '<h6>',
        'after_title' => '</h6>',
    ));

    register_sidebar(array(
        'name' => __('Footer Area Three', 'twentyeleven'),
        'id' => 'sidebar-5',
        'description' => __('An optional widget area for your site footer', 'twentyeleven'),
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Newsletter Footer Area', 'twentyeleven'),
        'id' => 'sidebar-6',
        'description' => __('An optional widget area for your site footer', 'twentyeleven'),
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '<h6>',
        'after_title' => '</h6>',
    ));
    
    register_sidebar(array(
        'name' => __('Text Below Next event Area', 'twentyeleven'),
        'id' => 'sidebar-7',
        'description' => __('An optional widget area for your site footer', 'twentyeleven'),
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => '',
    ));
}

add_action('widgets_init', 'twentyeleven_widgets_init');

if (!function_exists('twentyeleven_content_nav')) :

    /**
     * Display navigation to next/previous pages when applicable
     */
    function twentyeleven_content_nav($html_id) {
        global $wp_query;
        
        /*if ( function_exists( 'wp_paginate' ) ) {
			wp_paginate();
		}
		else { */

        if ($wp_query->max_num_pages > 1) :
            ?>
<nav id="<?php echo esc_attr($html_id); ?>">
  <h3 class="assistive-text">
    <?php _e('Post navigation', 'twentyeleven'); ?>
  </h3>
  <div class="nav-previous">
    <?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven')); ?>
  </div>
  <div class="nav-next">
    <?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven')); ?>
  </div>
</nav>
<!-- #nav-above -->
<?php
        endif; 
      /* } */
    }

endif; // twentyeleven_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
    if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches))
        return false;

    return esc_url_raw($matches[1]);
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentyeleven_footer_sidebar_class() {
    $count = 0;

    if (is_active_sidebar('sidebar-3'))
        $count++;

    if (is_active_sidebar('sidebar-4'))
        $count++;

    if (is_active_sidebar('sidebar-5'))
        $count++;

    $class = '';

    switch ($count) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
    }

    if ($class)
        echo 'class="' . $class . '"';
}

if (!function_exists('twentyeleven_comment')) :

    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own twentyeleven_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
<li class="post pingback">
  <p>
    <?php _e('Pingback:', 'twentyeleven'); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link(__('Edit', 'twentyeleven'), '<span class="edit-link">', '</span>'); ?>
  </p>
  <?php
                                break;
                            default :
                                ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <article id="comment-<?php comment_ID(); ?>" class="comment">
    <footer class="comment-meta">
      <div class="comment-author vcard">
        <?php
                            $avatar_size = 68;
                            if ('0' != $comment->comment_parent)
                                $avatar_size = 39;

                            echo "<div class='floatleft'>".get_avatar($comment, $avatar_size)."</div><div class='comment_content'>";

                            /* translators: 1: comment author, 2: date and time */
                            printf(__('%1$s %2$s <span class="says">said:</span>', 'twentyeleven'), sprintf('<span class="fn">%s</span>', get_comment_author_link()), sprintf('<time datetime="%2$s">%3$s</time>', esc_url(get_comment_link($comment->comment_ID)), get_comment_time('c'),
                                            /* translators: 1: date, 2: time */ sprintf(__('%1$s at %2$s', 'twentyeleven'), get_comment_date(), get_comment_time())
                                    )
                            );
                            ?>
        <?php edit_comment_link(__('Edit', 'twentyeleven'), '<span class="edit-link">', '</span>'); ?>
         <div class="comment-content">
      <?php comment_text(); ?>
    </div>
    <div class="reply">
      <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply <span>&darr;</span>', 'twentyeleven'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
    </div></div>
      </div>
      <!-- .comment-author .vcard -->
      
      <?php if ($comment->comment_approved == '0') : ?>
      <em class="comment-awaiting-moderation">
      <?php _e('Your comment is awaiting moderation.', 'twentyeleven'); ?>
      </em> <br />
      <?php endif; ?>
    </footer>
   
    <!-- .reply --> 
  </article>
  <!-- #comment-## -->
  
  <?php
                    break;
            endswitch;
        }

    endif; // ends check for twentyeleven_comment()

    if (!function_exists('twentyeleven_posted_on')) :

        /**
         * Prints HTML with meta information for the current post-date/time and author.
         * Create your own twentyeleven_posted_on to override in a child theme
         *
         * @since Twenty Eleven 1.0
         */
        function twentyeleven_posted_on() {
            printf(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'twentyeleven'), get_the_author())), get_the_author()
            );
        }

    endif;

    /**
     * Adds two classes to the array of body classes.
     * The first is if the site has only had one author with published posts.
     * The second is if a singular post being displayed
     *
     * @since Twenty Eleven 1.0
     */
    function twentyeleven_body_classes($classes) {

        if (function_exists('is_multi_author') && !is_multi_author())
            $classes[] = 'single-author';

        if (is_singular() && !is_home() && !is_page_template('showcase.php') && !is_page_template('sidebar-page.php'))
            $classes[] = 'singular';

        return $classes;
    }

    add_filter('body_class', 'twentyeleven_body_classes');

    add_action('add_meta_boxes', 'phase_events');

    function phase_events() {
        add_meta_box(
                'phase_events', __('Event Phase', 'myplugin_textdomain'), 'phase_dropdown', 'events', 'normal', 'high'
        );
    }

    function phase_dropdown($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'phase_dropdown_nonce');

        $phase = get_post_meta($post->ID, 'phase', true);
        //team_drp_down('team_drpdwn','team_drpdwn','',array($team_id));
        $signup = '';
        $closedprerace = '';
        $closedpostrace = '';
        if ($phase == 'signup')
            $signup = "selected='selected'";
        if ($phase == 'closedprerace')
            $closedprerace = "selected='selected'";
        if ($phase == 'closedpostrace')
            $closedpostrace = "selected='selected'";


        echo "<select name='phase' id='phase'><option value='signup' " . $signup . ">Signup</option>
            <option value='closedprerace' " . $closedprerace . ">Closed,pre-race</option>
            <option value='closedpostrace' " . $closedpostrace . ">Closed,post-race</option>
           </select>";
    }

    add_action('save_post', 'phase_dropdown_save');

    function phase_dropdown_save($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!wp_verify_nonce($_POST['phase_dropdown_nonce'], plugin_basename(__FILE__)))
            return;

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return;
        }
        $product_price = $_POST['phase'];
        update_post_meta($post_id, 'phase', $product_price);
    }

    add_action('add_meta_boxes', 'event_detail_tabs');

    function event_detail_tabs() {
        add_meta_box(
                'event_detail_tabs', __('Event Detail Tabs', 'myplugin_textdomain'), 'event_detail_tabs_area', 'events', 'normal', 'high'
        );
    }

    function event_detail_tabs_area($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'event_detail_tabs_area_nonce');
        
        
        

        $signup_competition                     = get_post_meta($post->ID, 'signup_competition', true);
        $signup_competition2                    = get_post_meta($post->ID, 'signup_competition2', true);
        $signup_competition3                    = get_post_meta($post->ID, 'signup_competition3', true);
        $signup_competition_map                 = get_post_meta($post->ID, 'signup_competition_map', true);
        $signup_travel_info                     = get_post_meta($post->ID, 'signup_travel_info', true);
        $signup_raceday_info                    = get_post_meta($post->ID, 'signup_raceday_info', true);
        $signup_media_results                   = get_post_meta($post->ID, 'signup_media_results', true);
        $signup_media_album                     =   get_post_meta($post->ID, 'signup_media_album',true);
        
        $signup_competition_header_image        = get_post_meta($post->ID, 'signup_competition_header_image', true);
        $signup_competition_map_header_image    = get_post_meta($post->ID, 'signup_competition_map_header_image', true);
        $signup_travel_info_header_image        = get_post_meta($post->ID, 'signup_travel_info_header_image', true);
        $signup_raceday_info_header_image       = get_post_meta($post->ID, 'signup_raceday_info_header_image', true);
        $signup_media_results_header_image      = get_post_meta($post->ID, 'signup_media_results_header_image', true);
        
        $signup_competition_header_image_id        = get_post_meta($post->ID, 'signup_competition_header_image_id', true);
        $signup_competition_map_header_image_id    = get_post_meta($post->ID, 'signup_competition_map_header_image_id', true);
        $signup_travel_info_header_image_id        = get_post_meta($post->ID, 'signup_travel_info_header_image_id', true);
        $signup_raceday_info_header_image_id       = get_post_meta($post->ID, 'signup_raceday_info_header_image_id', true);
        $signup_media_results_header_image_id      = get_post_meta($post->ID, 'signup_media_results_header_image_id', true);
        
        
        $signup_show_default                    = get_post_meta($post->ID, 'signup_show_default',true);
        
        
        $cpr_competition                        = get_post_meta($post->ID, 'cpr_competition', true);
        $cpr_competition2                        = get_post_meta($post->ID, 'cpr_competition2', true);
        $cpr_competition3                        = get_post_meta($post->ID, 'cpr_competition3', true);
        $cpr_competition_map                    = get_post_meta($post->ID, 'cpr_competition_map', true);
        $cpr_travel_info                        = get_post_meta($post->ID, 'cpr_travel_info', true);
        $cpr_raceday_info                       = get_post_meta($post->ID, 'cpr_raceday_info', true);
        $cpr_media_results                      = get_post_meta($post->ID, 'cpr_media_results', true);
        $cpr_media_album                     =   get_post_meta($post->ID, 'cpr_media_album',true);
        
        $cpr_competition_header_image           = get_post_meta($post->ID, 'cpr_competition_header_image', true);
        $cpr_competition_map_header_image       = get_post_meta($post->ID, 'cpr_competition_map_header_image', true);
        $cpr_travel_info_header_image           = get_post_meta($post->ID, 'cpr_travel_info_header_image', true);
        $cpr_raceday_info_header_image          = get_post_meta($post->ID, 'cpr_raceday_info_header_image', true);
        $cpr_media_results_header_image         = get_post_meta($post->ID, 'cpr_media_results_header_image', true);
        
        $cpr_competition_header_image_id           = get_post_meta($post->ID, 'cpr_competition_header_image_id', true);
        $cpr_competition_map_header_image_id       = get_post_meta($post->ID, 'cpr_competition_map_header_image_id', true);
        $cpr_travel_info_header_image_id           = get_post_meta($post->ID, 'cpr_travel_info_header_image_id', true);
        $cpr_raceday_info_header_image_id          = get_post_meta($post->ID, 'cpr_raceday_info_header_image_id', true);
        $cpr_media_results_header_image_id         = get_post_meta($post->ID, 'cpr_media_results_header_image_id', true);
        
        
        $cpr_show_default                       = get_post_meta($post->ID, 'cpr_show_default',true);
        
        
        $cpr2_competition                       = get_post_meta($post->ID, 'cpr2_competition', true);
        $cpr2_competition2                       = get_post_meta($post->ID, 'cpr2_competition2', true);
        $cpr2_competition3                       = get_post_meta($post->ID, 'cpr2_competition3', true);
        $cpr2_competition_map                   = get_post_meta($post->ID, 'cpr2_competition_map', true);
        $cpr2_travel_info                       = get_post_meta($post->ID, 'cpr2_travel_info', true);
        $cpr2_raceday_info                      = get_post_meta($post->ID, 'cpr2_raceday_info', true);
        $cpr2_media_results                     = get_post_meta($post->ID, 'cpr2_media_results', true);
        $cpr2_media_album                     =   get_post_meta($post->ID, 'cpr2_media_album',true);
        
        $cpr2_competition_header_image          = get_post_meta($post->ID, 'cpr2_competition_header_image', true);
        $cpr2_competition_map_header_image      = get_post_meta($post->ID, 'cpr2_competition_map_header_image', true);
        $cpr2_travel_info_header_image          = get_post_meta($post->ID, 'cpr2_travel_info_header_image', true);
        $cpr2_raceday_info_header_image         = get_post_meta($post->ID, 'cpr2_raceday_info_header_image', true);
        $cpr2_media_results_header_image        = get_post_meta($post->ID, 'cpr2_media_results_header_image', true);
        
        $cpr2_competition_header_image_id          = get_post_meta($post->ID, 'cpr2_competition_header_image_id', true);
        $cpr2_competition_map_header_image_id      = get_post_meta($post->ID, 'cpr2_competition_map_header_image_id', true);
        $cpr2_travel_info_header_image_id          = get_post_meta($post->ID, 'cpr2_travel_info_header_image_id', true);
        $cpr2_raceday_info_header_image_id         = get_post_meta($post->ID, 'cpr2_raceday_info_header_image_id', true);
        $cpr2_media_results_header_image_id        = get_post_meta($post->ID, 'cpr2_media_results_header_image_id', true);
        
        
        $cpr2_show_default                      = get_post_meta($post->ID, 'cpr2_show_default',true);

        $args = array(
            'textarea_rows' => 15,
            'teeny' => true,
            'quicktags' => true,
            'wpautop' => false
        );
        
         $phase = get_post_meta($post->ID, 'phase', true);
         
         $signup_tabs='';
         $closedprerace_tabs='';
         $closedpostrace_tabs='';
         if($phase!=''){
             if($phase=='closedprerace'){
               $signup_tabs="display:none;";
               $closedpostrace_tabs="display:none;";
             }
             if($phase=='closedpostrace'){
               $signup_tabs="display:none;";
               $closedprerace_tabs="display:none;";
             }
             if($phase=='signup'){
               $closedprerace_tabs="display:none;";
               $closedpostrace_tabs="display:none;";
             }
             
         }
         else{
                 $closedprerace_tabs="display:none;";
               $closedpostrace_tabs="display:none;";
         }
        ?>
  
  <!-- Image Thumbnail --> 
  
  <script type="text/javascript">
            jQuery(document).ready(function($){

                $("#phase").change(function(){
                    
                    var drp_val= this.value;
                    
                    if(drp_val=='signup'){
                        $("#closedpostrace_tabs").hide();
                        $("#closedprerace_tabs").hide();
                        $("#signup_tabs").show();
                    }
                    
                    if(drp_val=='closedpostrace'){
                        $("#closedpostrace_tabs").show();
                        $("#closedprerace_tabs").hide();
                        $("#signup_tabs").hide();
                    }
                    
                    if(drp_val=='closedprerace'){
                        $("#closedpostrace_tabs").hide();
                        $("#closedprerace_tabs").show();
                        $("#signup_tabs").hide();
                    }
                });    
                    
                $('.custom_media_upload').click(function() {

                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = $(this);

                    wp.media.editor.send.attachment = function(props, attachment) {
 
                        $(button).prev().prev().attr('src', attachment.url);
                        $(button).prev().val(attachment.url);
                        $(button).prev().prev().prev().val(attachment.id);

                        wp.media.editor.send.attachment = send_attachment_bkp;
                    }

                    wp.media.editor.open(button);

                    return false;       
                });

            });    
             
            jQuery(function() {jQuery('#signup_tabs').tabs();});
            jQuery(function() {jQuery('#closedprerace_tabs').tabs();});
            jQuery(function() {jQuery('#closedpostrace_tabs').tabs();});
             
        </script>
  <?php
     $args = array(
                    'post_type' => 'cmc_media',
                    'posts_per_page' => -1
                     
                );
     
  	 
      
         
        
    
                $results = get_posts($args);
             
                
    ?>
  <!-- SIGNUP PHASE-->
  
  <div id="signup_tabs" style="<?php echo $signup_tabs;?>" > <strong>Signup Phase</strong><br/>
    <ul>
      <li><a href="#tabs-1">Competition</a></li>
      <li><a href="#tabs-3">Competition Map</a></li>
      <li><a href="#tabs-4">Travel Info</a></li>
      <li><a href="#tabs-5">Race Day Info</a></li>
      <li><a href="#tabs-6">Media & Result map</a></li>
    </ul>
    <div id="tabs-1">
      <?php wp_editor($signup_competition, 'signup_competition', $args); ?>
      <br>
      Please use <b>"[competition][/competition]"</b> (without quote) in editor where you want to show Competition list that you created in admin panel. <a href="<?php echo home_url("wp-admin/edit.php?post_type=competition")?>">click here</a> <br>
      <br>
      <b>AWARDS </b><br>
      <?php wp_editor($signup_competition2, 'signup_competition2', $args); ?>
      <br>
      <br>
      <b>PRICE PER PARTICIPANT</b><br>
      <?php wp_editor($signup_competition3, 'signup_competition3', $args); ?>
      <label>Competition header image</label>
      <br/>
      <input  type="hidden" name="signup_competition_header_image_id" value="<?php echo $signup_competition_header_image_id;?>" />
      <img class="custom_media_image" src="<?php echo $signup_competition_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="signup_competition_header_image" type="text" name="signup_competition_header_image" value="<?php echo $signup_competition_header_image; ?>" 
                       style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="signup_show_default" value="signup_competition" <?php if($signup_show_default=='signup_competition'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-3">
      <?php wp_editor($signup_competition_map, 'signup_competition_map', $args); ?>
      <label>Competition Map header image</label>
      <br/>
      <input  type="hidden" name="signup_competition_map_header_image_id" value="<?php echo $signup_competition_map_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $signup_competition_map_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="signup_competition_map_header_image" type="text" name="signup_competition_map_header_image" value="<?php echo $signup_competition_map_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="signup_show_default" value="signup_competition_map" <?php if($signup_show_default=='signup_competition_map'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-4">
      <?php wp_editor($signup_travel_info, 'signup_travel_info', $args); ?>
      <label>Travel Info header image</label>
      <br/>
      <input  type="hidden" name="signup_travel_info_header_image_id" value="<?php echo $signup_travel_info_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $signup_travel_info_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="signup_travel_info_header_image" type="text" name="signup_travel_info_header_image" value="<?php echo $signup_travel_info_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="signup_show_default" value="signup_travel_info" <?php if($signup_show_default=='signup_travel_info'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-5">
      <?php wp_editor($signup_raceday_info, 'signup_raceday_info', $args); ?>
      <label>Race day Info header image</label>
      <br/>
      <input  type="hidden" name="signup_raceday_info_header_image_id" value="<?php echo $signup_raceday_info_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $signup_raceday_info_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="signup_raceday_info_header_image" type="text" name="signup_raceday_info_header_image" value="<?php echo $signup_raceday_info_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="signup_show_default" value="signup_raceday_info" <?php if($signup_show_default=='signup_raceday_info'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-6">
      <?php wp_editor($signup_media_results, 'signup_media_results', $args); ?>
      <br/>
      <label>Select Album</label>
      <br/>
      <select name="signup_media_album" id="signup_media_album">
        <?php
                
                if($results){
                     echo'<option value="">Select Album</option>';
                      for ($k = 0; $k < count($results); $k++) {
                       if($results[$k]->ID==$signup_media_album)
                           $selected='selected="selected"';
                       else
                           $selected='';
                       ?>
        <option value="<?php echo $results[$k]->ID?>" <?php echo $selected; ?>><?php echo $results[$k]->post_title;  ?></option>
        <?php                             
                      }
                }
                else{
                    echo'<option value="">No Album</option>';
                }
                $selected='';
                ?>
      </select>
      <br/>
      <label>Media & Result header image</label>
      <br/>
      <input  type="hidden" name="signup_media_results_header_image_id" value="<?php echo $signup_media_results_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $signup_media_results_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="signup_media_results_header_image" type="text" name="signup_media_results_header_image" value="<?php echo $signup_media_results_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="signup_show_default" value="signup_media_results" <?php if($signup_show_default=='signup_media_results'){?> checked="checked" <?php }?> />
    </div>
  </div>
  
  <!-- SIGNUP PHASE--> 
  
  <!-- CLOSED PRE RACE PHASE-->
  
  <div id="closedprerace_tabs" style="<?php echo $closedprerace_tabs;?>"> <strong>Closed, Pre Race Phase</strong><br/>
    <ul>
      <li><a href="#tabs-7">Competition</a></li>
      <li><a href="#tabs-8">Competition Map</a></li>
      <li><a href="#tabs-9">Travel Info</a></li>
      <li><a href="#tabs-10">Race Day Info</a></li>
      <li><a href="#tabs-11">Media & Result map</a></li>
    </ul>
    <div id="tabs-7">
      <?php wp_editor($cpr_competition, 'cpr_competition', $args); ?>
      <br>
      Please use <b>"[competition][/competition]"</b> (without quote) in editor where you want to show Competition list that you created in admin panel. <a href="<?php echo home_url("wp-admin/edit.php?post_type=competition")?>">click here</a> <br>
      <br>
      <b>AWARDS</b><br>
      <?php wp_editor($cpr_competition2, 'cpr_competition2', $args); ?>
      <br>
      <br>
      <b>PRICE PER PARTICIPANT</b><br>
      <?php wp_editor($cpr_competition3, 'cpr_competition3', $args); ?>
      <label>Competition header image</label>
      <br/>
      <input  type="hidden" name="cpr_competition_header_image_id" value="<?php echo $cpr_competition_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr_competition_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr_competition_header_image" type="text" name="cpr_competition_header_image" value="<?php echo $cpr_competition_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr_show_default" value="cpr_competition" <?php if($cpr_show_default=='cpr_competition'){?> checked="checked" <?php }?>/>
    </div>
    <div id="tabs-8">
      <?php wp_editor($cpr_competition_map, 'cpr_competition_map', $args); ?>
      <label>Competition Map header image</label>
      <br/>
      <input  type="hidden" name="cpr_competition_map_header_image_id" value="<?php echo $cpr_competition_map_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr_competition_map_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr_competition_map_header_image" type="text" name="cpr_competition_map_header_image" value="<?php echo $cpr_competition_map_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr_show_default" value="cpr_competition_map" <?php if($cpr_show_default=='cpr_competition_map'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-9">
      <?php wp_editor($cpr_travel_info, 'cpr_travel_info', $args); ?>
      <label>Travel Info header image</label>
      <br/>
      <input  type="hidden" name="cpr_travel_info_header_image_id" value="<?php echo $cpr_travel_info_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr_travel_info_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr_travel_info_header_image" type="text" name="cpr_travel_info_header_image" value="<?php echo $cpr_travel_info_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr_show_default" value="cpr_travel_info" <?php if($cpr_show_default=='cpr_travel_info'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-10">
      <?php wp_editor($cpr_raceday_info, 'cpr_raceday_info', $args); ?>
      <label>Race day Info header image</label>
      <br/>
      <input  type="hidden" name="cpr_raceday_info_header_image_id" value="<?php echo $cpr_raceday_info_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr_raceday_info_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr_raceday_info_header_image" type="text" name="cpr_raceday_info_header_image" value="<?php echo $cpr_raceday_info_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr_show_default" value="cpr_raceday_info" <?php if($cpr_show_default=='cpr_raceday_info'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-11">
      <?php wp_editor($cpr_media_results, 'cpr_media_results', $args); ?>
      <br/>
      <label>Select Album</label>
      <br/>
      <select name="cpr_media_album" id="cpr_media_album">
        <?php
                
                if($results){
                     echo'<option value="">Select Album</option>';
                      for ($k = 0; $k < count($results); $k++) {
                       if($results[$k]->ID==$cpr_media_album)
                           $selected='selected="selected"';
                       else
                           $selected='';
                       ?>
        <option value="<?php echo $results[$k]->ID?>" <?php echo $selected; ?>><?php echo $results[$k]->post_title;  ?></option>
        <?php                             
                      }
                }
                else{
                    echo'<option value="">No Album</option>';
                }
                $selected='';
                ?>
      </select>
      <br/>
      <label>Media & Result header image</label>
      <br/>
      <input  type="hidden" name="cpr_media_results_header_image_id" value="<?php echo $cpr_media_results_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr_media_results_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr_media_results_header_image" type="text" name="cpr_media_results_header_image" value="<?php echo $cpr_media_results_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr_show_default" value="cpr_media_results" <?php if($cpr_show_default=='cpr_media_results'){?> checked="checked" <?php }?> />
    </div>
  </div>
  
  <!-- CLOSED PRE RACE PHASE--> 
  
  <!-- CLOSED POST RACE PHASE-->
  
  <div id="closedpostrace_tabs" style="<?php echo $closedpostrace_tabs;?>"> <strong>Closed, Post Race Phase</strong><br/>
    <ul>
      <li><a href="#tabs-12">Competition</a></li>
      <li><a href="#tabs-13">Competition Map</a></li>
      <li><a href="#tabs-14">Travel Info</a></li>
      <li><a href="#tabs-15">Race Day Info</a></li>
      <li><a href="#tabs-16">Media & Result map</a></li>
    </ul>
    <div id="tabs-12">
      <?php wp_editor($cpr2_competition, 'cpr2_competition', $args); ?>
      <br>
      Please use <b>"[competition][/competition]"</b> (without quote) in editor where you want to show Competition list that you created in admin panel. <a href="<?php echo home_url("wp-admin/edit.php?post_type=competition")?>">click here</a> <br>
      <br>
      <b>AWARDS</b><br>
      <?php wp_editor($cpr2_competition2, 'cpr2_competition2', $args); ?>
      <br>
      <br>
      <b>PRICE PER PARTICIPANT</b><br>
      <?php wp_editor($cpr2_competition3, 'cpr2_competition3', $args); ?>
      <label>Competition header image</label>
      <br/>
      <input  type="hidden" name="cpr2_competition_header_image_id"  value="<?php echo $cpr2_competition_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr2_competition_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr2_competition_header_image" type="text" name="cpr2_competition_header_image" value="<?php echo $cpr2_competition_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr2_show_default" value="cpr2_competition" <?php if($cpr2_show_default=='cpr2_competition'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-13">
      <?php wp_editor($cpr2_competition_map, 'cpr2_competition_map', $args); ?>
      <label>Competition Map header image</label>
      <br/>
      <input  type="hidden" name="cpr2_competition_map_header_image_id"  value="<?php echo $cpr2_competition_map_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr2_competition_map_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr2_competition_map_header_image" type="text" name="cpr2_competition_map_header_image" value="<?php echo $cpr2_competition_map_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr2_show_default" value="cpr2_competition_map" <?php if($cpr2_show_default=='cpr2_competition_map'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-14">
      <?php wp_editor($cpr2_travel_info, 'cpr2_travel_info', $args); ?>
      <label>Travel Info header image</label>
      <br/>
      <input  type="hidden" name="cpr2_travel_info_header_image_id"  value="<?php echo $cpr2_travel_info_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr2_travel_info_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr2_travel_info_header_image" type="text" name="cpr2_travel_info_header_image" value="<?php echo $cpr2_travel_info_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr2_show_default" value="cpr2_travel_info" <?php if($cpr2_show_default=='cpr2_travel_info'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-15">
      <?php wp_editor($cpr2_raceday_info, 'cpr2_raceday_info', $args); ?>
      <label>Race day Info header image</label>
      <br/>
      <input  type="hidden" name="cpr2_raceday_info_header_image_id"  value="<?php echo $cpr2_raceday_info_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr2_raceday_info_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr2_raceday_info_header_image" type="text" name="cpr2_raceday_info_header_image" value="<?php echo $cpr2_raceday_info_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr2_show_default" value="cpr2_raceday_info" <?php if($cpr2_show_default=='cpr2_raceday_info'){?> checked="checked" <?php }?> />
    </div>
    <div id="tabs-16">
      <?php wp_editor($cpr2_media_results, 'cpr2_media_results', $args); ?>
      <br/>
      <label>Select Album</label>
      <br/>
      <select name="cpr2_media_album" id="cpr2_media_album">
        <?php
                
                if($results){
                     echo'<option value="">Select Album</option>';
                      for ($k = 0; $k < count($results); $k++) {
                       if($results[$k]->ID==$cpr2_media_album)
                           $selected='selected="selected"';
                       else
                           $selected='';
                       ?>
        <option value="<?php echo $results[$k]->ID?>" <?php echo $selected; ?>><?php echo $results[$k]->post_title;  ?></option>
        <?php                             
                      }
                }
                else{
                    echo'<option value="">No Album</option>';
                }
                $selected='';
                ?>
      </select>
      <br/>
      <label>Media & Result header image</label>
      <br/>
      <input  type="hidden" name="cpr2_media_results_header_image_id"  value="<?php echo $cpr2_media_results_header_image_id;?>"/>
      <img class="custom_media_image" src="<?php echo $cpr2_media_results_header_image; ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" /> 
      <!-- Upload button and text field -->
      <input class="custom_media_url" id="cpr2_media_results_header_image" type="text" name="cpr2_media_results_header_image" value="<?php echo $cpr2_media_results_header_image; ?>" style="margin-bottom:10px; clear:right;">
      <a href="#" class="button custom_media_upload">Upload</a><br/>Image size should be 1128px x 286px.<br/><br />
      <label>Display this section first:</label>
      &nbsp; Yes&nbsp;
      <input type="radio" name="cpr2_show_default" value="cpr2_media_results" <?php if($cpr2_show_default=='cpr2_media_results'){?> checked="checked" <?php }?> />
    </div>
  </div>
  
  <!-- CLOSED POST RACE PHASE-->
  
  <?php
    }

    add_action('save_post', 'event_detail_tabs_area_save');

    function event_detail_tabs_area_save($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!wp_verify_nonce($_POST['event_detail_tabs_area_nonce'], plugin_basename(__FILE__)))
            return;

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return;
        }

       /* $signup_competition = get_post_meta($post->ID, 'signup_competition', true);
        $signup_competition_map = get_post_meta($post->ID, 'signup_competition_map', true);
        $signup_travel_info = get_post_meta($post->ID, 'signup_travel_info', true);
        $signup_raceday_info = get_post_meta($post->ID, 'signup_raceday_info', true);
        $signup_media_results = get_post_meta($post->ID, 'signup_media_results', true);*/
        
        $signup_competition = $_POST['signup_competition'];
        update_post_meta($post_id, 'signup_competition', $signup_competition);
        $signup_competition2 = $_POST['signup_competition2'];
        update_post_meta($post_id, 'signup_competition2', $signup_competition2);
        $signup_competition3 = $_POST['signup_competition3'];
        update_post_meta($post_id, 'signup_competition3', $signup_competition3);
        $signup_competition_map = $_POST['signup_competition_map'];
        update_post_meta($post_id, 'signup_competition_map', $signup_competition_map);
        $signup_travel_info = $_POST['signup_travel_info'];
        update_post_meta($post_id, 'signup_travel_info', $signup_travel_info);
        $signup_raceday_info = $_POST['signup_raceday_info'];
        update_post_meta($post_id, 'signup_raceday_info', $signup_raceday_info);
        $signup_media_results = $_POST['signup_media_results'];
        update_post_meta($post_id, 'signup_media_results', $signup_media_results);
        $signup_media_album = $_POST['signup_media_album'];
        update_post_meta($post_id, 'signup_media_album', $signup_media_album);
        
        
        $signup_competition_header_image = $_POST['signup_competition_header_image'];
        update_post_meta($post_id, 'signup_competition_header_image', $signup_competition_header_image);
        $signup_competition_map_header_image = $_POST['signup_competition_map_header_image'];
        update_post_meta($post_id, 'signup_competition_map_header_image', $signup_competition_map_header_image);
        $signup_travel_info_header_image = $_POST['signup_travel_info_header_image'];
        update_post_meta($post_id, 'signup_travel_info_header_image', $signup_travel_info_header_image);
        $signup_raceday_info_header_image = $_POST['signup_raceday_info_header_image'];
        update_post_meta($post_id, 'signup_raceday_info_header_image', $signup_raceday_info_header_image);
        $signup_media_results_header_image = $_POST['signup_media_results_header_image'];
        update_post_meta($post_id, 'signup_media_results_header_image', $signup_media_results_header_image);
        
        
        $signup_competition_header_image_id = $_POST['signup_competition_header_image_id'];
        update_post_meta($post_id, 'signup_competition_header_image_id', $signup_competition_header_image_id);
        
        $signup_competition_map_header_image_id = $_POST['signup_competition_map_header_image_id'];
        update_post_meta($post_id, 'signup_competition_map_header_image_id', $signup_competition_map_header_image_id);
        
        $signup_travel_info_header_image_id = $_POST['signup_travel_info_header_image_id'];
        update_post_meta($post_id, 'signup_travel_info_header_image_id', $signup_travel_info_header_image_id);
        
        $signup_raceday_info_header_image_id = $_POST['signup_raceday_info_header_image_id'];
        update_post_meta($post_id, 'signup_raceday_info_header_image_id', $signup_raceday_info_header_image_id);
        
        $signup_media_results_header_image_id = $_POST['signup_media_results_header_image_id'];
        update_post_meta($post_id, 'signup_media_results_header_image_id', $signup_media_results_header_image_id);
        
        
        $signup_show_default    =   $_POST['signup_show_default'];
        update_post_meta($post_id, 'signup_show_default', $signup_show_default);
        
        
        
        $cpr_competition = $_POST['cpr_competition'];
        update_post_meta($post_id, 'cpr_competition', $cpr_competition);
        $cpr_competition2 = $_POST['cpr_competition2'];
        update_post_meta($post_id, 'cpr_competition2', $cpr_competition2);
        $cpr_competition3 = $_POST['cpr_competition3'];
        update_post_meta($post_id, 'cpr_competition3', $cpr_competition3);
        $cpr_competition_map = $_POST['cpr_competition_map'];
        update_post_meta($post_id, 'cpr_competition_map', $cpr_competition_map);
        $cpr_travel_info = $_POST['cpr_travel_info'];
        update_post_meta($post_id, 'cpr_travel_info', $cpr_travel_info);
        $cpr_raceday_info = $_POST['cpr_raceday_info'];
        update_post_meta($post_id, 'cpr_raceday_info', $cpr_raceday_info);
        $cpr_media_results = $_POST['cpr_media_results'];
        update_post_meta($post_id, 'cpr_media_results', $cpr_media_results);
        $cpr_media_album = $_POST['cpr_media_album'];
        update_post_meta($post_id, 'cpr_media_album', $cpr_media_album);
        
        $cpr_competition_header_image = $_POST['cpr_competition_header_image'];
        update_post_meta($post_id, 'cpr_competition_header_image', $cpr_competition_header_image);
        $cpr_competition_map_header_image = $_POST['cpr_competition_map_header_image'];
        update_post_meta($post_id, 'cpr_competition_map_header_image', $cpr_competition_map_header_image);
        $cpr_travel_info_header_image = $_POST['cpr_travel_info_header_image'];
        update_post_meta($post_id, 'cpr_travel_info_header_image', $cpr_travel_info_header_image);
        $cpr_raceday_info_header_image = $_POST['cpr_raceday_info_header_image'];
        update_post_meta($post_id, 'cpr_raceday_info_header_image', $cpr_raceday_info_header_image);
        $cpr_media_results_header_image = $_POST['cpr_media_results_header_image'];
        update_post_meta($post_id, 'cpr_media_results_header_image', $cpr_media_results_header_image);
        
        
        $cpr_competition_header_image_id = $_POST['cpr_competition_header_image_id'];
        update_post_meta($post_id, 'cpr_competition_header_image_id', $cpr_competition_header_image_id);
        
        $cpr_competition_map_header_image_id = $_POST['cpr_competition_map_header_image_id'];
        update_post_meta($post_id, 'cpr_competition_map_header_image_id', $cpr_competition_map_header_image_id);
        
        $cpr_travel_info_header_image_id = $_POST['cpr_travel_info_header_image_id'];
        update_post_meta($post_id, 'cpr_travel_info_header_image_id', $cpr_travel_info_header_image_id);
        
        $cpr_raceday_info_header_image_id = $_POST['cpr_raceday_info_header_image_id'];
        update_post_meta($post_id, 'cpr_raceday_info_header_image_id', $cpr_raceday_info_header_image_id);
        
        $cpr_media_results_header_image_id = $_POST['cpr_media_results_header_image_id'];
        update_post_meta($post_id, 'cpr_media_results_header_image_id', $cpr_media_results_header_image_id);
        
        
        
        $cpr_show_default    =   $_POST['cpr_show_default'];
        update_post_meta($post_id, 'cpr_show_default', $cpr_show_default);
        
        
        $cpr2_competition = $_POST['cpr2_competition'];
        update_post_meta($post_id, 'cpr2_competition', $cpr2_competition);
        $cpr2_competition = $_POST['cpr2_competition2'];
        update_post_meta($post_id, 'cpr2_competition2', $cpr2_competition2);
        $cpr2_competition = $_POST['cpr2_competition3'];
        update_post_meta($post_id, 'cpr2_competition3', $cpr2_competition3);
        $cpr2_competition_map = $_POST['cpr2_competition_map'];
        update_post_meta($post_id, 'cpr2_competition_map', $cpr2_competition_map);
        $cpr2_travel_info = $_POST['cpr2_travel_info'];
        update_post_meta($post_id, 'cpr2_travel_info', $cpr2_travel_info);
        $cpr2_raceday_info = $_POST['cpr2_raceday_info'];
        update_post_meta($post_id, 'cpr2_raceday_info', $cpr2_raceday_info);
        $cpr2_media_results = $_POST['cpr2_media_results'];
        update_post_meta($post_id, 'cpr2_media_results', $cpr2_media_results);
        $cpr2_media_album = $_POST['cpr2_media_album'];
        update_post_meta($post_id, 'cpr2_media_album', $cpr2_media_album);
        
        $cpr2_competition_header_image = $_POST['cpr2_competition_header_image'];
        update_post_meta($post_id, 'cpr2_competition_header_image', $cpr2_competition_header_image);
        $cpr2_competition_map_header_image = $_POST['cpr2_competition_map_header_image'];
        update_post_meta($post_id, 'cpr2_competition_map_header_image', $cpr2_competition_map_header_image);
        $cpr2_travel_info_header_image = $_POST['cpr2_travel_info_header_image'];
        update_post_meta($post_id, 'cpr2_travel_info_header_image', $cpr2_travel_info_header_image);
        $cpr2_raceday_info_header_image = $_POST['cpr2_raceday_info_header_image'];
        update_post_meta($post_id, 'cpr2_raceday_info_header_image', $cpr2_raceday_info_header_image);
        $cpr2_media_results_header_image = $_POST['cpr2_media_results_header_image'];
        update_post_meta($post_id, 'cpr2_media_results_header_image', $cpr2_media_results_header_image);
        
        
        $cpr2_competition_header_image_id = $_POST['cpr2_competition_header_image_id'];
        update_post_meta($post_id, 'cpr2_competition_header_image_id', $cpr2_competition_header_image_id);
        
        $cpr2_competition_map_header_image_id = $_POST['cpr2_competition_map_header_image_id'];
        update_post_meta($post_id, 'cpr2_competition_map_header_image_id', $cpr2_competition_map_header_image_id);
        
        $cpr2_travel_info_header_image_id = $_POST['cpr2_travel_info_header_image_id'];
        update_post_meta($post_id, 'cpr2_travel_info_header_image_id', $cpr2_travel_info_header_image_id);
        
        $cpr2_raceday_info_header_image_id = $_POST['cpr2_raceday_info_header_image_id'];
        update_post_meta($post_id, 'cpr2_raceday_info_header_image_id', $cpr2_raceday_info_header_image_id);
        
        $cpr2_media_results_header_image_id = $_POST['cpr2_media_results_header_image_id'];
        update_post_meta($post_id, 'cpr2_media_results_header_image_id', $cpr2_media_results_header_image_id);
        
        
        
        $cpr2_show_default    =   $_POST['cpr2_show_default'];
        update_post_meta($post_id, 'cpr2_show_default', $cpr2_show_default);
        
    }
    
    /*---------------Meta box of list of event for competition-----------------*/
    
    add_action( 'add_meta_boxes', 'eventid_competition' );
function eventid_competition() {
    add_meta_box( 
        'eventid_competition',
        __( 'Event', 'myplugin_textdomain' ),
        'eventid_dropdown',
        'competition',
        'normal',
        'high'
    );
}

function eventid_dropdown( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'eventid_dropdown_nonce' );
       
         $eventid =   get_post_meta( $post->ID, 'eventid', true );
        
    //$bloginfo = get_bloginfo('template_url');     
?>
  <?php $posts = new WP_Query(array( 
   'post_type' => 'events',
   'posts_per_page' => -1 
)); ?>
  <select name="eventid" id="eventid">
    <option value="">Select</option>
    <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
    <option value="<?php the_ID(); ?>" <?php if($eventid== get_the_id()){?> selected=selected<?php }?>>
    <?php the_title(); ?>
    </option>
    <?php endwhile; ?>
  </select>
  <?php wp_reset_query(); ?>
  <?php
}
 



add_action( 'save_post', 'eventid_dropdown_save' );
function eventid_dropdown_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;

	if ( !wp_verify_nonce( $_POST['eventid_dropdown_nonce'], plugin_basename( __FILE__ ) ) )
	return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	$eventid = $_POST['eventid'];
        
	update_post_meta( $post_id, 'eventid', $eventid );
}


function cmc_competition(){
    
    global $post;
 
	//extract(shortcode_atts( array('id' => ''), $atts));
        if( trim($post->ID)!=''){
    
   $categories=  get_categories('taxonomy=competition_category'); 
 
   $content='';
   
      foreach ($categories as $category) {
   
         
     
                $args = array(
                    'post_type' => 'competition',
                    'meta_query' => array(
		array(
			'key' => 'eventid',
			'value' => $post->ID,
		)
	),
                        'tax_query' => array(
                                array(
                                        'taxonomy' => 'competition_category',
                                        'field' => 'slug',
                                        'terms' => $category->slug
                                )
                        )
                );
     
  	 
      
          //echo $category->term_id;
        
    
                $results = get_posts($args);
              
                if($results){
                      
                    
                            $content.=' <div class="overview_list">
                                 <div class="overview_imgthumb"><img src="'.z_taxonomy_image_url($category->term_id).'" alt="" width="265" height="145" /></div>
                                    <div class="overview_imglist">
                                        <h2>'.$category->name.'</h2>
                                        <p>'.$category->description.'</p>
                                        <ul>';
                                                for ($k = 0; $k < count($results); $k++) {
                                                    $video_code = get_post_meta($results[$k]->ID, 'video_code', true);
                                                    $content.='<li>'.$results[$k]->post_title;
                                                    if ($video_code != "") {  
                                                   $content.='<a class="various iframe" rel="example_group" style="width:135px; height:74px; position:relative; float:left;"
                                                               title="'.$results[$k]->post_title.'" 
                                                               href="http://www.youtube.com/v/'.$video_code.'?fs=1&amp;autoplay=1">
                                                                <img src="http://img.youtube.com/vi/'.$video_code.'/1.jpg" alt="" width="135" height="74" />
                                                                <img src="'. home_url("/").'wp-content/themes/CMC/images/video_transparent_img.png" alt="" style="position:absolute; top:0; left:0;" />    
                                                            </a>';
                                                        }else{
                                                            $image_id1 = (int) get_post_thumbnail_id($results[$k]->ID);
                                                            $image_url1 = wp_get_attachment_image_src($image_id1, 'large', true); 
                                                            if ($image_id1 > 0) {
                                                                $content.='<a rel="example_group" title="'.$results[$k]->post_title.'" href="'.$image_url1[0].'"><img src="'.$image_url1[0].'"  width="135" height="74" /></a>';
                                                            } 
                                                    }
                                                $content.=$results[$k]->post_content; 
                                                $content.='</li>';
                                                }
                                        $content.=' </ul>
                                        
                                        </div>
                                    <div class="clear"></div>
                                </div>';
                            
                }    
             
             
            }
      
 
        return $content;
   }
}
add_shortcode('competition', 'cmc_competition');




/*---------------Meta box of Date Time For event -----------------*/
    
    add_action( 'add_meta_boxes', 'event_datetime' );
function event_datetime() {
    add_meta_box( 
        'event_datetime',
        __( 'Date Time for event', 'myplugin_textdomain' ),
        'event_datetime_textbox',
        'events',
        'normal',
        'high'
    );
}

function event_datetime_textbox( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'event_datetime_textbox_nonce' );
       
         $event_datetime =   get_post_meta( $post->ID, 'event_datetime', true );
        
    //$bloginfo = get_bloginfo('template_url');     
?>
  <script type="text/javascript" src="<?php bloginfo('template_url')?>/js/jquery-calendar.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url')?>/js/jquery-calendar.css" />
  <script type="text/javascript">

		//<![CDATA[

			jQuery(document).ready(function (){ 

				jQuery("#event_datetime, #event_datetime2").calendar();
                                //jQuery("#event_datetime").calendar();
                                    
				//jQuery("#calendar1_alert").click(function(){alert(popUpCal.parseDate(jQuery('#event_datetime').val()))});

			});

		//]]>

		</script>
  <input type="text" id="event_datetime" name="event_datetime" class="calendarFocus" value="<?php echo trim($event_datetime);?>"/>
  <?php
}
 



add_action( 'save_post', 'event_datetime_textbox_save' );
function event_datetime_textbox_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;

	if ( !wp_verify_nonce( $_POST['event_datetime_textbox_nonce'], plugin_basename( __FILE__ ) ) )
	return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	$event_datetime = $_POST['event_datetime'];
        
	update_post_meta( $post_id, 'event_datetime', $event_datetime );
}
/*
Validate Numbers in Contact Form 7
This is for 10 digit numbers
*/

function is_number( $result, $tag ) {
$type = $tag['type'];
$name = $tag['name'];

if ($name == 'your-phone' || $name == 'your-fax' || $name == 'txtPhone' || $name=='txtHomePhone' || $name=='txtWorkPhone' || $name=='txtHomePhoneAgent' || $name=='txtWorkPhoneAgent' ) { // Validation applies to these textfield names. Add more with || inbetween
$stripped = preg_replace( '/\D/', '', $_POST[$name] );
$_POST[$name] = $stripped;
if( strlen( $_POST[$name] ) != 10 ) { // Number string must equal this
$result['valid'] = false;
$result['reason'][$name] = $_POST[$name] = 'Please enter 10 digits phone number.';
}
}
return $result;
}

add_filter( 'wpcf7_validate_text', 'is_number', 10, 2 );
add_filter( 'wpcf7_validate_text*', 'is_number', 10, 2 );

 /***************************************************************************************CMC MEDIA SECTION*********************************************************************************************************/





/***************************************************************************************CMC MEDIA SECTION END******************************************************************************************************/


  function isnot_number( $result, $tag ) {
$type = $tag['type'];
$name = $tag['name'];

if ($name == 'your-name' || $name=='txtNameContact' || $name=='txtName' || $name=='txtNameAgent') { // Validation applies to these textfield names. Add more with || inbetween
    //if(preg_match('/^[A-Z][a-z-\']+[a-z]+([\s][A-Z][a-z-\']+[a-z])?$/', $_POST[$name])){$rex = '/^[a-zA-Z][a-zA-Z ]*$/';
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $_POST[$name])) {
            $result['valid'] = false;
            $result['reason'][$name] = $_POST[$name] = 'Please enter your name in alphabates only.';    
    }

  }
  return $result;
}

add_filter( 'wpcf7_validate_text', 'isnot_number', 10, 2 );
add_filter( 'wpcf7_validate_text*', 'isnot_number', 10, 2 );  

function fb_share($id) { 
  ?>
  <div class="fb_share"> <a name="fb_share" type="button_count" share_url="<?php echo get_permalink($id); ?>"
      href="http://www.facebook.com/sharer.php">Share</a> </div>
  <?php  
}

function twitter_share($id) { 
  ?>
  <div class="tt_share"> <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo (get_permalink($id)); ?>" data-text="<?php echo strip_tags(get_the_title($id)); ?>">Tweet</a> </div>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
  <?php  
}

function google_plus_share($id){
 ?>
  <!-- Place this tag in your head or just before your close body tag. --> 

  <!-- Place this tag where you want the share button to render. -->
  <div class="gp_share"> <a class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo (get_permalink($id)); ?>"></a> </div>
  <?php
}

function pinit_share($id){
 ?>
  <!-- Place this tag in your head or just before your close body tag. --> 
 
  <!-- Place this tag where you want the share button to render. -->
  <?php $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'media_galler_main'); ?>
  <div class="pt_share"> <a href="http://pinterest.com/pin/create/button/?url=<?php echo (get_permalink($id)); ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo strip_tags(get_the_title($id)); ?>"  
   data-pin-do="buttonPin" data-pin-config="beside"> <img src="http://assets.pinterest.com/images/pidgets/pin_it_button.png" /></a> </div>
  <?php
}






function fb_share_single($url) { 
    
  ?>
  <div class="fb_share"> <a name="fb_share" type="button_count" share_url="<?php echo ($url); ?>"
      href="http://www.facebook.com/sharer.php">Share</a> </div>
  <?php  
}

function twitter_share_single($url,$id) { 
  ?>
  <div class="tt_share"> <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo urlencode($url); ?>" data-text="<?php echo strip_tags(get_the_title($id)); ?>">Tweet</a> </div>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
  <?php  
}

function google_plus_share_single($url){
 ?>
  <!-- Place this tag in your head or just before your close body tag. --> 

  <!-- Place this tag where you want the share button to render. -->
  <div class="gp_share"> <a class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo urlencode($url); ?>"></a> </div>
  <?php
}

function pinit_share_single($url,$img_url,$id){
    
 ?>
  <!-- Place this tag in your head or just before your close body tag. --> 
  <script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script> 
  <!-- Place this tag where you want the share button to render. -->
  <?php $pinterestimage = $img_url; ?>
  <div class="pt_share"> <a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo strip_tags(get_the_title($id)); ?>"  
   data-pin-do="buttonPin" data-pin-config="beside"> <img src="http://assets.pinterest.com/images/pidgets/pin_it_button.png" /></a> </div>
  <?php
}


/* Upcoming events on home page */

add_filter('admin_init', 'upcoming_events_inleftnavigationonhomepage');


function upcoming_events_inleftnavigationonhomepage()
{
    
   register_setting('general', 'upcoming_events_inleftnavigationonhomepage_id', 'esc_attr');
  add_settings_field('upcoming_events_inleftnavigationonhomepage_id', '<label for="upcoming_events_inleftnavigationonhomepage_id">'.__('Show  Upcoming events in leftnavigation on Homepage' , 'upcoming_events_inleftnavigationonhomepage_id' ).'</label>' , 'upcoming_events_inleftnavigationonhomepage_html', 'general');

}

function upcoming_events_inleftnavigationonhomepage_html()
{
    
    $login_id_val = get_option('upcoming_events_inleftnavigationonhomepage_id',''); 
    if($login_id_val==1){
        $str='checked=checked';
        
    }else{
        $str="";
    }
    echo '<input type="checkbox" id="upcoming_events_inleftnavigationonhomepage_id" name="upcoming_events_inleftnavigationonhomepage_id" value="1" '.$str.'><br>';
    
}

/* PAYMENT SETTINGS END*/

add_filter( 'media_view_strings', 'cor_media_view_strings' );
/**
 * Removes the media 'From URL' string.
 *
 * @see wp-includes|media.php
 */
function cor_media_view_strings( $strings ) {
    unset( $strings['insertFromUrlTitle'] );
    return $strings;
}
// Require post title
if ( is_admin() ) { wp_enqueue_script('require-post-title', get_bloginfo('template_directory') . '/require-title.js'); }

// allow shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

