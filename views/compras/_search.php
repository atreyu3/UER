<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComprasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compras-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_compras') ?>

    <?= $form->field($model, 'tbl_compras_entrega') ?>

    <?= $form->field($model, 'tbl_proveedor_id_proveedor') ?>

    <?= $form->field($model, 'tbl_compras_fechapedido') ?>

    <?= $form->field($model, 'tbl_compras_fechaentrega') ?>

    <?php // echo $form->field($model, 'tbl_compras_factura') ?>

    <?php // echo $form->field($model, 'tbl_user_id_user') ?>

    <?php // echo $form->field($model, 'tbl_compras_impresion') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
