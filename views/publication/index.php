<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\librairies\FonctionsPublications;
use app\models\Publication;
use app\controllers\PublicationController;
use yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publications';
$cpt = 0;
?>

<script type="text/javascript" src="../vendor/bower/jquery/dist/jquery.js"></script>

<div class="site-index">

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
		<?php foreach(Publication::getLabels() as $colonne)
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

</div>
<script type="text/javascript">
	// data correspond aux attributs de publications. Utiles dans web/js/publication-index.js
	var data =<?php echo(json_encode(Publication::getLabels()));?>;
</script>



