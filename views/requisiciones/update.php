<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Requisiciones */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Requisiciones',
]) . ' ' . $model->id_requisiciones;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requisiciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_requisiciones, 'url' => ['view', 'id' => $model->id_requisiciones]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="requisiciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
