<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<script src="<?php echo '/site_chercheur_licence-master/ckeditor/ckeditor.js'; ?>"></script>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($modelM, 'titre_fr')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($modelM, 'titre_en')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($modelM, 'actif')->textInput() ?>

    <?= $form->field($modelM, 'position')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($modelM->isNewRecord ? 'Create' : 'Update', ['class' => $modelM->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <script>     
                CKEDITOR.replace( 'rubrique-content_fr' );
                CKEDITOR.replace( 'rubrique-content_en' );
	</script>

</div>
