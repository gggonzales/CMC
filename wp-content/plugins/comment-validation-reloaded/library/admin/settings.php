<?php
/**
 * Anywhere settings page
 * This file displays all of the available settings
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package CommentValidationReloaded
 */
?>
<!-- Left Sidebar -->
<div id="left" style="float:left; width:66%;">

<div class="postbox open">

<h3><?php _e( 'Avtivate Comment Validation Reloaded', 'cvr' ); ?></h3>

<div class="inside">
	<table class="form-table">
    	<tr>
        	<th>
            	<label for="<?php echo $data['activate']; ?>"><?php _e( 'Active:', 'cvr' ); ?></label> 
            </th>
            <td>
                <input id="<?php echo $data['activate']; ?>" name="<?php echo $data['activate']; ?>" type="checkbox" <?php if ( $val['activate'] ) echo 'checked="checked"'; ?> value="true" />
                <a class="question" title="Help &amp; Examples">[?]</a><br />
                <span class="hide"><?php _e( 'Activate Comment Validation Reloaded.', 'cvr' ); ?></span>
            </td>
        </tr>
        <tr>
        	<th>
            	<label for="<?php echo $data['version']; ?>"><?php _e( 'Version:', 'cvr' ); ?></label> 
            </th>
            <td>
            	<select id="<?php echo $data['version']; ?>" name="<?php echo $data['version']; ?>" style="width:60px;">
                    <option value="1.6" <?php if ( $val['version'] == '1.7' ) echo ' selected="selected"'; ?>>1.7</option>
                    <option value="1.8" <?php if ( $val['version'] == '1.8' ) echo ' selected="selected"'; ?>>1.8</option>
                    <option value="1.8.1" <?php if ( $val['version'] == '1.8.1' ) echo ' selected="selected"'; ?>>1.8.1</option>
                    <option value="1.9" <?php if ( $val['version'] == '1.9' ) echo ' selected="selected"'; ?>>1.9</option>
                    <option value="1.10.0" <?php if ( $val['version'] == '1.10.0' ) echo ' selected="selected"'; ?>>1.10.0</option>
                </select>
            </td>
        </tr>
        <tr>
        	<th>
            	<label for="<?php echo $data['language']; ?>"><?php _e( 'Language:', 'cvr' ); ?></label> 
            </th>
            <td>
                <input id="<?php echo $data['language']; ?>" name="<?php echo $data['language']; ?>" value="<?php echo $val['language']; ?>" size="21" maxlength="2" />
                <a class="question" title="Help &amp; Examples">[?]</a><br />
                <span class="hide"><?php _e( 'The two letter lanquage code for translation script. Example: <code>de</code>, or <code>fr</code>. Leave empty to disable.', 'cvr' ); ?></span>
            </td>
        </tr>
    	<tr>
        	<th>
            	<label for="<?php echo $data['author']; ?>"><?php _e( 'Author love:', 'cvr' ); ?></label> 
            </th>
            <td>
                <input id="<?php echo $data['author']; ?>" name="<?php echo $data['author']; ?>" type="checkbox" <?php if ( $val['author'] ) echo 'checked="checked"'; ?> value="true" />
                <a class="question" title="Help &amp; Examples">[?]</a><br />
                <span class="hide"><?php _e( 'Uncheck this box to <strong>hide</strong> &ldquo;Comment Validation plugin by @TheFrosty&rdquo;. Please consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=HA43MU7NT8NN2" title="Donate on PayPal" class="external">donating</a> first..<br />
                <strong>Note:</strong> This will only show up below the <code>comment form</code> (if active).', 'cvr' ); ?></span>
            </td>
        </tr>
    	<tr>
        	<th>
            	<label for="<?php echo $data['internal']; ?>"><?php _e( 'Use external:', 'cvr' ); ?></label> 
            </th>
            <td>
                <input id="<?php echo $data['internal']; ?>" name="<?php echo $data['internal']; ?>" type="checkbox" <?php if ( $val['internal'] ) echo 'checked="checked"'; ?> value="true" />
                <a class="question" title="Help &amp; Examples">[?]</a><br />
                <span class="hide"><?php _e( 'check this box to <strong>use</strong> the external javascript validation.<br />
                <strong>Note:</strong> If having problems, uncheck for internal.', 'cvr' ); ?></span>
            </td>
        </tr>
        
    </table>
    
</div>
</div>


<div class="postbox ad">
	
		<iframe allowtransparency="true" src="http://austinpassy.com/custom-login.php" scrolling="no" style="height:50px;width:100%;">
		</iframe><!-- .form-table -->
</div>

<div class="postbox open">

<h3><?php _e( 'Comment Form options', 'cvr' ); ?></h3>

<div class="inside<?php if ( !$val['activate'] ) echo ' activate'; ?>">
	<table class="form-table">
        <tr id="comment-form" <?php if ( !$val['activate'] ) echo 'style="display:none;"'; ?>>
            <th>
            	<label for="<?php echo $data['form-id-class']; ?>"><?php _e( 'form ID/Class:', 'cvr' ); ?></label> 
            </th>
            <td>
                <input id="<?php echo $data['form-id-class']; ?>" name="<?php echo $data['form-id-class']; ?>" value="<?php echo $val['form-id-class']; ?>" size="21" maxlength="61"<?php if ( !$val['form-id-class'] ) echo ' style="background:#ffa5a5; border:1px solid #ff0000;"'; ?> />
                <a class="question" title="Help &amp; Examples">[?]</a><br />
                <span class="hide"><?php _e( 'Find your <code>comment.php</code> and input your form ID or Class in this field. <strong>Example:</strong> <code>#commentform</code> or <code>.commentform</code>.', 'cvr' ); ?></span>
            </td>
        </tr> 
        <tr id="comment-min" <?php if ( !$val['activate'] ) echo 'style="display:none;"'; ?>>
            <th>
            	<label for="<?php echo $data['minimum']; ?>"><?php _e( 'Min Characters:', 'cvr' ); ?></label> 
            </th>
            <td>
                <input id="<?php echo $data['minimum']; ?>" name="<?php echo $data['minimum']; ?>" value="<?php echo $val['minimum']; ?>" size="21" maxlength="4" />
                <a class="question" title="Help &amp; Examples">[?]</a><br />
                <span class="hide"><?php _e( 'The minimun number of characters in the comment field.', 'cvr' ); ?></span>
            </td>
        </tr> 
    </table>
    
</div>
</div>


</div> <!-- /float:left -->

<!-- Right Sidebar -->
<div style="float:right; width:33%;">

<div class="postbox open">

<h3><?php _e( 'About This Plugin', 'cvr' ); ?></h3>

<div class="inside">
	<table class="form-table">

	<tr>
		<th style="width:20%;"><?php _e( 'Description:', 'cvr' ); ?></th>
		<td><?php _e( 'Adds comment validation javascript code to your blog. This is an update to <a href="http://wordpress.org/extend/plugins/comment-validation/">Comment Validation</a>, using CDN hosted library\'s and better options to work on all themes.', 'cvr' ); ?></td>
	</tr>
	<tr>
		<th style="width:20%;"><?php _e( 'Version:', 'cvr' ); ?></th>
		<td><strong><?php echo $plugin_data[ 'Version' ]; ?></strong></td>
	</tr>
	<tr>
		<th style="width:20%;"><?php _e( 'Support:', 'cvr' ); ?></th>
		<td><a href="http://wordpress.org/tags/comment-validation-reloaded?forum_id=10" title="Get support for this plugin" class="external"><?php _e( 'WordPress support forums.', 'cvr' ); ?></a></td>
	</tr>

	</table>
</div>
</div>

<div id="colordock" class="postbox open">

<h3><?php _e( 'Quick Save', 'cvr' ); ?></h3>

<div class="inside">
    
    <p class="submit" style="text-align: center;">
        <input type="submit" name="Submit"  class="button-primary" value="<?php _e( 'Save Changes', 'cvr' ); ?>" />
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />
    </p>
    	
</div>
</div>


<div class="postbox open">

<h3><?php _e( 'Support This Plugin', 'cvr' ); ?></h3>

<div class="inside">
	<table class="form-table">

	<tr>
		<th style="width:20%;"><?php _e( 'Donate:', 'cvr' ); ?></th>
		<td><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=CN9BU5LAYCXV8" title="Donate on PayPal" class="external"><?php _e( 'PayPal', 'cvr' ); ?></a>.</td>
	</tr>
	<tr>
		<th style="width:20%;"><?php _e( 'Rate:', 'cvr' ); ?></th>
		<td><a href="http://www.wordpress.org/extend/plugins/comment-validation-reloaded/" title="WordPress.org Rating" class="external"><?php _e( 'This plugin on WordPress.org', 'cvr' ); ?></a>.</td>
	</tr>
    
	</table>
</div>
</div>

<div class="postbox open">

<h3><?php _e( 'About The Author', 'cvr' ); ?></h3>

<div class="inside">

	<ul>
    
		<li><?php echo $plugin_data[ 'Author' ]; ?>: <?php _e( 'Freelance web design/developer &amp; WordPress guru. Also head organizer of <a href="http://wordcamp.la">WordCamp.LA</a>', 'cvr' ); ?></li>
        
		<li><a href="http://twitter.com/TheFrosty" title="Austin Passy on Twitter" class="external"><?php _e( 'Follow me on twitter', 'cvr' ); ?></a>.</li>
        
		<li><?php _e( 'Need a WP expert?', 'cvr' ); ?> <a href="http://frostywebdesigns.com/" title="Frosty Web Designs" class="external"><?php _e( 'Hire me', 'cvr' ); ?></a>.</li>
        
		<li><?php _e( 'Looking for a WordPress plugin?', 'cvr' ); ?> <a href="http://extendd.com/" title="Extendd" class="external">Extendd.com</a>.</li>
        
	</ul>
    
</div>
</div>

<div class="postbox open">

<h3><?php _e( '<a href="http://thefrosty.net">TheFrosty Network</a> feeds', 'cvr' ); ?></h3>

<div id="tab" class="inside">

	<ul class="tabs">
    
    	<li class="t1 t"><a><?php _e( 'Austin Passy', 'cvr' ); ?></a></li>
    	<li class="t2 t"><a><?php _e( 'WordCamp LA', 'cvr' ); ?></a></li>
    	<li class="t3 t"><a><?php _e( 'Extendd', 'cvr' ); ?></a></li>
        
	</ul>
    
		<?php if ( function_exists( 'thefrosty_network_feed' ) ) thefrosty_network_feed( 'http://extendd.com/feed', '3' ); ?>

		<?php if ( function_exists( 'thefrosty_network_feed' ) ) thefrosty_network_feed( 'http://feeds.feedburner.com/WordCampLA', '2' );	?>

		<?php if ( function_exists( 'thefrosty_network_feed' ) ) thefrosty_network_feed( 'http://feeds.feedburner.com/AustinPassy', '1' ); ?>
    
</div>
</div>


<?php if ( is_version( '3.0' ) ) { } else { ?>
<div id="uninstall" class="postbox open">

<h3><?php _e( 'Uninstaller <span><abbr title="Click here to show the box below">Don&rsquo;t do it!</abbr></span><span class="watchingyou">:O You did it...</span>', 'cvr' ); ?></h3>  
        
<div class="inside">
    <p style="text-align:justify;"><?php _e( 'If you really have to, use this <a href="../wp-content/plugins/comment-validation-reloaded/uninstall.php" title="Uninstall the Comment Validation Reloaded plugin with this script">script</a> to uninstall the plugin and completely remove all options from your WordPress database. <strong>Note:</strong> Will not work in WordPress 3.0+, simply deactivating the plugin will do :).', 'cvr' ); ?></p>
    
</div>
</div>
<?php } ?>

</div> <!-- /float:right -->

<br style="clear:both;" />
