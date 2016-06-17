<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RequisicionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requisiciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_requisiciones') ?>

    <?= $form->field($model, 'tbl_requisiciones_cantidad') ?>

    <?= $form->field($model, 'tbl_requisiciones_status') ?>

    <?= $form->field($model, 'tbl_user_id_user') ?>

    <?= $form->field($model, 'tbl_requisiciones_nombre') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
