<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transaccionrefaccion */

$this->title = $model->id_transaccionrefaccion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaccionrefaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaccionrefaccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_transaccionrefaccion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_transaccionrefaccion], [
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
            'id_transaccionrefaccion',
            'mod_transaccionrefaccion_date',
            'mod_transaccionrefaccion_piezas',
            'tbl_maquina_id_maquina',
            'aux_usorefaccion_id_usorefaccion',
            'tbl_item_id_item',
            'tbl_user_id_user',
        ],
    ]) ?>

</div>
