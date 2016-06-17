<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Archivo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Archivo',
]) . ' ' . $model->id_archivo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Archivos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_archivo, 'url' => ['view', 'id' => $model->id_archivo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="archivo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
