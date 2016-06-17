<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Precio */

$this->title = $model->id_precios;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Precios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_precios], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_precios], [
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
            'id_precios',
            'tbl_precio_precio',
            'tbl_precio_cambio',
            'tbl_item_id_item',
            'tbl_moneda_id_moneda',
            'tbl_proveedor_id_proveedor',
            'tbl_precio_unidadmedida',
            'tbl_precio_unidadcompra',
            'tbl_precio_opcion',
        ],
    ]) ?>

</div>
