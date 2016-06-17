<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categoriauser */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Categoriauser',
]) . ' ' . $model->id_categoriauser;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriausers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categoriauser, 'url' => ['view', 'id' => $model->id_categoriauser]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categoriauser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
