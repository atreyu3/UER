<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usorefaccion */

$this->title = Yii::t('app', 'Create Usorefaccion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usorefaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usorefaccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
