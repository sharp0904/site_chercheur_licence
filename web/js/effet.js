function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}
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

	$('.bouttonResume').click(function()
	{
			$(this).parent().children(".publi-note").toggle();
			$(this).parent().children(".publi-abstract").toggle();
	});


});