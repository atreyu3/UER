<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Linea */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Linea',
]) . ' ' . $model->id_linea;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lineas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_linea, 'url' => ['view', 'id' => $model->id_linea]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="linea-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
