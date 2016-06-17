<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Archivo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archivo-form">

    <?php $form = ActiveForm::begin([
   	'action'=>'create',
   	'id'=>$model->formName(),
    ]); ?>

    
    <?= $form->field($model, 'tbl_archivo_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_archivo_user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
