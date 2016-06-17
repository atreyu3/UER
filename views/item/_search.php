<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'tbl_item_bim') ?>

    <?= $form->field($model, 'tbl_item_stock') ?>

    <?= $form->field($model, 'tbl_item_almacen') ?>

    <?= $form->field($model, 'tbl_item_noParte') ?>

    <?php // echo $form->field($model, 'tbl_item_nombre') ?>

    <?php // echo $form->field($model, 'tbl_item_costo') ?>

    <?php // echo $form->field($model, 'tbl_item_precio') ?>

    <?php // echo $form->field($model, 'tbl_familia_id_familia') ?>

    <?php // echo $form->field($model, 'tbl_categoriaitem_id_categoriaitem') ?>

    <?php // echo $form->field($model, 'tbl_marca_id_marca') ?>

    <?php // echo $form->field($model, 'tbl_item_unidadmedida') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
