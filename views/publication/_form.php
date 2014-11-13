<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Publication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publication-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reference')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'auteurs')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'titre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

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

    <?= $form->field($model, 'pdf')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_display')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'categorie_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
