<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PublicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publication-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'reference') ?>

    <?= $form->field($model, 'auteurs') ?>

    <?= $form->field($model, 'titre') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'journal') ?>

    <?php // echo $form->field($model, 'volume') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'pages') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'abstract') ?>

    <?php // echo $form->field($model, 'keywords') ?>

    <?php // echo $form->field($model, 'series') ?>

    <?php // echo $form->field($model, 'localite') ?>

    <?php // echo $form->field($model, 'publisher') ?>

    <?php // echo $form->field($model, 'editor') ?>

    <?php // echo $form->field($model, 'pdf') ?>

    <?php // echo $form->field($model, 'date_display') ?>

    <?php // echo $form->field($model, 'categorie_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
