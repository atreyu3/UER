<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Transaccionrefaccion */

$this->title = Yii::t('app', 'Create Transaccionrefaccion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaccionrefaccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaccionrefaccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formdirecto', [
        'model' => $model,
    ]) ?>

</div>
