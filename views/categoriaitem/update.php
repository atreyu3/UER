<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categoriaitem */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Categoriaitem',
]) . ' ' . $model->id_categoriaitem;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriaitems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categoriaitem, 'url' => ['view', 'id' => $model->id_categoriaitem]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categoriaitem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
