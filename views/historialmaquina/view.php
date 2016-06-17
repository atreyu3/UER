<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Historialmaquina */

$this->title = $model->id_historialmaquina;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Historialmaquinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historialmaquina-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_historialmaquina], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_historialmaquina], [
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
            'id_historialmaquina',
            'tbl_historialmaquina_antes',
            'tbl_historialmaquina_despues',
            'tbl_historialmaquina_cambio',
            'tbl_historialmaquina_date',
            'tbl_historialmaquina_usuario',
            'tbl_maquina_id_maquina',
        ],
    ]) ?>

</div>
