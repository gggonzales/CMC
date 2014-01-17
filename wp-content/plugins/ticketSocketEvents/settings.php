<?php
	function requires_wordpress_version() {
		global $wp_version;
		$plugin = plugin_basename( __FILE__ );
		$plugin_data = get_plugin_data( __FILE__, false );
	
		if ( version_compare($wp_version, "3.3", "<" ) ) {
			if( is_plugin_active($plugin) ) {
				deactivate_plugins( $plugin );
				wp_die( "'".$plugin_data['Name']."' requires WordPress 3.3 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>." );
			}
		}
	}
	add_action( 'admin_init', 'requires_wordpress_version' );
	
	register_activation_hook(__FILE__, 'ts_settings_add_defaults');
	register_uninstall_hook(__FILE__, 'ts_settings_delete_plugin_options');
	add_action('admin_init', 'ts_settings_init' );
	add_action('admin_menu', 'ts_settings_add_options_page');
	add_filter( 'plugin_action_links', 'ts_settings_plugin_action_links', 10, 2 );
	
	function ts_settings_delete_plugin_options() {
		delete_option('ts_settings_options');
	}
	
	function ts_settings_add_defaults() {
		$tmp = get_option('ts_settings_options');
		if(($tmp['chk_default_options_db']=='1')||(!is_array($tmp))) {
			delete_option('ts_settings_options'); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
			$arr = array(	"chk_button1" => "1",
							"chk_button3" => "1",
							"textarea_one" => "This type of control allows a large amount of information to be entered all at once. Set the 'rows' and 'cols' attributes to set the width and height.",
							"textarea_two" => "This text area control uses the TinyMCE editor to make it super easy to add formatted content.",
							"textarea_three" => "Another TinyMCE editor! It is really easy now in WordPress 3.3 to add one or more instances of the built-in WP editor.",
							"txt_one" => "Enter whatever you like here..",
							"drp_select_box" => "four",
							"chk_default_options_db" => "",
							"rdo_group_one" => "one",
							"rdo_group_two" => "two"
			);
			update_option('ts_settings_options', $arr);
		}
	}
	
	function ts_settings_init(){
		register_setting( 'ts_settings_plugin_options', 'ts_settings_options', 'ts_settings_validate_options' );
	}
	
	function ts_settings_add_options_page() {
		add_options_page('TicketSocket Options', 'TicketSocket', 'manage_options', __FILE__, 'ts_settings_render_form');
	}
	
	function ts_settings_render_form() {
		?>
		<div class="wrap">
			
			<!-- Display Plugin Icon, Header, and Description -->
			<div class="icon32" id="icon-options-general"><br></div>
			<h2>TicketSocket Options</h2>
			<p>Configure your TicketSocket Wordpress plugin with the options below.</p>
			<p>To customize css styles, please edit the stylesheets located in wp-content/plugins/ticketSocketEvents/css</p>
	
			<!-- Beginning of the Plugin Options Form -->
			<form method="post" action="options.php">
				<?php settings_fields('ts_settings_plugin_options'); ?>
				<?php $options = get_option('ts_settings_options'); ?>
	
				<!-- Table Structure Containing Form Controls -->
				<!-- Each Plugin Option Defined on a New Table Row -->
				<table class="form-table">
					<!-- Textbox Control -->
					<tr>
						<th scope="row">TicketSocket URL</th>
						<td>
							<input type="text" size="57" name="ts_settings_options[ticketSocketUrl]" value="<?php echo $options['ticketSocketUrl']; ?>" />
						</td>
					</tr>
	
					<!-- Radio Button Group -->
					<tr valign="top">
						<th scope="row">Category Menus</th>
						<td>
							<!-- First radio button -->
							<label><input name="ts_settings_options[categoryMenus]" type="radio" value="on" <?php checked('on', $options['categoryMenus']); ?> /> On </label><br />
						
							<!-- Second radio button -->
							<label><input name="ts_settings_options[categoryMenus]" type="radio" value="off" <?php checked('off', $options['categoryMenus']); ?> /> Off </label><br />
							<span style="color:#666666;">These display to the left of the main events list. Categories must be in either the 'type' category group or the 'location' category group to show.</span>
						</td>
					</tr>
	
					<!-- Radio Button Group -->
					<tr valign="top">
						<th scope="row">Categories Page</th>
						<td>
							<!-- First radio button -->
							<label><input name="ts_settings_options[categoryPage]" type="radio" value="on" <?php checked('on', $options['categoryPage']); ?> /> On </label><br />
						
							<!-- Second radio button -->
							<label><input name="ts_settings_options[categoryPage]" type="radio" value="off" <?php checked('off', $options['categoryPage']); ?> /> Off </label><br />
							<span style="color:#666666;">If this is on, the first page will be a list of categories, and clicking on a category link will show a list of events in that category.</span>
						</td>
					</tr>
	
					<!-- Radio Button Group -->
					<tr valign="top">
						<th scope="row">Search Filters</th>
						<td>
							<!-- First radio button -->
							<label><input name="ts_settings_options[searchFilters]" type="radio" value="on" <?php checked('on', $options['searchFilters']); ?> /> On </label><br />
	
							<!-- Second radio button -->
							<label><input name="ts_settings_options[searchFilters]" type="radio" value="off" <?php checked('off', $options['searchFilters']); ?> /> Off </label><br />
							<span style="color:#666666;">These display above the main events list.</span>
						</td>
					</tr>
	
					<!-- Radio Button Group -->
					<tr valign="top">
						<th scope="row">TicketSocket Target</th>
						<td>
							<!-- First radio button -->
							<label><input name="ts_settings_options[addToCartTarget]" type="radio" value="checkout" <?php checked('checkout', $options['addToCartTarget']); ?> /> Checkout </label><br />
	
							<!-- Second radio button -->
							<label><input name="ts_settings_options[addToCartTarget]" type="radio" value="event" <?php checked('event', $options['addToCartTarget']); ?> /> Event </label><br />
							<span style="color:#666666;">These display above the main events list.</span>
						</td>
					</tr>
	
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
			
			<h2>Generate Shortcodes</h2>
			<fieldset style="border: 1px dotted #cecece; padding: 3px;">
				<strong>Single Event:</strong>
				<p>Select an event below to generate a shortcode for just that events tickets.</p>
				<select name="eventSelector" id="eventSelector" onchange="createTicketSocketShortCode(jQuery(this));">
					<option value="">...</option>
					<?php
						$ticketSocket = new TicketSocketEvents();
						$ticketSocket->loadEvents();
						$events = $ticketSocket->getEvents();
						foreach ($events as $event)
							echo '
					<option value="'.$event["id"].'">'.$event["title"].'</option>';
					?>
				</select>
				
				<strong>Your Shortcode:</strong>
				&nbsp;
				<input type="text" size="57" name="shortcodeHolder" id="shortcodeHolder" value="" />
			</fieldset>
			
			<br />
			
			<fieldset style="border: 1px dotted #cecece; padding: 3px;">
				<strong>All Events:</strong>
				<p>This shortcode will embed the entire events list.</p>
				
				<strong>Your Shortcode:</strong>
				&nbsp;
				<input type="text" size="57" name="shortcodeHolder" id="shortcodeHolder" value="[events]" />
			</fieldset>
	
		</div>
		<script type="text/javascript">
			function createTicketSocketShortCode(selector)
			{
				jQuery('#shortcodeHolder').val('[tickets ' + String(selector.val()) + ']');
			}
		</script>
		<?php	
	}
	
	function ts_settings_validate_options($input) {
		 // strip html from textboxes
		$input['textarea_one'] =  wp_filter_nohtml_kses($input['textarea_one']); // Sanitize textarea input (strip html tags, and escape characters)
		$input['txt_one'] =  wp_filter_nohtml_kses($input['txt_one']); // Sanitize textbox input (strip html tags, and escape characters)
		return $input;
	}
	
	function ts_settings_plugin_action_links( $links, $file ) {
	
		if ( $file == plugin_basename( __FILE__ ) ) {
			$ts_settings_links = '<a href="'.get_admin_url().'options-general.php?page=plugin-options-starter-kit/plugin-options-starter-kit.php">'.__('Settings').'</a>';
			// make the 'Settings' link appear first
			array_unshift( $links, $ts_settings_links );
		}
	
		return $links;
	}
?>