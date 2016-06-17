<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div> <?= Select2::widget([
		'name' => 'kv-state-220',
		'data' => $model,
		'size' => Select2::SMALL,
		'id'=> 'lin',
	   'options' => ['placeholder' => 'Selecciona ...', ],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);
		?> <input type="text"></input> 
		<div class="form-group">
        <?= Html::submitButton() ?>
		</div>
		</div>