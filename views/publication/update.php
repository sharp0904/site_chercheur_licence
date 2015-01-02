<?php

use yii\helpers\Html;
use app\models\Publication;

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
<script type="text/javascript">
	// data correspond aux attributs de publications. Utiles dans web/js/publication-index.js
	var data =<?php echo(json_encode(Publication::attributeLabels()));?>;
</script>
<script type="text/javascript" src="js/update-publi.js"></script>
