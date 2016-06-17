<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ubicacionfisica */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ubicacionfisica',
]) . ' ' . $model->id_ubicacionfisica;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ubicacionfisicas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_ubicacionfisica, 'url' => ['view', 'id' => $model->id_ubicacionfisica]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ubicacionfisica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
