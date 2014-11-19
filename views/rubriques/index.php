<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Menu;

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
			'content_fr:html' => array('label'=>'Contenu Fr',
			 
			 'value'=>function($data) {
                return (substr((strip_tags(html_entity_decode($data->content_fr))), 0, 50));
				//strip_tags: supprime toute les balises html
				//html_entity_decode: (necessaire pour certaines balises)
            }),
            'date_creation',
            'date_modification',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    

</div>
