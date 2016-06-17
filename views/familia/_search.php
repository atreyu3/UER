<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FamiliaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="familia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_familia') ?>

    <?= $form->field($model, 'tbl_familia_nombre') ?>

    <?= $form->field($model, 'tbl_familia_siglas') ?>

    <?= $form->field($model, 'tbl_catfamilia_id_catfamilia') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
