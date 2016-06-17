<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Read */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Read',
]) . ' ' . $model->id_read;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_read, 'url' => ['view', 'id' => $model->id_read]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="read-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
