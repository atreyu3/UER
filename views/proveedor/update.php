<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Proveedor */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Proveedor',
]) . ' ' . $model->id_proveedor;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Proveedors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_proveedor, 'url' => ['view', 'id' => $model->id_proveedor]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="proveedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
