<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Moneda */

$this->title = Yii::t('app', 'Create Moneda');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Monedas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moneda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
