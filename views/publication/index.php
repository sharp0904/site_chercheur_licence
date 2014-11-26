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
<script type="text/javascript" src="/site-enseignant-chercheur/vendor/bower/jquery/dist/jquery.js"></script>
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
        
    </p>
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
        ],
    ]); ?>



</div>
<script>
	$(document).ready(function(){
		$("#selecBib").click(function(){
			if ($('#validerUpBib').css('visibility') == 'hidden')
			{
				$('.fileInput').css('visibility', 'visible');
				$('#validerUpBib').css('visibility', 'visible');
			}
			else
			{
				$('.fileInput').css('visibility', 'hidden');
				$('#validerUpBib').css('visibility', 'hidden');
			}
		});
	});
</script>
