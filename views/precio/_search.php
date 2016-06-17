<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PrecioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="precio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_precios') ?>

    <?= $form->field($model, 'tbl_precio_precio') ?>

    <?= $form->field($model, 'tbl_precio_cambio') ?>

    <?= $form->field($model, 'tbl_item_id_item') ?>

    <?= $form->field($model, 'tbl_moneda_id_moneda') ?>

    <?php // echo $form->field($model, 'tbl_proveedor_id_proveedor') ?>

    <?php // echo $form->field($model, 'tbl_precio_unidadmedida') ?>

    <?php // echo $form->field($model, 'tbl_precio_unidadcompra') ?>

    <?php // echo $form->field($model, 'tbl_precio_opcion') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
