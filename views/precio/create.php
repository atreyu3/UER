<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Precio */

$this->title = Yii::t('app', 'Create Precio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Precios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
