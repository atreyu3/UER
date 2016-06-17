<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Compras */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Compras',
]) . ' ' . $model->id_compras;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_compras, 'url' => ['view', 'id' => $model->id_compras]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="compras-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
