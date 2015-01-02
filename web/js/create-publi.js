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
				$('#publication-'+col).val("");
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
	
	$('.publication-create > .btn-success').click(function() {
			alert('Jambon');
		});
});
