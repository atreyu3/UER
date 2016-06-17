<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ubicacionfisica */

$this->title = Yii::t('app', 'Create Ubicacionfisica');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ubicacionfisicas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubicacionfisica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
