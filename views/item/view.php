<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = $model->id_item;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_item], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_item], [
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
            'id_item',
            'tbl_item_bim',
            'tbl_item_stock',
            'tbl_item_almacen',
            'tbl_item_noParte',
            'tbl_item_nombre:ntext',
            'tbl_item_costo',
            'tbl_item_precio',
            'tbl_familia_id_familia',
            'tbl_categoriaitem_id_categoriaitem',
            'tbl_marca_id_marca',
            'tbl_item_unidadmedida',
        ],
    ]) ?>

</div>
