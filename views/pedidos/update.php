<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pedidos */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Pedidos',
]) . ' ' . $model->id_pedidos;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pedidos, 'url' => ['view', 'id' => $model->id_pedidos]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pedidos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
