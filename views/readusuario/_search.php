<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReadusuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="readusuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_readusuario') ?>

    <?= $form->field($model, 'tbl_readusuario_tagid') ?>

    <?= $form->field($model, 'tbl_readusuario_antena') ?>

    <?= $form->field($model, 'tbl_readusuario_timestamp') ?>

    <?= $form->field($model, 'tbl_readusuario_rssi') ?>

    <?php // echo $form->field($model, 'tbl_readusuario_activo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
