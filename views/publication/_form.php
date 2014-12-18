<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categorie;
use app\models\Publication;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Publication */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="publication-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	

    <?= $form->field($model, 'reference')->textInput() ?>

    <?= $form->field($model, 'auteurs')->textInput() ?>

    <?= $form->field($model, 'titre')->textInput() ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-M-d'])->hiddenInput() ?>
        
    <div class="form-group field-publication-date">
    <label class="control-label"><?= 'Mois: ' ?></label>
    <select name="month" id="month">
		<?php for($cpt=1; $cpt<=12; $cpt++)
		{
			echo('<option value="'.$cpt.'">'.$cpt.'</option>');
		}
		?>
	</select>

    <label class="control-label"><?= 'Année: ' ?></label>
    <select name="year" id="year">
		<?php for($cpt=date('Y')-20; $cpt<=date('Y'); $cpt++)
		{
			echo('<option value="'.$cpt.'">'.$cpt.'</option>');
		}
		?>
		<option value="Autre">Autre...</option>
	</select>
	</div>


    <?= $form->field($model, 'journal')->textInput() ?>

    <?= $form->field($model, 'volume')->textInput() ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'pages')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keywords')->textInput() ?>

    <?= $form->field($model, 'series')->textInput() ?>

    <?= $form->field($model, 'localite')->textInput() ?>

    <?= $form->field($model, 'publisher')->textInput() ?>

    <?= $form->field($model, 'editor')->textInput() ?>

	<?= $form->field($model, 'pdf')->fileInput() ?>

    <?= $form->field($model, 'date_display')->textInput() ?>

    <?= Html::activeDropDownList($model, 'categorie_id', ArrayHelper::map(Categorie::find()->all(), 'ID','name_fr')); ?>

    <div class="form-group">
	</br></br>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(){
	$( "#publication-reference" ).attr( "required", "required" );
	$( "#publication-auteurs" ).attr( "required", "required" );
	$( "#publication-titre" ).attr( "required", "required" );
	$( "#publication-date" ).attr( "required", "required" );
	
	var str = $( "#publication-date" ).val();
	$("#year").val(str.substr(0, 4));
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
			for (var key in data = <?= json_encode(Publication::getLabels())?> )
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
			  for (var key in data = <?= json_encode(Publication::getLabels())?> )
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
			  for (var key in data = <?= json_encode(Publication::getLabels())?> )
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
			  for (var key in data = <?= json_encode(Publication::getLabels())?> )
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
			for (var key in data = <?= json_encode(Publication::getLabels())?> ){
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

</script>
