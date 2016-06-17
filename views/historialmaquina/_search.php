<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialmaquinaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historialmaquina-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_historialmaquina') ?>

    <?= $form->field($model, 'tbl_historialmaquina_antes') ?>

    <?= $form->field($model, 'tbl_historialmaquina_despues') ?>

    <?= $form->field($model, 'tbl_historialmaquina_cambio') ?>

    <?= $form->field($model, 'tbl_historialmaquina_date') ?>

    <?php // echo $form->field($model, 'tbl_historialmaquina_usuario') ?>

    <?php // echo $form->field($model, 'tbl_maquina_id_maquina') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
