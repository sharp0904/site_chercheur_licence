<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rubrique */

$this->title = $model->ID;

if(!Yii::$app->user->isGuest):
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
		<?php echo($model->content_fr); ?>
</div>
<?php endif; ?>
