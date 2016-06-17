<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parcialidades */

$this->title = Yii::t('app', 'Create Parcialidades');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parcialidades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcialidades-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
