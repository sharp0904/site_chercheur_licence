<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Publication */

$this->title = 'Update Publication: ' . ' ' . $model->ID;

?>
<div class="publication-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?= Html::encode($model->pdf) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
