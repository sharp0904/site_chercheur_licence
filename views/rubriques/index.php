
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Menu;
use app\models\Rubrique;
use app\librairies\FonctionsRubriques;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RubriquesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rubriques';
$cpt = 0;
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <?= Html::a('Create Rubrique', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div id="check">
		<?php foreach(Rubrique::getLabels() as $colonne)
				{
					$colonne = str_replace(" ", "", $colonne);
					if($colonne == "ContentFr")
					{
						echo("<span id='elmtCheck'>");
						echo("<input type='checkbox' id='select".$colonne."' checked=true>".$colonne);
						echo("</span>");
					}
					else if($colonne != "MenuID"&&$colonne != "Position"&& $colonne != "ID")
					{
						echo("<span id='elmtCheck'>");
						echo("<input type='checkbox' id='select".$colonne."'>".$colonne);
						echo("</span>");
					}
				}
		?>
		<?php foreach(Menu::getLabels() as $colonne)
				{
					$colonne = str_replace(" ", "", $colonne);
					if($colonne == "TitreFr")
					{
						echo("<span id='elmtCheck'>");
						echo("<input type='checkbox' id='select".$colonne."' checked=true>".$colonne);
						echo("</span>");
					}
					else if($colonne!="Actif" && $colonne!="Position" )
					{
						echo("<span id='elmtCheck'>");
						echo("<input type='checkbox' id='select".$colonne."'>".$colonne);
						echo("</span>");
					}
				}
		?>
		</div>
    </br></br>
    
    

      <?= Html::submitButton('Delete' , ['class' => 'btn btn-danger', 'id' => 'deleteMulti']) ?>
</br>
<?php
try{
	FonctionsRubriques::getTabRubriques();
}
catch(Exception $e)
{
	echo("Aucune rubriques");
}
?>



<script>

  $(document).ready(function(){
   
    

    $("#selectTitreFr").click(function(){
      if(!$('#selectTitreFr:checked').prop('checked') != true)
      {
        $('.titrefr').show(1000);
      }
      else
      {
        $('.titrefr').hide(1500);
      }
    });
    $("#selectTitreEn").click(function(){
      if(!$('#selectTitreEn:checked').prop('checked') != true)
      {
        $('.titreen').show(1000);
      }
      else
      {
        $('.titreen').hide(1500);
      }
    });
    $("#selectContentFr").click(function(){
      if(!$('#selectContentFr:checked').prop('checked') != true)
      {
        $('.contentfr').show(1000);
      }
      else
      {
        $('.contentfr').hide(1500);
      }
    });
     $("#selectContentEn").click(function(){
      if(!$('#selectContentEn:checked').prop('checked') != true)
      {
        $('.contenten').show(1000);
      }
      else
      {
        $('.contenten').hide(1500);
      }
    });
    $("#selectDateModification").click(function(){
      if(!$('#selectDateModification:checked').prop('checked') != true)
      {
        $('.dateModification').show(1000);
      }
      else
      {
        $('.dateModification').hide(1500);
      }
    });
    $("#selectDateCreation").click(function(){
      if(!$('#selectDateCreation:checked').prop('checked') != true)
      {
        $('.dateCreation').show(1000);
      }
      else
      {
        $('.dateCreation').hide(1500);
      }
    });




    //Désactive le bouton "Delete"
    $("#deleteMulti").attr("disabled","disabled");
    
    //Active le bouton "Delete" si une checkbox est coché, le desactive sinon
    $( 'input[type=checkbox]' ).click(function()
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
    
    
    
    //Lors du clic sur le bouton 'Delete', envoi l'id de la publication coché 
    $('#deleteMulti').click(function(){
      var valeurs = [];
      $('input:checked[name=selection]').each(function() {
        valeurs.push($(this).val());
      });
      var keys = valeurs;
      $.ajax("index.php?r=rubriques/deletemulti", {
         type: 'POST',
         data: {'keylist':keys},
         success: function()
         {
           window.location.replace("index.php?r=rubriques/index");
         },
         error: function()
         {
           $("#error").html("Une erreur est survenue! (Aucune Rubrique?)");
         }
      });
    });
    
    
  });
</script>

