<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Historialmaquina */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Historialmaquina',
]) . ' ' . $model->id_historialmaquina;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Historialmaquinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_historialmaquina, 'url' => ['view', 'id' => $model->id_historialmaquina]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="historialmaquina-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
