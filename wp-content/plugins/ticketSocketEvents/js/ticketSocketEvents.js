TicketSocketEvents = function()
{

};

TicketSocketEvents.toggleMoreInfo = function(typeId)
{
	if (jQuery('#moreInfo_' + String(typeId)).is(':visible'))
		jQuery('#moreInfo_' + String(typeId)).slideUp('fast');
	else
		jQuery('#moreInfo_' + String(typeId)).slideDown('fast');
};