<?php
/**
 * WordPress Administration Template Footer
 *
 * @package WordPress
 * @subpackage Administration
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');
?>

<div class="clear"></div></div><!-- wpbody-content -->
<div class="clear"></div></div><!-- wpbody -->
<div class="clear"></div></div><!-- wpcontent -->

<div id="wpfooter">
	<?php
	/**
	 * Fires after the opening tag for the admin footer.
	 *
	 * @since 2.5.0
	 */
	do_action( 'in_admin_footer' );
	?>
	<p id="footer-left" class="alignleft">
		<?php
		/**
		 * Filter the "Thank you" text displayed in the admin footer.
		 *
		 * @since 2.8.0
		 * @param string The content that will be printed.
		 */
		echo apply_filters( 'admin_footer_text', '<span id="footer-thankyou">' . __( 'Thank you for creating with <a href="http://wordpress.org/">WordPress</a>.' ) . '</span>' );
		?>
	</p>
	<p id="footer-upgrade" class="alignright">
		<?php
		/**
		 * Filter the version/update text displayed in the admin footer.
		 *
		 * @see core_update_footer() WordPress prints the current version and update information,
		 *	using core_update_footer() at priority 10.
		 *
		 * @since 2.3.0
		 * @param string The content that will be printed.
		 */
		echo apply_filters( 'update_footer', '' );
		?>
	</p>
	<div class="clear"></div>
</div>
<?php
/**
 * Print scripts or data before the default footer scripts.
 *
 * @since 1.2.0
 * @param string The data to print.
 */
do_action('admin_footer', '');

/**
 * Prints any scripts and data queued for the footer.
 *
 * @since 2.8.0
 */
do_action('admin_print_footer_scripts');

/**
 * Print scripts or data after the default footer scripts.
 *
 * @since 2.8.0
 *
 * @param string $GLOBALS['hook_suffix'] The current admin page.
 */
do_action("admin_footer-" . $GLOBALS['hook_suffix']);

// get_site_option() won't exist when auto upgrading from <= 2.7
if ( function_exists('get_site_option') ) {
	if ( false === get_site_option('can_compress_scripts') )
		compression_test();
}

?>

<div class="clear"></div></div><!-- wpwrap -->
<style>

#btn_map_area{
		cursor:pointer;
}

#img_map{
	background: url("images/map_events_area.jpg") no-repeat scroll center center rgba(0, 0, 0, 0);
    cursor: crosshair;
    display: none;
    height: 411px;
    width: 554px;
}
#map-xy{
	height:20px;
	display:none;
}
#custom_field_map_area{
	
}
</style>

<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>

<script type="text/javascript">

		jQuery(document).ready(function(){
			
			jQuery('#img_map').mousemove(function(e){
				jQuery('#map-xy').show();
				var parentOffset = jQuery(this).parent().offset();
				var relativeXPosition = (e.pageX - (parentOffset.left)); //offset -> method allows you to retrieve the current position of an element 'relative' to the document
				var relativeYPosition = (e.pageY - parentOffset.top);
				jQuery('#map-xy').html("X: " + (554-relativeXPosition - 100 ) + " Y: " + parseInt(relativeYPosition-90)); 
			});
			jQuery('#img_map').on('click', function(e){
				var parentOffset = jQuery(this).parent().offset();
				var relativeXPosition = (e.pageX - parentOffset.left); //offset -> method allows you to retrieve the current position of an element 'relative' to the document
				var relativeYPosition = (e.pageY - parentOffset.top);
				jQuery('#cctmmap_area').val( (554-relativeXPosition) - 100 + "," +  parseInt(relativeYPosition-90)); 
			});
			
		
			jQuery('#btn_map_area').click(function(){
				var viewBtn = jQuery(this).val();
				if(viewBtn == "View Map"){
					jQuery(this).val("Hide Map")
					jQuery('#img_map').show(1000).delay(100);
				}else{										
					jQuery('#map-xy').hide(1000).delay(100);
					jQuery(this).val("View Map")
					jQuery('#img_map').hide(1000).delay(100);
				}
			});
		});
		jQuery('#custom_field_map_area #cctmmap_area').after('<input type="button" id="btn_map_area" value="View Map"/><div id="map-xy"></div><div id="img_map"></div>');
</script>
</body>
</html>
