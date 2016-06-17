<?php

use yii\helpers\Html;

use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Impresion');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12 col-lg-12 col-xs-12">
	
      <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Directo'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#impresion-modal']), 
        ]
        ])
        ?>
    </p>

	<div class="col-md-6 col-xs-6 col-lg-6 well ">
	<?php $form = ActiveForm::begin([
   	'action'=>'impresionprovisional',
    ]); ?>
    <?= $form->errorSummary($model); ?>
	<?= $form->field($model, 'tbl_item_id_item')->widget( Select2::classname(),[
		'data' => $item,
		'size' => Select2::SMALL,
		'id'=> 'lin',
	   'options' => ['placeholder' => 'Selecciona item ...'],
			'pluginOptions' => [
				'allowClear' => true
			]
	])->label('Selecciona Item');?>
	<label for="cantidad" class="form-group" >Cantidad</label><input class="form-group" name="cantidad" required="true"></input> 
		<?= $form->field($model, 'tbl_inventario_id_inventario')->widget( Select2::classname(),[
		'data' => $inventario,
		'size' => Select2::SMALL,
		'id'=> 'invnventario',
	   'options' => ['placeholder' => 'Selecciona Inventario...'],
			'pluginOptions' => [
				'allowClear' => true
			],
	])->label('Selecciona Inventario'); ?>
		<input class="form-group" type="checkbox" name="inventario"></input>¿Actualizar Inventario?
		<div class="form-group">
        <?= Html::submitButton('Imprimir', ['class'=>'btn btn-submit']) ?>
	<?php ActiveForm::end(); ?>
		</div>
		</div>
		<!--<div class="col-lg-6 col-md-6 col-xs-6 well">
		</div>-->
		</div>
		<?php if(isset($port)):?>
	<?php print_r($port) ?>
	 <?php endif?>
<?php	Modal::begin([
			 'id'=>'impresion-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="compras-modal-form"></div>
 <?php Modal::end(); ?>