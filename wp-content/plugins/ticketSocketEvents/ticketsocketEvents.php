<?php
	/**
	 * @package TicketSocketEvents
	 * @version 1.0.1
	 */
	/*
	Plugin Name: TicketSocket Events
	Description: This plug loads a dynamic events list from your TicketSocket site.
	Author: Enertia Development
	Version: 1.0.1
	*/
	
	include(dirname(__FILE__)."/settings.php");
	include(dirname(__FILE__)."/ticketSocket.php");
	$options = get_option('ts_settings_options');

	$rootPage = trim($_SERVER["REQUEST_URI"], "/");
	$rootPage = explode("/", $rootPage);
	$rootPage = $rootPage[0];

	define("TICKETSOCKETBASEURL", "/".$rootPage);

	function showTicketSocketEvent() {
		global $wp_query;
		
		$ticketSocket = new TicketSocketEvents();
		$ticketSocket->loadEvents($wp_query->query_vars["eventId"]);
		$event = $ticketSocket->getEvents();
		$event = $event[0];
		
		echo '
<h2>'.$event["title"].'<a href="'.$ticketSocket->getEventsHomeUrl().'">top</a></h2>
<div id="ticket_event_content">
	<div class="event_detail_top_pan">';
	
		echo '
		<div class="event_single_row_img_box">
			<img src="'.$event["smallPic"].'" width="140" height="105" alt="'.$event["title"].'">
		</div>';
		
		echo '
		<div class="event_detail_wh_box">
			<h3>When</h3>
			<p>'.date("F jS Y g:i a", $ticketSocket->adjustTime($event["startTime"])).'</p> 
			<p>to '.date("F jS Y g:i a", $ticketSocket->adjustTime($event["endTime"])).'</p>
		</div>
		
		<div class="event_detail_wh_box modify_event_detail_wh_box">
			<h3>Where</h3>
			<p>'.$event["venue"].'<br> '.$event["location"].'</p>
			<a href="http://maps.google.com/?q='.strip_tags(str_replace("<br />", '+', str_replace("<br>", '+', str_replace(" ", '+', $event["location"])))).'" target=""><span class="stamp_symble_box"><img src="/wp-content/plugins/ticketSocketEvents/images/symble_stamp.png" width="45" height="43" alt="stamp"></span></a>
		</div>
	</div><!-- End: event_detail_top_pan -->';
		
		echo $ticketSocket->getEventTicketsAndPackages($event["id"], $event);
		
		echo '
	';
	
		echo '
  	<div class="pal_event_ticket_round_pan">
		<span class="round_pan_caption"><strong>Description</strong></span>
		'.$event["description"].'
		'.($event["hasActualLargePic"] ? '<div class="event_big_img_box"><img src="'.$event["largePic"].'" alt="'.$event["title"].'"></div>' : '').'
		
	</div><!-- End: pal_event_ticket_round_pan -->
</div>';
	}

	function showTicketSocketEvents() {
		global $wp_query;
		$options = get_option('ts_settings_options'); 
		
		$ticketSocket = new TicketSocketEvents();
		$ticketSocket->loadEvents(false, $wp_query->query_vars["categoryId"], $_POST["locationFilter"], $_POST["categoryFilter"], $_POST["nameFilter"]);
		$events = $ticketSocket->getEvents();
	
		$titleAddition = '';
		if ($wp_query->query_vars["categoryId"] > 0)
			$titleAddition = ': '.$ticketSocket->getCategoryTitle($wp_query->query_vars["categoryId"]);
		
		$locations = $ticketSocket->requestCategories(false, 'location');
		$types = $ticketSocket->requestCategories(false, 'type');
		
		echo '
	<h2>Upcoming Events'.$titleAddition.'<a href="'.$ticketSocket->getEventsHomeUrl().'">top</a></h2>';
		
		if ($options["searchFilters"] == 'on')
		{
			echo '
	 <div class="event_user_utility_box">
	 	<form name="eventsSearchForm" id="eventsSearchForm" action="'.$ticketSocket->getEventsHomeUrl().'" method="post">
			<div class="event_user_utility_box_left">
				<select name="locationFilter" style="width:101px; height:37px; margin-right:16px;" class="styled">
					<option value="">Location</option>';
					
					if (is_array($locations))
						foreach ($locations as $oneLocation)
							echo '
					<option value="'.$oneLocation["id"].'"'.($oneLocation["id"] == $_POST["locationFilter"] ? ' selected="selected"' : '').'>'.$oneLocation["title"].'</option>';
					
		echo '
				</select>
				
				<select name="categoryFilter" style="width:101px; height:37px;" class="styled">
					<option value="">Category</option>';
			
					if (is_array($types))
						foreach ($types as $oneType)
							echo '
					<option value="'.$oneType["id"].'"'.($oneType["id"] == $_POST["categoryFilter"] ? ' selected="selected"' : '').'>'.$oneType["title"].'</option>';
							
		echo '
				</select>
			</div>
			
			<div class="event_user_utility_box_right">
				<input type="text" class="input_search_event" value="'.$_POST["nameFilter"].'" name="nameFilter" id="nameFilter" placeholder="Search for Event"/>
				<input type="submit" value="submit" class="searchEventsButton" />
			</div>
		</form>
	</div><!-- End: event_user_utility_box -->';
		}
		
		foreach ($events as $event) {
			echo '
	<div class="event_single_row">
		<div class="event_single_row_left">
		
			<div class="event_single_row_img_box"><img src="'.$ticketSocket->getEventImage($event).'" width="140" height="105" alt="'.$event["title"].'"></div>
			
			<h3><a href="'.TICKETSOCKETBASEURL.'/'.$event["id"].'/'.$event["sefUrl"].'">'.$event["title"].'</a></h3>
			<p><em>'.$event["venue"].'</em></p>
			
		</div>
		
		<div class="event_single_row_right">
		
			<div class="event_single_row_right_day_box">
				<h3>'.date("l", $ticketSocket->adjustTime($event["startTime"])).'</h3>
				<p><em>'.date("F jS, Y", $ticketSocket->adjustTime($event["startTime"])).'</em></p>
			</div>
			
			<a href="'.TICKETSOCKETBASEURL.'/'.$event["id"].'/'.$event["sefUrl"].'"><input type="button" class="buyTicketsButton" value="'.$event["buttonText"].'" onclick="window.location = \''.TICKETSOCKETBASEURL.'/'.$event["id"].'/'.$event["sefUrl"].'\';" /></a>
		</div>';
			
			echo '
	</div>';
		}
		
		if (count($events) == 0)
			echo '<p class="error"><strong>No Events Found!</strong> Please broaden your search and try again.</p>';
	}
	
	function showTicketSocketCategoriesMenu() {
		global $wp_query;
		
		$ticketSocket = new TicketSocketEvents();
		$categories = $ticketSocket->requestCategories(false, 'type');
		
		foreach ($categories as $category) {
			echo '
	<div class="pal_event_ticket_round_pan small">
		<div class="blueBar"><strong>'.$category["title"].'</strong></div>';
		
			$ticketSocket->loadEvents(false, $category["id"]);
			$events = $ticketSocket->getEvents();
			foreach ($events as $event)
				echo '
		<div class="pal_event_ticket_round_pan_row small">
			<a class="eventLink" href="'.TICKETSOCKETBASEURL.'/'.$event["id"].'/'.$event["sefUrl"].'">'.(strlen($event["title"]) < 38 ? $event["title"] : substr($event["title"], 0, 38).'...').'</a>
		</div>';
		
			echo '
		<div class="pal_event_ticket_round_pan_row small last">
			<a href="'.TICKETSOCKETBASEURL.'/category-'.$category["id"].'/'.$category["sefUrl"].'">View All...</a>
		</div>	
	</div>';
		}
	}
	
	function showTicketSocketCategories() {
		global $wp_query;
		
		$ticketSocket = new TicketSocketEvents();
		$categories = $ticketSocket->requestCategories(false);
		
		echo '
	<h2>Upcoming Events'.$titleAddition.'<a href="'.$ticketSocket->getEventsHomeUrl().'">top</a></h2>';
		
		foreach ($categories as $category) {
			echo '
	<div class="event_single_row">
		<div class="event_single_row_left">
		
			<div class="event_single_row_img_box">
				<a href="'.TICKETSOCKETBASEURL.'/category-'.$category["id"].'/'.$category["sefUrl"].'">
					<img src="'.$ticketSocket->getCategoryImage($category).'" width="140" height="105" alt="'.$category["title"].'">
				</a>
			</div>
			
			<h3><a href="'.TICKETSOCKETBASEURL.'/category-'.$category["id"].'/'.$category["sefUrl"].'">'.$category["title"].'</a></h3>
			<p class="description">'.$category["description"].'</p>
		</div>
		
		<div class="event_single_row_right">
			<a href="'.TICKETSOCKETBASEURL.'/category-'.$category["id"].'/'.$category["sefUrl"].'"><input type="button" class="buyTicketsButton" value="See Events" onclick="window.location = \''.TICKETSOCKETBASEURL.'/category-'.$category["id"].'/'.$category["sefUrl"].'\';" /></a>
		</div>';
			
			echo '
	</div>';
		}
		
		if (count($categories) == 0)
			echo '<p class="error"><strong>No Events Found!</strong> Please broaden your search and try again.</p>';
	}
	
	function showTicketSocket($content) {
		$options = get_option('ts_settings_options');
			
		global $wp_query;
	
		if ($options["categoryMenus"] == 'on')
		{
			echo '
<div id="categoryFilters">
	<h2>Event Categories</h2>
	<div id="ticketSocketCategoryFilters">';
	
			showTicketSocketCategoriesMenu();
	
			echo '
	</div>
</div>';
		}
		
		echo ' 
<div id="ticketSocketEvents"'.($options["categoryMenus"] == 'on' ? ' class="categoriesOn"' : '').'>';

		if ($wp_query->query_vars["eventId"] > 0)
			showTicketSocketEvent();
		else if ($options["categoryPage"] == 'on' && $wp_query->query_vars["categoryId"] < 1)
			showTicketSocketCategories();
		else
			showTicketSocketEvents();
		
		echo '
</div>
<br style="clear: both;" />';
	}
	wp_enqueue_script("jquery");
	
	wp_enqueue_script('ticketsocketevents_js_main', plugins_url().'/ticketSocketEvents/js/ticketSocketEvents.js', array('jquery'));
	wp_enqueue_script('ticketsocketevents_js_inputs', plugins_url().'/ticketSocketEvents/js/inputs.js', array('jquery'));
	
	wp_enqueue_style('ticketsocketevents_css_list', plugins_url().'/ticketSocketEvents/css/list.css');
	wp_enqueue_style('ticketsocketevents_css_details', plugins_url().'/ticketSocketEvents/css/details.css');
	wp_enqueue_style('ticketsocketevents_css_inputs', plugins_url().'/ticketSocketEvents/css/inputs.css');
	wp_enqueue_style('ticketsocketevents_css_buttons', plugins_url().'/ticketSocketEvents/css/buttons.css');
	
	
	function addTicketSocketQueryVars($aVars) {
		$aVars[] = "eventId";
		$aVars[] = "eventSefUrl";
		$aVars[] = "categoryId";
		$aVars[] = "categorySefUrl";
		return $aVars;
	}
	 
	// hook addTicketSocketQueryVars function into query_vars
	add_filter('query_vars', 'addTicketSocketQueryVars');
	
	function addTicketSocketRewriteRules($aRules) {
		$aNewRules = array(trim(TICKETSOCKETBASEURL, '/').'/([0-9a-z]+)/([^/]+)([/]*)?$' => 'index.php?pagename='.trim(TICKETSOCKETBASEURL, '/').'&eventId=$matches[1]&eventSefUrl=$matches[2]');
		$aRules = $aNewRules + $aRules;
		$aNewRules = array(trim(TICKETSOCKETBASEURL, '/').'/category-([0-9a-z]+)/([^/]+)([/]*)?$' => 'index.php?pagename='.trim(TICKETSOCKETBASEURL, '/').'&categoryId=$matches[1]&categorySefUrl=$matches[2]');
		$aRules = $aNewRules + $aRules;
		return $aRules;
	}
	add_filter('rewrite_rules_array', 'addTicketSocketRewriteRules');
	 
	// hook addTicketSocketRewriteRules function into rewrite_rules_array
	add_shortcode('events', 'showTicketSocket');
	
	function ticketSocketTicketsOnly($args) {
		$ticketSocket = new TicketSocketEvents();
		
		$eventId = $args["0"];
		$ticketSocket->loadEvents($eventId);
		$event = $ticketSocket->getEvents();
		$event = $event[0];
		
		$output = $ticketSocket->getEventTicketsAndPackages($eventId, $event);
		
		return '<div class="ticketsocket_div">'.$output.'</div>';
	}
	add_shortcode('tickets', 'ticketSocketTicketsOnly');
?>