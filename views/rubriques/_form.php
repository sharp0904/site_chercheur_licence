<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Menu;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Rubrique */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?php echo '/site-enseignant-chercheur/ckeditor/ckeditor.js'; ?>"></script>

<div class="rubrique-form">
		

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($modelM, 'titre_fr')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($modelM, 'titre_en')->textInput(['maxlength' => 20]) ?>
    
     <?= $form->field($modelR, 'content_fr')->textarea(['rows' => 6]) ?>
	
    <?= $form->field($modelR, 'content_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($modelM, 'actif')->textInput() ?>

    <?= $form->field($modelM, 'position')->textInput() ?>

    <?= $form->field($modelR, 'date_creation')->hiddenInput(array('value'=>date('Y-m-d'))) ?>
	
	<?php  echo(date('Y-m-d')); echo"</br></br>";?>
	
    <?= Html::activeHiddenInput($modelR,'date_modification',$option = ['value' => date('Y-m-d')]) ?>
    
    <?= Html::activeHiddenInput($modelR,'menu_id',$option = ['value' => '']); ?>


<!--// listName est le nom de la balise, 1 est le option selected et array on aura une focntion qui récupèrera la liste des clefs 
// etrangères et on les ajoutera a un tableau qu'on passera en paramètre
	//echo Html::activeDropDownList($model, 'menu_id', ArrayHelper::map(Menu::find()->all(), 'id','titre_fr')); -->

	</br></br>
	
    <div class="form-group">
        <?= Html::submitButton($modelR->isNewRecord ? 'Create' : 'Update', ['class' => $modelR->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<script>     
                CKEDITOR.replace( 'rubrique-content_fr' );
                CKEDITOR.replace( 'rubrique-content_en' );
</script>
</div>
