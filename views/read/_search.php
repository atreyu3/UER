<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="read-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_read') ?>

    <?= $form->field($model, 'tbl_read_tagid') ?>

    <?= $form->field($model, 'tbl_read_antena') ?>

    <?= $form->field($model, 'tbl_read_timestamp') ?>

    <?= $form->field($model, 'tbl_read_rssi') ?>

    <?php // echo $form->field($model, 'tbl_readusuario_id_readusuario') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
