<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publications';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="../vendor/bower/jquery/dist/jquery.js"></script>
<div class="publication-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
    <p>
        <?= Html::a('Create Publication', ['create'], ['class' => 'btn btn-success']) ?>
        
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div>
			<?= Html::Button('Create Publication via bibtex' , ['class' => 'btn btn-success', 'id' => 'selecBib']) ?>
		</div>
        <div class="fileInput"><?= $form->field($model, 'Bibtex')->fileInput() ?>
			<?= Html::submitButton('Valider' , ['class' => 'btn btn-primary', 'id' => 'validerUpBib']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        
			<?= Html::submitButton('Delete' , ['class' => 'btn btn-delete', 'id' => 'deleteMulti']) ?>
			
    </p>
    
    <div id="error"></div>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'reference:ntext',
            'auteurs:ntext',
            'titre:ntext',
            'date',
            // 'journal:ntext',
            // 'volume:ntext',
            // 'number:ntext',
            // 'pages:ntext',
            // 'note:ntext',
            // 'abstract:ntext',
            // 'keywords:ntext',
            // 'series:ntext',
            // 'localite:ntext',
            // 'publisher:ntext',
            // 'editor:ntext',
            // 'pdf:ntext',
            // 'date_display:ntext',
            // 'categorie_id',

            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]); ?>

</div>
<script>
	$(document).ready(function(){
		//Cache le formulaire d'upload de BibTeX
		$('.fileInput').hide();
		
		//Lors du clic sur #selecBib, fais apparaître ou disparaître le formaulaire d'upload de BibTeX
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
		
		//Désactive le bouton "Delete"
		$("#deleteMulti").attr("disabled","disabled");
		
		//Active le bouton "Delete" si une checkbox est coché, le desactive sinon
		$( 'input[type=checkbox]' ).click(function()
		{
			if($('input[type=checkbox]:checked').prop('checked') != true)
			{
				$("#deleteMulti").attr("disabled","disabled");
			}
			else
			{
				$("#deleteMulti").attr("disabled",false);
			}
			
		});
		
		//Désactive le bouton "Delete" si la checkbox "principale" est décoché
		$( '.select-on-check-all' ).click(function()
		{
			if($('.select-on-check-all').prop('checked') != true )
			{
				$("#deleteMulti").attr("disabled","disabled");
			}
		});
		
		//Lors du clic sur le bouton 'Delete', envoi l'id de la publication coché 
		$('#deleteMulti').click(function(){
			var keys = $('#w1').yiiGridView('getSelectedRows');
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
		
		/*$('th').mousedown(function(event) {
			switch (event.which) {
				case 3:
					alert('Right Mouse button pressed.');
					break;
			}
		});*/
	});
</script>
