<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catfamilia */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Catfamilia',
]) . ' ' . $model->id_catfamilia;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catfamilias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_catfamilia, 'url' => ['view', 'id' => $model->id_catfamilia]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="catfamilia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
