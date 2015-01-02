<?php

use yii\helpers\Html;
use app\models\Publication;


/* @var $this yii\web\View */
/* @var $model app\models\Publication */

$this->title = 'Create Publication';

?>
<div class="publication-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<script type="text/javascript">
	// data correspond aux attributs de publications. Utiles dans web/js/publication-index.js
	var data =<?php echo(json_encode(Publication::getLabels()));?>;
</script>
<script type="text/javascript" src="js/create-publi.js"></script>
