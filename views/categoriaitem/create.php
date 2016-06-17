<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categoriaitem */

$this->title = Yii::t('app', 'Create Categoriaitem');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriaitems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriaitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
