<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Devoluciones */

$this->title = $model->id_devolucion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devoluciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devoluciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_devolucion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_devolucion], [
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
            'id_devolucion',
            'tbl_devolucion_tagid',
            'mod_transaccionrefaccion_id_transaccionrefaccion',
            'tbl_user_id_user',
            'tbl_devolucion_date',
        ],
    ]) ?>

</div>
