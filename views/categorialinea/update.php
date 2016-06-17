<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categorialinea */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Categorialinea',
]) . ' ' . $model->id_categorialinea;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorialineas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categorialinea, 'url' => ['view', 'id' => $model->id_categorialinea]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categorialinea-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
