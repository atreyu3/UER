<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catfamilia */

$this->title = Yii::t('app', 'Create Catfamilia');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catfamilias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catfamilia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
