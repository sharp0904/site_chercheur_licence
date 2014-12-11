<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categorie;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Publication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publication-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	

    <?= $form->field($model, 'reference')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'auteurs')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'titre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->widget(yii\jui\DatePicker::className(), ['dateFormat' => 'yyyy-M-d']) ?>

    <?= $form->field($model, 'journal')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'volume')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'number')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pages')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'series')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'localite')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'publisher')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'editor')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'pdf')->fileInput() ?>

    <?= $form->field($model, 'date_display')->textarea(['rows' => 6]) ?>

    <?= Html::activeDropDownList($model, 'categorie_id', ArrayHelper::map(Categorie::find()->all(), 'ID','name_fr')); ?>

    <div class="form-group">
	</br></br>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
