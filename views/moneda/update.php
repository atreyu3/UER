<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Moneda */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Moneda',
]) . ' ' . $model->id_moneda;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Monedas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_moneda, 'url' => ['view', 'id' => $model->id_moneda]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="moneda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
