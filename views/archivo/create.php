<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Archivo */

$this->title = Yii::t('app', 'Create Archivo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Archivos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archivo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
