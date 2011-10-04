$(document).ready(function()
{
	// EXTERNAL URL
	$("a[href^='http:']").not("[href*='" + window.location.hostname + "']").attr('target','_blank');
	
	// NAV HOVER
	$('ul li').hover(function(){ $(this).addClass('hover').find('a:first').addClass('hover'); }, function(){ $(this).removeClass('hover').find('a:first').removeClass('hover'); });
	
	// FIRST LAST CLASSES ON LISTS
	$('ul li:first-child').addClass('first');
	$('ul li:last-child').addClass('last');
	
	// PNGFIX
	DD_belatedPNG.fix('.pngfix');
});

(function($)
{
	$.fn.autofill = function(options)
	{
		options = $.extend({
			startColor: '#999',
			endColor: '#000'
		}, options);
		
		$(this).each(function()
		{
			if(!$(this).is('input')) return;
			var text = $(this).val();
			$(this).css({ color: options.startColor }).focus(function()
			{
				if($(this).val() == text)
				{
					$(this).val('').css({ color: options.endColor });
				}
			}).blur(function()
			{
				if($(this).val() == '')
				{
					$(this).css({ color: options.startColor }).val(text);
				}
			});
		});
	}
});