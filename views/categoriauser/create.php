<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categoriauser */

$this->title = Yii::t('app', 'Create Categoriauser');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriausers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriauser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
