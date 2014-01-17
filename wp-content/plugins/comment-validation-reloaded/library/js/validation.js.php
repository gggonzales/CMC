<?php
//header("Content-type: text/javascript; charset: UTF-8"); 

function comm_js($js) {
	$js = str_replace("\\", "\\\\", $js);
	$js = preg_replace("/[\r\n]+/", '\n', $js);
	$js = str_replace('"', '\"', $js);
	$js = str_replace("'", "\'", $js);
	$js = str_replace(array( "\r", "\n", "\t" ),"", $js);
	//$js = preg_replace("/<script/i", "<scr'+'ipt", $js);
	//$js = preg_replace("/<\/script/i", "</scr'+'ipt", $js);
	return $js;
}

/**
 * Output javascript
 * @ref http://techtites.com/2009/01/31/dynamic-javascript-with-php/
 */
function external_options() {
$id = $_GET['id'];
$min = intval( $_GET['min'] );
if ( $min != "" ) 
	$minout = 'minlength: ' . $min;

	$output = '<script type="text/javascript">
	jQuery(document).ready( function($) {
		var errorContainer = $("<p class=\'error\'>' . __( 'Please fill out the required fields', 'cvr' ) . '</p>").appendTo("#' . $id . '").hide();
		var errorLabelContainer = $("<p class=\'error errorlabels\'></p>").appendTo("#' . $id . '").hide();
		$("#' . $id . '").validate({
			rules: {
				author: "required",
				email: {
					required: true,
					email: true
				},
				url: "url",
				comment: {
					required: true,
					' . $minout . '
				}
			},
			errorContainer: errorContainer,
			errorLabelContainer: errorLabelContainer,
			ignore: ":hidden"
		});
	
		$.validator.messages.required = "" + $.validator.messages.required;
		$.validator.messages.email = "&raquo; " + $.validator.messages.email;
		$.validator.messages.url = "&raquo; " + $.validator.messages.url;
	});
	</script>';
	
	$outputmin = '<script type="text/javascript">jQuery(document).ready( function($){var errorContainer=$("<p class=\'error\'>' . __( 'Please fill out the required fields', 'cvr' ) . '</p>").appendTo("#' . $id . '").hide();var errorLabelContainer=$("<p class=\'error errorlabels\'></p>").appendTo("#' . $id . '").hide();$("#' . $id . '").validate({rules:{author:"required",email:{required:true,email:true},url:"url",comment:{required:true,' . $minout . '}},errorContainer:errorContainer,errorLabelContainer:errorLabelContainer,ignore:":hidden"});$.validator.messages.required=""+$.validator.messages.required;$.validator.messages.email="&raquo; "+$.validator.messages.email;$.validator.messages.url="&raquo; "+$.validator.messages.url;});</script>';
	
	return "document.write('" . comm_js($outputmin) . "');";
	//echo comm_js($outputmin);
}

header("Content-type: application/javascript");
echo external_options();
?>