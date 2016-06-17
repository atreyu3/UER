<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ubicacionfisica */

$this->title = $model->id_ubicacionfisica;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ubicacionfisicas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubicacionfisica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_ubicacionfisica], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_ubicacionfisica], [
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
            'id_ubicacionfisica',
            'tbl_ubicacionfisica_nombre',
            'tbl_ubicacionfisica_planta',
        ],
    ]) ?>

</div>
