<?php
/**
 * Custom Login administration settings
 * These are the functions that allow users to select options
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package CommentValidationReloaded
 */

/**
 * Returns an array of all the settings defaults
 * Other admin functions can grab this to use
 *
 * @since 0.1
 */
function comment_validation_reloaded_settings_args() {
	$settings_arr = array(
		/* Activate */
		'activate'	=> false,
		'version'	=> '1.10.0',
		'author'	=> true,
		'internal'	=> true,
		'language'	=> '',
		
		/* Comment form */
		'form-id-class' => '#commentform',
		'minimum'		=> '40',
	);
	
	return $settings_arr;
}

/**
 * Handles the main plugin settings
 *
 * @since 0.1
 */
function comment_validation_reloaded_page() {

	/*
	* Main settings variables
	*/
	$plugin_name = 'Comment Validation Reloaded';
	$settings_page_title = 'Comment Validation Reloaded settings';
	$hidden_field_name = 'comment_validation_reloaded_submit_hidden';
	$plugin_data = get_plugin_data( CVR . '/comment-validation-reloaded.php');

	/*
	* Grabs the default plugin settings
	*/
	$settings_arr = comment_validation_reloaded_settings_args();

	/*
	* Add a new option to the database
	*/
	add_option( 'comment_validation_reloaded_settings', $settings_arr );

	/*
	* Set form data IDs the same as settings keys
	* Loop through each
	*/
	$settings_keys = array_keys( $settings_arr );
	foreach ( $settings_keys as $key ) :
		$data[$key] = $key;
	endforeach;

	/*
	* Get existing options from database
	*/
	$settings = get_option( 'comment_validation_reloaded_settings' );

	foreach ( $settings_arr as $key => $value ) :
		$val[$key] = $settings[$key];
	endforeach;

	/*
	* If any information has been posted, we need
	* to update the options in the database
	*/
	if ( isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y' ) :

		/*
		* Loops through each option and sets it if needed
		*/
		foreach ( $settings_arr as $key => $value ) :
			$settings[$key] = $val[$key] = $_POST[$data[$key]];
		endforeach;

		/*
		* Update plugin settings
		*/
		update_option( 'comment_validation_reloaded_settings', $settings );
		
		/*
		* Output the settings page
		*/
        echo '<div class="wrap">';
		if ( function_exists('screen_icon') ) screen_icon();
		echo '<h2>' . $settings_page_title . '</h2>';
		echo '<div class="updated" style="margin:15px 0;">';
		_e( '<p><strong>Don&prime;t you feel good. You just saved me!</strong></p>', 'cvr' );
		echo '</div>';
		
	
	elseif ( isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'R') :

		foreach($settings_arr as $key => $value) :
			$settings[$key] = $val[$key] = $_POST[$data[$key]];
		endforeach;

		delete_option( 'comment_validation_reloaded_settings', $settings );
		
		/*
		* Output the settings page
		*/
        echo '<div class="wrap">';
		if ( function_exists('screen_icon') ) screen_icon();
		echo '<h2>' . $settings_page_title . '</h2>';
		echo '<div class="updated" style="margin:15px 0;">';
		_e( '<p><strong>Oh no! I&prime;ve been reset.</strong></p>', 'cvr' );
		echo '</div>';

	else :

		echo '<div class="wrap">';
		if ( function_exists('screen_icon') ) screen_icon();
		echo '<h2>' . $settings_page_title . '</h2>';
		
	endif;
?>

			<div id="poststuff">

				<form name="form0" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>" style="border:none;background:transparent;">

					<?php require_once( CVR_ADMIN . '/settings.php' ); ?>

					<p class="submit" style="float:left;">
						<input type="submit" name="Submit"  class="button-primary" value="<?php _e( 'Save Changes', 'cvr' ); ?>" />
						<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />
					</p>

				</form>
                
                <form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" style="border:none;background:transparent;">
                
                    <p class="submit" style="float:left; margin-left:10px;">
                        <input type="submit" name="Reset" class="swg_warning" value="Delete/Reset" onclick="return confirm('<?php _e( 'Do you really want to delete/reset the plugin settings?', 'cvr' ); ?>');" />
                        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="R" />
                    </p>
            
                </form>
                
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post"<?php if ( $val['author'] ) echo ' style="display:none;"'; ?>>
                    <p style="float:left; margin:18px 10px 0;">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="CN9BU5LAYCXV8">
                        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </p>
                </form>

			</div>
            
			<br style="clear:both;" />

		</div>
<?php
}

?>