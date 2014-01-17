<?php
	class TicketSocketEvents {
		private $eventsList;
		private $site;
		private $eventsHomeUrl;
		private $options;
		
		function __construct() {
			$this->options = get_option('ts_settings_options');
			
			$this->site = trim($this->options["ticketSocketUrl"], '/').'/';
			if (strpos($this->site, 'http://') === false && strpos($this->site, 'https://') === false)
				$this->site = 'http://'.$this->site;
			
			$this->eventsHomeUrl = TICKETSOCKETBASEURL.'/';
		}
		
		function sendRequest($url, $parameters = '') {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->site."tickets/plugs/".$url."/");
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER["HTTP_HOST"].'/'.$_SERVER["REQUEST_URI"]);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$theResult = curl_exec($ch);
			curl_close($ch);
			
			return $theResult;
		}
		
		function adjustTime($original) {
			return $original - (4 * 60 * 60);
		}
		
		function requestEvents($eventParameter = '') {
			global $wp_query;
			$eventsUrl = 'eventFeed';
			return $this->sendRequest($eventsUrl, $eventParameter);
		}
		
		function requestCategories($categoryId = false, $group = false) {
			$categoryUrl = 'categoryFeed';
			$categoryParameter = '';
			if ($categoryId > 0)
				$categoryParameter = "category=".$categoryId;
			if ($group != '')
				$categoryParameter = "&group=".$group;
			$theResult = $this->sendRequest($categoryUrl, $categoryParameter);
			
			$array = json_decode($theResult);
				
			$formattedTypes = array();
			
			if (is_array($array))
				foreach ($array as $category)
					$formattedTypes[] = array(
						'id' => $category->id,
						'title' => $category->title,
						'categoryGroup' => $category->categoryGroup,
						'sefUrl' => $category->sefUrl,
						'description' => base64_decode($category->description),
						'listPic' => ($category->listPic != '' ? $this->site.'tickets/pics/'.$category->listPic : '/wp-content/plugins/ticketSocketEvents/images/dateIcon_'.time().'.png')
					);
					
			return $formattedTypes;
		}
		
		function requestTicketTypes($eventId) {
			$ticketTypeUrl = 'ticketTypesFeed';
			$eventParameter = "event=".$eventId;
			$theResult = $this->sendRequest($ticketTypeUrl, $eventParameter);
			
			$array = json_decode($theResult);
				
			$formattedTypes = array();
			
			if (is_array($array))
				foreach ($array as $oneTicket)
					$formattedTypes[] = array(
						'id' => $oneTicket->id,
						'name' => base64_decode($oneTicket->name),
						'description' => base64_decode($oneTicket->description).'&nbsp;',
						'price' => number_format($oneTicket->price, 2),
						'onSale' => floor($oneTicket->onSale),
						'buttonText' => trim($oneTicket->buttonText),
						'limitQuantity' => floor($oneTicket->limitQuantityOptions),
						'maxQuantity' => floor($oneTicket->quantityMaximum),
						'minQuantity' => floor($oneTicket->quantityMinimum)
					);
					
			return $formattedTypes;
		}
		
		function requestTicketPackages($eventId) {
			$ticketTypeUrl = 'packagesFeed';
			$eventParameter = "event=".$eventId;
			$theResult = $this->sendRequest($ticketTypeUrl, $eventParameter);
			
			$array = json_decode($theResult);
				
			$formattedPackages = array();
			
			if (is_array($array))
				foreach ($array as $onePackage)
					$formattedPackages[] = array(
						'id' => $onePackage->id,
						'title' => base64_decode($onePackage->title),
						'description' => base64_decode($onePackage->description).'&nbsp;',
						'price' => number_format($onePackage->price, 2),
						'onSale' => floor($onePackage->onSale),
						'buttonText' => trim($onePackage->buttonText)
					);
					
			return $formattedPackages;
		}
		
		function loadEvents($eventId = false, $categoryId = false, $locationFilter = false, $categoryFilter = false, $nameFilter = false) {
			$eventParameter = array();
			if ($eventId > 0)
				$eventParameter[] = "event=".$eventId;
			if ($categoryId > 0)
				$eventParameter[] = "category=".$categoryId;
			if ($locationFilter > 0)
				$eventParameter[] = "category2=".$locationFilter;
			if ($categoryFilter > 0)
				$eventParameter[] = "category3=".$categoryFilter;
			if ($nameFilter != '')
				$eventParameter[] = "title=".trim($nameFilter);
			$eventParameter = implode("&", $eventParameter);
		
			$result = $this->requestEvents($eventParameter);
			$array = json_decode($result);
	
			$formatted = array();
			
			if (is_array($array))
				foreach ($array as $event)
					$formatted[] = array(
						'id' => $event->id,
						'title' => base64_decode($event->title),
						'start' => date("h:ia n/j/Y", $event->start),
						'startTime' => $event->start,
						'end' => date("h:ia n/j/Y", $event->end),
						'endTime' => $event->end,
						'sefUrl' => $event->sefUrl,
						'url' => $this->site.$event->sefUrl,
						'smallPic' => ($event->smallPic != '' ? $this->site.'tickets/pics/'.$event->smallPic : '/wp-content/plugins/ticketSocketEvents/images/dateIcon_'.$event->start.'.png'),
						'hasActualSmallPic' => ($event->smallPic != '' ? true : false),
						'largePic' => $this->site.'tickets/pics/'.$event->largePic,
						'hasActualLargePic' => ($event->largePic != '' ? true : false),
						'description' => base64_decode($event->description),
						'shortDescription' => base64_decode($event->description),
						'venue' => base64_decode($event->venue),
						'location' => base64_decode($event->location),
						'buttonText' => trim($event->buttonText)
					);
				
			$this->eventsList = $formatted;
		}
		
		function getEvents() {
			return $this->eventsList;
		}
		
		function getEventImage($event) {
			return $event["smallPic"];
		}
		
		function getCategoryImage($category) {
			return $category["listPic"];
		}
		
		function getEventBigImage($event) {
			return $event["largePic"];
		}
		
		function getEventLink($event) {
			return $event["url"];
		}
		
		function getSite() {
			return $this->site;
		}
		
		function getCategoryTitle($categoryId) {
			$categories = $this->requestCategories($categoryId);
			$category = $categories[0];
		
			return $category["title"];
		}
		
		function getEventsHomeUrl() {
			return $this->eventsHomeUrl;
		}

		function getEventTicketsAndPackages($eventId, $event)
		{
			$output = '';
			$ticketPackages = $this->requestTicketPackages($eventId);
			
			$checkoutHash = '#checkout';
			if ($this->options["addToCartTarget"] == 'event')
				$checkoutHash = '';
			
			$output .= '
		<form name="addToCartForm" action="'.$this->getSite().'tickets/plugs/cartInterface/" method="post">
			<input type="hidden" name="redirectTo" value="'.$event["url"].'&Tickets'.$checkoutHash.'" />
			<div class="pal_event_ticket_round_pan">
				<span class="round_pan_caption"><strong>Ticket Info</strong></span>';
			
				foreach ($ticketPackages as $onePackage)
				{
					$output .='
				<div class="pal_event_ticket_round_pan_row">
					<input type="hidden" name="cartTasks[packageId_'.$onePackage["id"].'][packageId]" id="packageId_'.$onePackage["id"].'" value="'.$onePackage["id"].'" />
					<input type="hidden" name="cartTasks[packageId_'.$onePackage["id"].'][eventId]" value="'.$event["id"].'" />
					<input type="hidden" name="cartTasks[packageId_'.$onePackage["id"].'][cartTask]" value="update" />
					<input type="hidden" name="cartTasks[packageId_'.$onePackage["id"].'][eventType]" value="ticketPackages" />
					<h4>'.$onePackage["title"].(trim($onePackage["description"]) != '' && trim($onePackage["description"]) != '&nbsp;' ? '<a href="javascript: TicketSocketEvents.toggleMoreInfo(\'package_'.$onePackage["id"].'\');">more info</a>' : '').'</h4>
					
					'.(trim($onePackage["description"]) != '' && trim($onePackage["description"]) != '&nbsp;' ? '<div class="moreInfo" id="moreInfo_package_'.$onePackage["id"].'">'.trim($onePackage["description"]).'</div>' : '');
				
					if ($onePackage["onSale"] == 0 && false)
						$output .= '<span class="notOnSale">Not on Sale</span>';
					else
					{
						$output .= '
					<div class="addtocart_box">
						<select name="cartTasks[packageId_'.$onePackage["id"].'][quantity]" id="">
							';
							
						for ($i = 0; $i <= 20; $i++)
							$output .= '<option value="'.$i.'">'.$i.'</option>';
							
						$output .= '
						</select>
					</div><!-- End: addtocart_box -->';
					}
					
					$output .= '
					<span>&#36;'.number_format($onePackage["price"], 2).'</span>
				</div><!-- End: pal_event_ticket_round_pan_row -->';
				}
				
				$ticketTypes = $this->requestTicketTypes($eventId);
				foreach ($ticketTypes as $oneType)
				{
				
					$output .='
				<div class="pal_event_ticket_round_pan_row">
					<input type="hidden" name="cartTasks[typeId_'.$oneType["id"].'][typeId]" id="typeId_'.$oneType["id"].'" value="'.$oneType["id"].'" />
					<input type="hidden" name="cartTasks[typeId_'.$oneType["id"].'][eventId]" value="'.$event["id"].'" />
					<input type="hidden" name="cartTasks[typeId_'.$oneType["id"].'][cartTask]" value="update" />
					<input type="hidden" name="cartTasks[typeId_'.$oneType["id"].'][eventType]" value="typedTickets" />
					<h4>'.$oneType["name"].(trim($oneType["description"]) != '' && trim($oneType["description"]) != '&nbsp;' ? '<a href="javascript: TicketSocketEvents.toggleMoreInfo(\''.$oneType["id"].'\');">more info</a>' : '').'</h4>
					
					'.(trim($oneType["description"]) != '' && trim($oneType["description"]) != '&nbsp;' ? '<div class="moreInfo" id="moreInfo_'.$oneType["id"].'">'.trim($oneType["description"]).'</div>' : '');
				
					if ($oneType["onSale"] == 0)
						$output .= '<span class="notOnSale">Not on Sale</span>';
					else
					{
						$output .= '
					<div class="addtocart_box">
						<select name="cartTasks[typeId_'.$oneType["id"].'][quantity]" id="">
							<option value="0">0</option>
							';
							
						$start = ($oneType["minQuantity"] > 1 ? $oneType["minQuantity"] : 1);
						$stop = ($oneType["maxQuantity"] > 0 ? $oneType["maxQuantity"] : 20);
							
						for ($i = $start; $i <= $stop; $i++)
							$output .= '<option value="'.$i.'">'.$i.'</option>';
							
						$output .= '
						</select>
					</div><!-- End: addtocart_box -->';
					}
					
					$output .= '
					<span>&#36;'.number_format($oneType["price"], 2).'</span>
				</div><!-- End: pal_event_ticket_round_pan_row -->';
				}
			$output .= '
				<div class="pal_event_ticket_round_pan_row">
					<ul class="event_payment_gateway_menu">
						<li><img src="'.home_url().'/wp-content/plugins/ticketSocketEvents/images/payment_01.png" alt="amex"></li>
						<li><img src="'.home_url().'/wp-content/plugins/ticketSocketEvents/images/payment_02.png" alt="discover"></li>
						<li><img src="'.home_url().'/wp-content/plugins/ticketSocketEvents/images/payment_03.png" alt="master"></li>
						<li><img src="'.home_url().'/wp-content/plugins/ticketSocketEvents/images/payment_04.png" alt="visa"></li>
					</ul>
					
				</div><!-- End: pal_event_ticket_round_pan_row -->
					
			</div><!-- End: pal_event_ticket_round_pan -->
			
			<input type="submit" class="addToCartButton" value="Checkout" /><span class="span_close"><a href="javascript:void(0);" class="a_close">close</a></span>
		</form>';
				
			return $output;
		}
	}
?>