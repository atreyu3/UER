<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Maquina */

$this->title = $model->id_maquina;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maquinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maquina-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_maquina], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_maquina], [
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
            'id_maquina',
            'tbl_maquina_bim',
            'tbl_maquina_codigo',
            'tbl_maquina_modelo',
            'tbl_maquina_serie',
            'tbl_maquina_descripcion_bim',
            'tbl_maquina_descripcion:ntext',
            'tbl_marca_id_marca',
            'tbl_familia_id_familia',
            'tbl_maquina_comentario',
            'tbl_maquina_activos',
            'tbl_status_id_status',
            'tbl_linea_id_linea',
            'tbl_ubicacionfisica_id_ubicacionfisica',
            'tbl_centrodecostos_id_centrodecostos',
        ],
    ]) ?>

</div>
