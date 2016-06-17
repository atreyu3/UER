<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DevolucionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devoluciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_devolucion') ?>

    <?= $form->field($model, 'tbl_devolucion_tagid') ?>

    <?= $form->field($model, 'mod_transaccionrefaccion_id_transaccionrefaccion') ?>

    <?= $form->field($model, 'tbl_user_id_user') ?>

    <?= $form->field($model, 'tbl_devolucion_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
