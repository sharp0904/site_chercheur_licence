<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\librairies\FonctionsPublications;
use app\models\Publication;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publications';
$cpt = 0;
?>

<script type="text/javascript" src="../vendor/bower/jquery/dist/jquery.js"></script>

<div class="publication-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <p>
        <?= Html::Button('Create Publication' , ['class' => 'btn btn-success', 'id' => 'formCrea']) ?>
        
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div id ='formu'>
        </div>
        <div>
			<?= Html::Button('Create Publication via bibtex' , ['class' => 'btn btn-success', 'id' => 'selecBib']) ?>
		</div>
        <div class="fileInput"><?= $form->field($model, 'Bibtex')->fileInput() ?>
			<?= Html::submitButton('Valider' , ['class' => 'btn btn-primary', 'id' => 'validerUpBib']) ?>
        </div>
        </br></br>
        <?php ActiveForm::end(); ?>
        
       
        
		<table id ="check">
			<tbody>
		<?php foreach(Publication::attributeLabels() as $colonne)
				{
					if($cpt==0)
					{
						echo("<tr>");
					}
					if($colonne == "Reference"||$colonne == "Auteurs"||$colonne == "Titre"||$colonne == "Date"||$colonne == "Journal")
					{
						echo("<td><span>");
						echo("<input type='checkbox' id='select".$colonne."' checked=true>".$colonne);
						echo("</span></td>");
						$cpt++;
					}
					else if($colonne != "ID" && $colonne !="Date Display" && $colonne != "Pdf" && $colonne != "Categorie ID")
					{
						echo("<td><span>");
						echo("<input type='checkbox' id='select".$colonne."'>".$colonne);
						echo("</span></td>");
						$cpt++;
					}
					if($cpt==4)
					{
						echo("</tr>");
						$cpt = 0;
					}
				}
		?>
			</tbody>
		</table>
		
		 </br></br>
			<?= Html::submitButton('Delete' , ['class' => 'btn btn-delete', 'id' => 'deleteMulti']) ?>
			
    </p>
    
    <div id="error"></div>
    
   
</div>


<?php
try
{
	FonctionsPublications::getTabPublications();
}
catch(Exception $e)
{
	echo("Aucune publication");
}
?>



<script>


	function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
    alert(out);
}


	$(document).ready(function(){
		
		$('#formu').hide();
		
		//Fais apparaitre le formulaire de creation au dessus de la page
		$('#formCrea').click(function(){
			$("#formu").load("index.php?r=publication/create .publication-create");
			$('#formu').show(500);
		});
		
		//Fais apparaitre le formulaire d'edition au dessus de la page
		$('input[type=image]').click(function()
		{
			var ID =$(this).val();
			$("#formu").load("index.php?r=publication/update&id="+ID+" .publication-update");
			$('#formu').show(500);
			window.top.window.scrollTo(0,500);
		});
		
		
		//Cache le formulaire d'upload de BibTeX
		$('.fileInput').hide();
		
		//Lors du clic sur #selecBib, fais apparaître ou disparaître le formulaire d'upload de BibTeX
		$("#selecBib").click(function(){
			if ($('.fileInput').css('display') == 'none')
			{
				$('.fileInput').show(1000);
				$('#validerUpBib').show(1500);
			}
			else
			{
				$('.fileInput').hide(1500);
				$('#validerUpBib').hide(1000);
			}
		});

		//Debut de la gestion de l'affichage des colonnes
		$("#selectReference").click(function(){
			if(!$('#selectReference:checked').prop('checked') != true)
			{
				$('.ref').show(1000);
			}
			else
			{
				$('.ref').hide(1500);
			}
		});
		$("#selectAuteurs").click(function(){
			if(!$('#selectAuteurs:checked').prop('checked') != true)
			{
				$('.auteurs').show(1000);
			}
			else
			{
				$('.auteurs').hide(1500);
			}
		});
		$("#selectDate").click(function(){
			if(!$('#selectDate:checked').prop('checked') != true)
			{
				$('.date').show(1000);
			}
			else
			{
				$('.date').hide(1500);
			}
		});
		$("#selectTitre").click(function(){
			if(!$('#selectTitre:checked').prop('checked') != true)
			{
				$('.titre').show(1000);
			}
			else
			{
				$('.titre').hide(1500);
			}
		});
		$("#selectJournal").click(function(){
			if(!$('#selectJournal:checked').prop('checked') != true)
			{
				$('.journal').show(1000);
			}
			else
			{
				$('.journal').hide(1500);
			}
		});
		$("#selectVolume").click(function(){
			if(!$('#selectVolume:checked').prop('checked') != true)
			{
				$('.volume').show(1000);
			}
			else
			{
				$('.volume').hide(1500);
			}
		});
		$("#selectNumber").click(function(){
			if(!$('#selectNumber:checked').prop('checked') != true)
			{
				$('.number').show(1000);
			}
			else
			{
				$('.number').hide(1500);
			}
		});
		$("#selectPages").click(function(){
			if(!$('#selectPages:checked').prop('checked') != true)
			{
				$('.pages').show(1000);
			}
			else
			{
				$('.pages').hide(1500);
			}
		});
		$("#selectNote").click(function(){
			if(!$('#selectNote:checked').prop('checked') != true)
			{
				$('.note').show(1000);
			}
			else
			{
				$('.note').hide(1500);
			}
		});
		$("#selectAbstract").click(function(){
			if(!$('#selectAbstract:checked').prop('checked') != true)
			{
				$('.abstract').show(1000);
			}
			else
			{
				$('.abstract').hide(1500);
			}
		});
		$("#selectKeywords").click(function(){
			if(!$('#selectKeywords:checked').prop('checked') != true)
			{
				$('.keywords').show(1000);
			}
			else
			{
				$('.keywords').hide(1500);
			}
		});
		$("#selectSeries").click(function(){
			if(!$('#selectSeries:checked').prop('checked') != true)
			{
				$('.series').show(1000);
			}
			else
			{
				$('.series').hide(1500);
			}
		});
		$("#selectLocalite").click(function(){
			if(!$('#selectLocalite:checked').prop('checked') != true)
			{
				$('.localite').show(1000);
			}
			else
			{
				$('.localite').hide(1500);
			}
		});
		$("#selectPublisher").click(function(){
			if(!$('#selectPublisher:checked').prop('checked') != true)
			{
				$('.publisher').show(1000);
			}
			else
			{
				$('.publisher').hide(1500);
			}
		});
		$("#selectEditor").click(function(){
			if(!$('#selectEditor:checked').prop('checked') != true)
			{
				$('.editor').show(1000);
			}
			else
			{
				$('.editor').hide(1500);
			}
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
	
	});
</script>

<script type="text/javascript">


$(document).ready(function() { 
    $("#keywords").tablesorter({widthFixed: true, widgets:  ['zebra', 'filter']}); 
}); 
</script>



<script type="text/javascript">
	

$('#keywords').each(function() {
    var currentPage = 0;
    var numPerPage = 20;
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
    $pager.insertBefore($table).find('span.page-number:first').addClass('active');
});


</script>







