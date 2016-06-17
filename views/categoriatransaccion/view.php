<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categoriatransaccion */

$this->title = $model->id_categoriatransaccion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoriatransaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriatransaccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_categoriatransaccion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_categoriatransaccion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_categoriatransaccion',
            'tbl_categoriatransaccion_nombre',
        ],
    ]) ?>

</div>
