<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LineaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="linea-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_linea') ?>

    <?= $form->field($model, 'tbl_linea_nombre') ?>

    <?= $form->field($model, 'tbl_linea_siglas') ?>

    <?= $form->field($model, 'tbl_grupo_id_grupo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
