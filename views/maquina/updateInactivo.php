<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Maquina */

$this->title = Yii::t('app', 'UpdateStatus {modelClass}: ', [
    'modelClass' => 'Maquina',
]) . ' ' . $model->id_maquina;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maquinas'), 'url' => ['inactivo']];
$this->params['breadcrumbs'][] = ['label' => $model->id_maquina, 'url' => ['view', 'tbl_status_id_status = 1', 'id' => $model->id_maquina]];
$this->params['breadcrumbs'][] = Yii::t('app', 'UpdateStatus');
?>
<div class="maquina-updatestatus">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
