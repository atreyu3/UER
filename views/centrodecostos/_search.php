<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CentrodecostosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="centrodecostos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_centrodecostos') ?>

    <?= $form->field($model, 'tbl_centrodecostos_nombre') ?>

    <?= $form->field($model, 'tbl_centrodecostos_siglas') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
