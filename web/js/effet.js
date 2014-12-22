$(document).ready(function()
{
	
	$('.publications-section-title').click(function()
	{
		var text = $(this).next('.publications-section').children('.publications-item-date');
		if(text.is(':hidden')){
			text.slideDown('500');
			$(this).children('span').html('-');
		}
		else
		{
			text.slideUp('300');
			$(this).children('span').html('+');
		}

	});



});