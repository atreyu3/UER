<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parcialidades */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Parcialidades',
]) . ' ' . $model->id_parcialidades;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parcialidades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_parcialidades, 'url' => ['view', 'id' => $model->id_parcialidades]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="parcialidades-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
