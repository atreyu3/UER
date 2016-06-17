<?php

use yii\helpers\Html;

use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Impresion Provisional');
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
	<div class="col-md-12 col-lg-12 col-xs-12 well">
		<p>Nombre de la maquina: <?= gethostname();?></p>
		<p>Direccion de Impresora: <?= $impresora ?></p>
	<?php $form = ActiveForm::begin([
   	'action'=>'impresora',
    ]); ?>
	 <input name="nombre_impresora"></input> 
	<div class="form-group">
        <?= Html::submitButton('Registrar Impresora',['class'=>'btn btn-submit pull-left']) ?>
	<?php ActiveForm::end(); ?>
	</div>
	</div>
</div>