<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Historialmaquina */

$this->title = Yii::t('app', 'Create Historialmaquina');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Historialmaquinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historialmaquina-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
