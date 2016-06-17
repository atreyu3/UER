<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Read */

$this->title = $model->id_read;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="read-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_read], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_read], [
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
            'id_read',
            'tbl_read_tagid',
            'tbl_read_antena',
            'tbl_read_timestamp',
            'tbl_read_rssi',
            'tbl_readusuario_id_readusuario',
        ],
    ]) ?>

</div>
