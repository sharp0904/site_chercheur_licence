<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\ckeditor\ckeditor;


/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'titre_fr')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'titre_en')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'actif')->textInput() ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
