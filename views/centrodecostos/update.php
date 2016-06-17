<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Centrodecostos */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Centrodecostos',
]) . ' ' . $model->id_centrodecostos;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Centrodecostos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_centrodecostos, 'url' => ['view', 'id' => $model->id_centrodecostos]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="centrodecostos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
