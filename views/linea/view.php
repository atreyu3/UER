<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Linea */

$this->title = $model->id_linea;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lineas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linea-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_linea], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_linea], [
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
            'id_linea',
            'tbl_linea_nombre',
            'tbl_linea_siglas',
            'tbl_grupo_id_grupo',
        ],
    ]) ?>

</div>
