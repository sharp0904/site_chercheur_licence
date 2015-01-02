$(document).ready(function(){
	$( "#publication-reference" ).attr( "required", "required" );
	$( "#publication-reference" ).attr( "title", "Please inform this field" );
	$( "#publication-auteurs" ).attr( "required", "required" );
	$( "#publication-auteurs" ).attr( "title", "Please inform this field" );
	$( "#publication-titre" ).attr( "required", "required" );
	$( "#publication-titre" ).attr( "title", "Please inform this field" );
	$( "#publication-date" ).attr( "required", "required" );
	$( "#publication-date" ).attr( "title", "Please inform this field" );
	
	$( "#year" ).change(function() {
		if( $('#year option:selected').val() == 'Autre')
		{
			$('.field-publication-date:eq(1)').append('<input type="text" id="#year" name ="year" class="year"></input>');
		}
		else
		{
			$('.year').remove();
		}
	});
	
	
	var str = $( "#publication-date" ).val();
	var pop = document.getElementById('year').length;
	var values = [];
	$('#year option').each(function() { values.push($(this).val()); });
	if(str.substr(0, 4) >= values[0] && str.substr(0, 4) <= values[pop-2])
	{
		$("#year").val(str.substr(0, 4));
	}
	else
	{
		$('#year').val("Autre");
		$('.field-publication-date:eq(1)').append('<input type="text" id="year" name ="year" class="year" value="'+str.substr(0, 4)+'"></input>');
		
		return true;
	}
	
	var str = $( "#publication-date" ).val();
	var testMois = str.substr(5, 2);
	var test = str.substr(5, 1);
	if (!isNaN(testMois))
	{
		$("#month").val(str.substr(5, 2));
		if (test == 0)
		{
			$("#month").val(str.substr(6, 1));
		}
	}
	else
	{
		$("#month").val(str.substr(6, 1));
	}
	
	
	$( "#publication-categorie_id" ).change(function() {
		var str = "";
		$( "#publication-categorie_id option:selected" ).each(function() {
		str = $( this ).text();
		if(str == 'Article')
		{
			$( "#publication-journal" ).attr( "required", "required" );
			$( "#publication-journal" ).attr( "title", "Please inform this field" );
			for (var key in data )
			{
				var col = data[key].toLowerCase();
				if(col == "localite" || col == "series" || col == "publisher" || col =="editor")
				{
					$('.field-publication-'+col).hide();
					$('#publication-'+col).val("");
				}
				else
				{
					$('.field-publication-'+col).show();
				}
			}
		}
		  else if(str == 'Conference')
		  {
			  $( "#publication-journal" ).attr( "required", "required" );
			  $( "#publication-journal" ).attr( "title", "Please inform this field" );
			  for (var key in data )
			  {
				var col = data[key].toLowerCase();
				if(col == "volume" || col == "number" || col == "series")
				{
					$('.field-publication-'+col).hide();
					$('#publication-'+col).val("");
				}
				else
				{
					$('.field-publication-'+col).show();
				}
			}
		  }
		  else if(str == 'Rapport technique')
		  {
			  $( "#publication-journal" ).attr( "required", false );
			  for (var key in data )
			  {
				var col = data[key].toLowerCase();
				if(col == "journal" || col == "volume" || col == "pages" || col == "series" || col =="publisher" || col == "editor")
				{
					$('.field-publication-'+col).hide();
					$('#publication-'+col).val("");
				}
				else
				{
					$('.field-publication-'+col).show();
				}
			}
		  }
		  else if(str == 'These')
		  {
			  $( "#publication-journal" ).attr( "required", false );
			  for (var key in data )
			  {
				var col = data[key].toLowerCase();
				if(col == "journal" || col == "volume" || col == "number" || col == "pages" || col == "series" || col =="publisher" || col == "editor")
				{
					$('.field-publication-'+col).hide();
					$('#publication-'+col).val("");
				}
				else
				{
					$('.field-publication-'+col).show();
				}
			}
		  }
		  else if(str == 'Divers')
		  {
			$( "#publication-journal" ).attr( "required", false );
			for (var key in data ){
				var col = data[key].toLowerCase();
				$('.field-publication-'+col).show();
			}
		  }
		});
	}).trigger( "change" );	
	$('.btn-success').click(function()
	{
		var type = $( "#publication-categorie_id option:selected" ).text();
		//alert(type);
	});	
	$('.form-group > .btn-success').click(function() {
		if($('.year').val().length != 4 || isNaN($('.year').val()) || $('.year').val() < 0)
		{ 
			$('.year').val("");
			$('.year').attr("required", "required");
		}
	});
});
