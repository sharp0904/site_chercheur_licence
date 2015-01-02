<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Publication */

$this->title = $model->ID;

?>
<div class="site-index">

    <h1><?= Html::encode('Détail de la rubrique : '.$this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'reference:ntext',
            'auteurs:ntext',
            'titre:ntext',
            'date',
            'journal:ntext',
            'volume:ntext',
            'number:ntext',
            'pages:ntext',
            'note:ntext',
            'abstract:ntext',
            'keywords:ntext',
            'series:ntext',
            'localite:ntext',
            'publisher:ntext',
            'editor:ntext',
            'pdf:ntext',
            'date_display:ntext',
            'categorie_id',
        ],
    ]) ?>
    

</div>
