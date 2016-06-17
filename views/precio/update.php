<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Precio */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Precio',
]) . ' ' . $model->id_precios;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Precios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_precios, 'url' => ['view', 'id' => $model->id_precios]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="precio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
