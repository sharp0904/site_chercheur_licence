<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rubrique */

$this->title = 'Update Rubrique: ' . ' ' . $modelR->ID;

?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelR' => $modelR,
        'modelM' => $modelM,
    ]) ?>

</div>
