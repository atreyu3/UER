<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaccionrefaccion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Transaccionrefaccion',
]) . ' ' . $model->id_transaccionrefaccion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaccionrefaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_transaccionrefaccion, 'url' => ['view', 'id' => $model->id_transaccionrefaccion]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="transaccionrefaccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
