<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Grupo */
/* @var $form yii\widgets\ActiveForm */
?>
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
	
	<?php $form = ActiveForm::begin([
   	'action'=>'asignar',
   	
    ]); ?>
	<?= Select2::widget([
		'name' => 'kv-state-220',
		'data' => $model,
		'size' => Select2::SMALL,
		'id'=> 'lin',
	   'options' => ['placeholder' => 'Selecciona ...', ],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);?> <input name="cantidad"></input> 
		<?= Select2::widget([
		'name' => 'inven',
		'data' => $inventario,
		'size' => Select2::SMALL,
		'id'=> 'invnventario',
	   'options' => ['placeholder' => 'Selecciona ...', ],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);?>		
		<div class="form-group">
        <?= Html::submitButton() ?>
	<?php ActiveForm::end(); ?>
		</div>
		</div>
		<?php if(isset($port)):?>
	<?php print_r($port) ?>
	 <?php endif?>