<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Familia */

$this->title = $model->id_familia;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Familias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="familia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_familia], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_familia], [
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
            'id_familia',
            'tbl_familia_nombre',
            'tbl_familia_siglas',
            'tbl_catfamilia_id_catfamilia',
        ],
    ]) ?>

</div>
