<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categoriatransaccion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Categoriatransaccion',
]) . ' ' . $model->id_categoriatransaccion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriatransaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categoriatransaccion, 'url' => ['view', 'id' => $model->id_categoriatransaccion]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categoriatransaccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
