<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Maquina */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Maquina',
]) . ' ' . $model->id_maquina;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maquinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_maquina, 'url' => ['view', 'id' => $model->id_maquina]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="maquina-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
