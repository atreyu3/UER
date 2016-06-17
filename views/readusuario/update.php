<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Readusuario */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Readusuario',
]) . ' ' . $model->id_readusuario;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Readusuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_readusuario, 'url' => ['view', 'id' => $model->id_readusuario]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="readusuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
