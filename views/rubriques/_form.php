<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Menu;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Rubrique */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo '/site_chercheur_licence/ckeditor/ckeditor.js'; ?>"></script>

<div class="rubrique-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_creation')->hiddenInput(array('value'=>date('Y-m-d'))) ?>
	
	<?php  echo(date('Y-m-d')); echo"</br></br></br>";?>
	
    <?= Html::activeHiddenInput($model,'date_modification',$option = ['value' => date('Y-m-d')]) ?>
	
    <?= $form->field($model, 'content_fr')->textarea(['rows' => 6]) ?>
	
    <?= $form->field($model, 'content_en')->textarea(['rows' => 6]) ?>


	<?php 
// listName est le nom de la balise, 1 est le option selected et array on aura une focntion qui récupèrera la liste des clefs 
// etrangères et on les ajoutera a un tableau qu'on passera en paramètre
	echo Html::activeDropDownList($model, 'menu_id', ArrayHelper::map(Menu::find()->all(), 'id','titre_fr')); 
	?>
	</br></br>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<script>     
                CKEDITOR.replace( 'rubrique-content_fr' );
                CKEDITOR.replace( 'rubrique-content_en' );
</script>
</div>
