<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Marca */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Marca',
]) . ' ' . $model->id_marca;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Marcas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_marca, 'url' => ['view', 'id' => $model->id_marca]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="marca-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
