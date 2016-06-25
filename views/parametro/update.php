<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parametro */

$this->title = 'Update Parametro: ' . ' ' . $model->CVE_PARAMETRO;
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CVE_PARAMETRO, 'url' => ['view', 'id' => $model->CVE_PARAMETRO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parametro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
