<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usorefaccion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Usorefaccion',
]) . ' ' . $model->id_usorefaccion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usorefaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_usorefaccion, 'url' => ['view', 'id' => $model->id_usorefaccion]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="usorefaccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
