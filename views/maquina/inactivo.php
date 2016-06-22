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



/* @var $this yii\web\View */
/* @var $searchModel app\models\MaquinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Consulta Maquinas Inactivas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="maquina-index col-lg-12 col-md-12 col-xs-12 well">

   <h1><?= Html::encode($this->title)?></h1>

   <div class="col-md-12 col-lg-12 col-xs-12 well">
        <?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
            'tbl_maquina_bim',
            'tbl_maquina_modelo',
            'tbl_maquina_serie',
            'tbl_maquina_descripcion_bim',
            'tbl_maquina_descripcion',
            // 'tbl_centrodecostos_id_centrodecostos',
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}',
		'buttons'=>[
		  'UpdateStatus'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#maquina-modal',
                                        'data-toggle'=>'modal'
				]);
		  	}
		  ]		
		],
	]; 
	$exportvar=ExportMenu::widget([
    	'dataProvider' => $dataProvider,
    	'columns' =>$datagrid,
    	'target' => ExportMenu::TARGET_BLANK,
    	'asDropdown' => false, 
    ]);
	?>
	 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' =>         $datagrid,
        'responsive'=>true,
        'panel'=>[
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>'.Html::encode($this->title).'</h3>',
        ],
        'toolbar'=>[
        		'{export}',[
        		'content'=>Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['#'], ['class' => 'btn btn-default', 'title'=> 'Reset Grid'])
        		],
        ],
        'export'=>[
        	'itemsAfter'=> [
            '<li role="presentation" class="divider"></li>',
            '<li class="dropdown-header">All Data</li>',
            $exportvar
        	]
        ]	  
    ]); ?>
   </div>
</div>