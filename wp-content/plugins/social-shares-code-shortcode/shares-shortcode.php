<?php
/*
Plugin Name: Social Shares Code
Description: Social Shares Code 
*/ 
function getShares($atts) {
  extract(shortcode_atts(array(
    'url' => '',
      'show_count'=>''
  ), $atts));
 
 $urlsnip = substr("$url", 0, 200);
 $sharestransient = 'socialshares_' . $urlsnip;
 $cachedresult =  get_transient($sharestransient);
 if ($cachedresult !== false ) {
  
	return $cachedresult;
        
	} else {
            
  $json_string = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
  
  $json = json_decode($json_string, true);
  $twitter = intval( $json['count'] );

  $json_string = file_get_contents("http://www.linkedin.com/countserv/count/share?url=$url&format=json");
  $json = json_decode($json_string, true);
  $linkedin = intval( $json['count'] );
 
  $json_string = file_get_contents('https://graph.facebook.com/?ids=' . $url);
  $json = json_decode($json_string, true);
  $facebook = intval( $json[$url]['shares'] );
  
  
  $json_string = file_get_contents('http://api.pinterest.com/v1/urls/count.json?callback=&url=' . $url);
  $json = json_decode($json_string, true);
  $pinterest = intval( $json['count'] );
 
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
  $curl_results = curl_exec ($curl);
  curl_close ($curl);
  $json = json_decode($curl_results, true);
  $plusone = intval( $json[0]['result']['metadata']['globalCounts']['count'] );
  
  $total_share=(int)$twitter+$linkedin+$facebook+$plusone+$pinterest;
   
  /*if ($twitter != "0") $text .= "<strong>Twitter</strong>: $twitter times ";
  if ($linkedin != "0") $text .= "<strong>LinkedIn</strong>: $linkedin times ";
  if ($facebook != "0") $text .= "<strong>Facebook</strong>: $facebook times ";
  if ($plusone != "0") $text .= "<strong>GooglePlus</strong>: $plusone +1's";
  if ($pinterest != "0") $text .= "<strong>Pinterest</strong>: $pinterest times";*/
 
  if($show_count==0){
      $result =' <a href="javascript:void(0);" class="video_share"><img src="'.get_template_directory_uri().'/images/share_icon_white.png" alt="" /></a>';
       set_transient($sharestransient, $result, 60*60*4);
  update_option($sharestransient, $result);
      
  }
  else{
    if($total_share ==1)
            $result ='<a href="#" class="share_link">'.$total_share." Share </a>";
    elseif($total_share==0)
            $result ='<a href="#" class="share_link">'.$total_share." Share </a>";
        else
        $result ='<a href="#" class="share_link">'.$total_share." Shares </a>";

    set_transient($sharestransient, $result, 60*60*15);
    update_option($sharestransient, $result);
  }  
  return $result;
  }

}
add_shortcode('postshare', 'getShares');

function get_count_share($url,$count=1){
     
    if($count==0)
    $atts=array('url'=>$url,'show_count'=>'0');
        else
    $atts=array('url'=>$url,'show_count'=>'1');
        
    return getShares($atts);
}
?>