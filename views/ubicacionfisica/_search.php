<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UbicacionfisicaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ubicacionfisica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ubicacionfisica') ?>

    <?= $form->field($model, 'tbl_ubicacionfisica_nombre') ?>

    <?= $form->field($model, 'tbl_ubicacionfisica_planta') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
