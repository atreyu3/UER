<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categorialinea */

$this->title = Yii::t('app', 'Create Categorialinea');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorialineas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorialinea-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
