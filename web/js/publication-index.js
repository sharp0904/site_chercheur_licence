$(document).ready(function(){
		
		
		
		
		//Fais apparaitre le formulaire de creation au dessus de la page
		$('#formCrea').click(function(){
			
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
			{
				$('.publication-create').css('height', 'auto');
				window.location.replace("index.php?r=publication/create");
			}
			else
			{
				
				$("#formu").load("index.php?r=publication/create .publication-create", function()
				{
					$( "#publication-reference" ).attr( "required", "required" );
					$( "#publication-auteurs" ).attr( "required", "required" );
					$( "#publication-titre" ).attr( "required", "required" );
					$( "#publication-date" ).attr( "required", "required" );
					
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
				});
				$('#formu').hide(500);
				$('#formu').show(500);
			}
		
		});
	
		
		//Fais apparaitre le formulaire d'edition au dessus de la page
		$('input[type=image]').click(function()
		{
			var ID =$(this).val();
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
			{
				$('.publication-update').css('height', 'auto');
				window.location.replace("index.php?r=publication/update&id="+ID);
			}
			else
			{
				$("#formu").load("index.php?r=publication/update&id="+ID+" .publication-update", function()
				{
					$( "#publication-reference" ).attr( "required", "required" );
					$( "#publication-auteurs" ).attr( "required", "required" );
					$( "#publication-titre" ).attr( "required", "required" );
					$( "#publication-date" ).attr( "required", "required" );
					
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
					
					var values;
					$('#year option').each(function() { values = $(this).val(); });
					var str = $( "#publication-date" ).val();
					var cpt = 0;
						var pop = document.getElementById('year').length;
						//alert(values);
						if(str.substr(0, 4) >= document.getElementById('year').options[0] && str.substr(0, 4) >= document.getElementById('year').options[pop-1])
						{
							$("#year").val(str.substr(0, 4));
						}
						else
						{
							$('#year').val("Autre");
							$('.field-publication-date:eq(1)').append('<input type="text" id="year" name ="year" class="year" value="'+str.substr(0, 4)+'"></input>');
							
							return true;
						}
						cpt = cpt +1;
					
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
				});
				$('#formu').hide(500);
				$('#formu').show(500);
				window.top.window.scrollTo(0,0);
			}
		});
				
		
		//Cache le formulaire d'upload de BibTeX
		$('.fileInput').hide();
		$('#validerUpBib').hide();
		
		//Lors du clic sur #selecBib, fais apparaître ou disparaître le formulaire d'upload de BibTeX
		$("#selecBib").click(function(){
			$('.fileInput').toggle(1500);
			$('#validerUpBib').toggle(1000);
		});

		//Debut de la gestion de l'affichage des colonnes
		$("#selectReference").click(function(){
			$('.ref').toggle(1000);
			
		});
		$("#selectAuteurs").click(function(){
			$('.auteurs').toggle(1000);
		});
		$("#selectDate").click(function(){
			$('.date').toggle(1000);
		});
		$("#selectTitre").click(function(){
			$('.titre').toggle(1000);
		});
		$("#selectJournal").click(function(){
			$('.journal').toggle(1000);
		});
		$("#selectVolume").click(function(){
			$('.volume').toggle(1000);
		});
		$("#selectNumber").click(function(){
			$('.number').toggle(1000);
			/*if($('.publication-index').width() < $('#keywords').width())
			{
				$('.publication-index').css('width', $('#keywords').width() + 50);
			}*/
		});
		$("#selectPages").click(function(){
			$('.pages').toggle(1000);
		});
		$("#selectNote").click(function(){
			$('.note').toggle(1000);
		});
		$("#selectAbstract").click(function(){
			$('.abstract').toggle(1000);
		});
		$("#selectKeywords").click(function(){
			$('.keywords').toggle(1000);
		});
		$("#selectSeries").click(function(){
			$('.series').toggle(1000);
		});
		$("#selectLocalite").click(function(){
			$('.localite').toggle(1000);
		});
		$("#selectPublisher").click(function(){
			$('.publisher').toggle(1000);
		});
		$("#selectEditor").click(function(){
			$('.editor').toggle(1000);
		});
		//Fin de la gestion de l'affichage des colonnes
		
		//Désactive le bouton "Delete"
		$("#deleteMulti").attr("disabled","disabled");
		
		//Active le bouton "Delete" si une checkbox est coché, le desactive sinon
		$( '#keywords input[type=checkbox]' ).click(function()
		{
			if($('#keywords input[type=checkbox]:checked').prop('checked') != true)
			{
				$("#deleteMulti").attr("disabled","disabled");
			}
			else
			{
				$("#deleteMulti").attr("disabled",false);
			}
			
		});
		
		//Permet de cocher toute les checkbox de la table keywords
		$('#select-all').click(function()
		{
			if($('#select-all').prop('checked') == true)
			{	
				$('#keywords :checkbox').each(function() {
					this.checked = true;                        
				});
				$("#deleteMulti").attr("disabled",false);
			}
			else
			{
				$('#keywords :checkbox').each(function() {
					this.checked = false;  
				});
				$("#deleteMulti").attr("disabled","disabled");
			}		
		});
		

		//Lors du clic sur le bouton 'Delete', envoi l'id de la publication coché 
		$('#deleteMulti').click(function(){
			var valeurs = [];
			$('input:checked[name=selection]').each(function() {
			  valeurs.push($(this).val());
			});
			var keys = valeurs;
			$.ajax({
			   type: 'POST',
			   url: "index.php?r=publication/deletemulti", 
			   data: {'keylist':keys},
			   success: function()
			   {
				   window.location.replace("index.php?r=publication/index");
			   },
			   error: function()
			   {
				   $("#error").html("Une erreur est survenue! (Aucune publication?)");
			   }
			});
		});
		
		$(function($){
			$("#keywords").tablesorter({widthFixed: true, widgets:  ['zebra', 'filter']}); 
		}); 
		
		$('#keywords').each(function() {
			var currentPage = 0;
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
			{
				var numPerPage = 6;
			}
			else
			{
				var numPerPage = 20;
			}
			var $table = $(this);
			$table.bind('repaginate', function() {
				$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
			});
			$table.trigger('repaginate');
			var numRows = $table.find('tbody tr').length;
			var numPages = Math.ceil(numRows / numPerPage);
			var $pager = $('<div class="pager"></div>');
			for (var page = 0; page < numPages; page++) {
				$('<span class="page-number"></span>').text(page + 1).bind('click', {
					newPage: page
				}, function(event) {
					currentPage = event.data['newPage'];
					$table.trigger('repaginate');
					$(this).addClass('active').siblings().removeClass('active');
				}).appendTo($pager).addClass('clickable');
			}
			$pager.insertBefore('#gestion-table').find('span.page-number:first').addClass('active');
		});
	
	});
