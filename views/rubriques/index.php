<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RubriquesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rubriques';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rubrique-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
         <?= Html::a('Create Rubrique', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_creation',
            'date_modification',
            'content_fr:ntext',
            'content_en:ntext',
            'menu_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
