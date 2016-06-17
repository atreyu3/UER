<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Readusuario */

$this->title = Yii::t('app', 'Create Readusuario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Readusuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="readusuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
