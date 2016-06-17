<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Centrodecostos */

$this->title = $model->id_centrodecostos;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Centrodecostos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centrodecostos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_centrodecostos], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_centrodecostos], [
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
            'id_centrodecostos',
            'tbl_centrodecostos_nombre',
            'tbl_centrodecostos_siglas',
        ],
    ]) ?>

</div>
