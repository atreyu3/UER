<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'tbl_user_nombre') ?>

    <?= $form->field($model, 'tbl_user_apellidomaterno') ?>

    <?= $form->field($model, 'tbl_user_apellidopaterno') ?>

    <?= $form->field($model, 'tbl_user_username') ?>

    <?php // echo $form->field($model, 'tbl_user_password') ?>

    <?php // echo $form->field($model, 'tbl_user_auth_key') ?>

    <?php // echo $form->field($model, 'tbl_user_siglas') ?>

    <?php // echo $form->field($model, 'tbl_categoriauser_id_categoriauser') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
