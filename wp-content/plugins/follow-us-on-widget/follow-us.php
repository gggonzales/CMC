<?php
/*
Plugin Name: Follow us on widget
Plugin URI: http://vijayakumar.org/web-development/easy-follow-us-on-wordpress-widget-plugin/
Description: Follow us on widget helps to share the Social Media buttons as widget
Author: Vijaya Kumar S
Version: 1
Author URI: http://vijayakumar.org/
*/ 
 
class FollowusonWidget extends WP_Widget
{
  function FollowusonWidget()
  {
    $widget_ops = array('classname' => 'FollowusonWidget', 'description' => 'Displays a Follow us on buttons' );
    $this->WP_Widget('FollowusonWidget', 'Follow us on Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => 'Follow us on' ) );
    $title = $instance['title'];
	$fbwidget = $instance['fbwidget'];
	$twitterwidget = $instance['twitterwidget'];
	$pinterestwidget = $instance['pinterestwidget'];
	$linkedinwidget = $instance['linkedinwidget'];
	$googlepluswidget = $instance['googlepluswidget'];
?>

<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('fbwidget'); ?>">Facebook:
    <input class="widefat" id="<?php echo $this->get_field_id('fbwidget'); ?>" name="<?php echo $this->get_field_name('fbwidget'); ?>" type="text" value="<?php echo attribute_escape($fbwidget); ?>" />
  </label>
  <em style="float:right; font-size:11px; padding-top:3px;">Ex: <a href="http://vijayakumar.org/facebook" target="_blank">http://vijayakumar.org/facebook</a></em></p>
<p style="padding-top:10px;"></p>
<p>
  <label for="<?php echo $this->get_field_id('twitterwidget'); ?>">Twitter:
    <input class="widefat" id="<?php echo $this->get_field_id('twitterwidget'); ?>" name="<?php echo $this->get_field_name('twitterwidget'); ?>" type="text" value="<?php echo attribute_escape($twitterwidget); ?>" />
  </label>
  <em style="float:right; font-size:11px; padding-top:3px;">Ex: <a href="http://vijayakumar.org/twitter" target="_blank">http://vijayakumar.org/twitter</a></em>
<p style="padding-top:10px;"></p>
<p>
  <label for="<?php echo $this->get_field_id('pinterestwidget'); ?>">Pinterest:
    <input class="widefat" id="<?php echo $this->get_field_id('pinterestwidget'); ?>" name="<?php echo $this->get_field_name('pinterestwidget'); ?>" type="text" value="<?php echo attribute_escape($pinterestwidget); ?>" />
  </label>
  <em style="float:right; font-size:11px; padding-top:3px;">Ex: <a href="http://pinterest.com/jetsetterphoto/i-3-ny/" target="_blank">http://pinterest.com/jetsetterphoto/i-3-ny/</a></em>
<p style="padding-top:10px;"></p>
<p>
  <label for="<?php echo $this->get_field_id('linkedinwidget'); ?>">Linkedin:
    <input class="widefat" id="<?php echo $this->get_field_id('linkedinwidget'); ?>" name="<?php echo $this->get_field_name('linkedinwidget'); ?>" type="text" value="<?php echo attribute_escape($linkedinwidget); ?>" />
  </label>
  <em style="float:right; font-size:11px; padding-top:3px;">Ex: <a href="http://vijayakumar.org/linkedin" target="_blank">http://vijayakumar.org/linkedin</a></em>
<p style="padding-top:10px;"></p>
<p>
  <label for="<?php echo $this->get_field_id('googlepluswidget'); ?>">Google+:
    <input class="widefat" id="<?php echo $this->get_field_id('googlepluswidget'); ?>" name="<?php echo $this->get_field_name('googlepluswidget'); ?>" type="text" value="<?php echo attribute_escape($googlepluswidget); ?>" />
  </label>
  <em style="float:right; font-size:11px; padding-top:3px;">Ex: <a href="https://plus.google.com/communities/109073965695075941257?hl=en" target="_blank">https://plus.google.com/communities/109073965695075941257?hl=en</a></em>
  <?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['fbwidget'] = $new_instance['fbwidget'];
	$instance['twitterwidget'] = $new_instance['twitterwidget'];
	$instance['pinterestwidget'] = $new_instance['pinterestwidget'];
	$instance['linkedinwidget'] = $new_instance['linkedinwidget'];
	$instance['googlepluswidget'] = $new_instance['googlepluswidget'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    if (!empty($title))
		echo $before_title . $title . $after_title;
		$arraysplit = explode("/",plugin_basename(__FILE__));
		echo "<div class='social_icon'>";
		if($instance['fbwidget'] != '') echo "<a href='$instance[fbwidget]' target='_blank' class='fb'></a>";
		if($instance['twitterwidget'] != '') echo "<a href='$instance[twitterwidget]' target='_blank'class='twitter'></a>";
		if($instance['pinterestwidget'] != '') echo "<a href='$instance[pinterestwidget]' target='_blank' class='pinterest'></a>";
		if($instance['linkedinwidget'] != '') echo "<a href='$instance[linkedinwidget]' target='_blank' class='linkedin'></a>";
		if($instance['googlepluswidget'] != '') echo "<a href='$instance[googlepluswidget]' target='_blank' class='googleplus'></a>";
		echo "</div>";
		echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("FollowusonWidget");') );?>
