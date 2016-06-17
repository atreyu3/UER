<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Maquina */

$this->title = Yii::t('app', 'Create Maquina');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maquinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maquina-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
