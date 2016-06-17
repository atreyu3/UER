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
/* @var $searchModel app\models\ComprasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Compras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compras-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Compras'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#compras-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_compras',
	        [
					'class'=>'kartik\grid\ExpandRowColumn',
					'width'=>'50px',
  					'value'=>function ($model, $key, $index, $column) {
        				return GridView::ROW_COLLAPSED;
    					},
   					'detail'=>function ($model, $key, $index, $column) {
     			   		return Yii::$app->controller->renderPartial('_detalles', ['model'=>$model]);
    					},
   					'headerOptions'=>['class'=>'kartik-sheet-style'], 
    				'expandOneOnly'=>true,
			],
            'tbl_compras_entrega',
				[ 
			   		'attribute'=>'tbl_proveedor_id_proveedor', 
			   		'vAlign'=>'middle',
			   		'width'=>'150px',
					'value'=>function ($model, $key, $index, $widget) { 
                	return $model->tblProveedorIdProveedor->tbl_proveedor_nombre;
            		},
            		'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblproveedorList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
    				'format'=>'raw',
					'group'=>true 
				],
            'tbl_compras_fechapedido',
            'tbl_compras_fechaentrega',
            'tbl_compras_factura',
				[ 
			   		'attribute'=>'tbl_user_id_user', 
					'value'=>'tblUserIdUser.tbl_user_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_user_id_user',$model->tbluserList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
            [
            'attribute'=>'tbl_compras_impresion',
            'value'=>function($model){
            	 return $model->tbl_compras_impresion==1 ? Yii::t('app','Impreso') : Html::a(Yii::t('app','¿Imprimir?'),Url::to(['compras/impresion', 'id' => $model->id_compras]), [ 'data-toggle'=>'modal','data-target'=>'#compras-modal','title' =>  Yii::t('app','¿Imprimir?'), 'class'=>' opcion btn btn-primary btn-xs']);	 
			},
			'format'=>'raw',
            ],
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#compras-modal',
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
        'columns' =>$datagrid,
        'responsive'=>true,
        'panel'=>[
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>'.Html::encode($this->title).'</h3>',
        ],
        'toolbar'=>[
        		'{export}',[
        		'content'=>Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['#'], ['class' => 'btn btn-default', 'title'=> 'Reset Grid'])
        		]
        ],
        'export'=>[
        	'itemsAfter'=> [
            '<li role="presentation" class="divider"></li>',
            '<li class="dropdown-header">All Data</li>',
            $exportvar
        	]
        ]	  
    ]); ?>
    <?php Pjax::end(); ?>
    </div>
<?php	Modal::begin([
			 'id'=>'compras-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="compras-modal-form"></div>
 <?php Modal::end(); ?>
</div>
<?php	Modal::begin([
			 'id'=>'upload-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="upload-modal">
 	<div class="col-md-4 col-lg-4 col-xs-4 onhand">
	<?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'elCaptionText' => '#customOnHand',
        'uploadUrl' => Url::to(['/archivo/filertr']),
    ]
	]);
	?>
	<span id="" ><?=Yii::t('app','Subir rtr')?></span>
	</div>
	</div>
 	
 </div>
 <?php Modal::end(); ?>
</div>