<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rubrique */

$this->title = 'Update Rubrique: ' . ' ' . $modelR->id;
$this->params['breadcrumbs'][] = ['label' => 'Rubriques', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelR->id, 'url' => ['view', 'id' => $modelR->id]];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rubrique-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelR' => $modelR,
        'modelM' => $modelM,

    ]) ?>

</div>
