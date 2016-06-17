<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MaquinaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maquina-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_maquina') ?>

    <?= $form->field($model, 'tbl_maquina_bim') ?>

    <?= $form->field($model, 'tbl_maquina_codigo') ?>

    <?= $form->field($model, 'tbl_maquina_modelo') ?>

    <?= $form->field($model, 'tbl_maquina_serie') ?>

    <?php // echo $form->field($model, 'tbl_maquina_descripcion_bim') ?>

    <?php // echo $form->field($model, 'tbl_maquina_descripcion') ?>

    <?php // echo $form->field($model, 'tbl_marca_id_marca') ?>

    <?php // echo $form->field($model, 'tbl_familia_id_familia') ?>

    <?php // echo $form->field($model, 'tbl_maquina_comentario') ?>

    <?php // echo $form->field($model, 'tbl_maquina_activos') ?>

    <?php // echo $form->field($model, 'tbl_status_id_status') ?>

    <?php // echo $form->field($model, 'tbl_linea_id_linea') ?>

    <?php // echo $form->field($model, 'tbl_ubicacionfisica_id_ubicacionfisica') ?>

    <?php // echo $form->field($model, 'tbl_centrodecostos_id_centrodecostos') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
