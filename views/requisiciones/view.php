<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisiciones */

$this->title = $model->id_requisiciones;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requisiciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisiciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_requisiciones], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_requisiciones], [
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
            'id_requisiciones',
            'tbl_requisiciones_cantidad',
            'tbl_requisiciones_status',
            'tbl_user_id_user',
            'tbl_requisiciones_nombre',
        ],
    ]) ?>

</div>
