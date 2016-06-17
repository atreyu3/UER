<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categoriatransaccion */

$this->title = Yii::t('app', 'Create Categoriatransaccion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriatransaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriatransaccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
