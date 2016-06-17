<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Familia */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Familia',
]) . ' ' . $model->id_familia;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Familias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_familia, 'url' => ['view', 'id' => $model->id_familia]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="familia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
