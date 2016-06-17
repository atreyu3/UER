<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Inventario */

$this->title = Yii::t('app', 'Create Inventario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
