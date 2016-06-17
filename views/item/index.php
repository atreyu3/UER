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
use app\models\ItemSearch;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index col-lg-12 col-md-12 col-xs-12 well">
	<div class="col-md-12 col-lg-12 col-xs-12" >
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-6 col-lg-4 col-xs-12">
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#item-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[//['label'=>Yii::t('app','Subir archivos'),'url'=>['archivo/upload']],
        ['label'=>Yii::t('app','Subir on hand y lista de precios'),'url'=>['#'],'template'=>'<a href="{url}"  data-toggle="modal" data-target="#upload-modal" ><span>{label}</span></a>']],
        'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#item-modal" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </div>
   <div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_item',
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
			[
					'attribute'=>'tbl_item_bim',
					'width'=>'100px',					
			],
			[
					'header'=>'Stock',
					'value'=>function($model){ $suma=0; if(isset($model->tblItemHasTblInventarios)){foreach($model->tblItemHasTblInventarios as $item){$suma=$suma+$item->tbl_item_has_tbl_inventario_cantidad;}} return $suma; },					
					'width'=>'45px',					
			],
			[
					'attribute'=>'tbl_item_almacen',
					'width'=>'45px',					
			],
			[
					'attribute'=>'tbl_item_noParte',
					'width'=>'45px',					
			],


			
			[
					'attribute'=>'tbl_item_nombre',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'width'=>'250px',
			],
            //'tbl_item_costo',
            //'tbl_item_precio',
			//[ 
			//  		'attribute'=>'tbl_familia_id_familia', 
			//		'value'=>'tblFamiliaIdFamilia.tbl_familia_nombre', 
			//		'filter'=>Html::activeDropDownList($searchModel,'tbl_familia_id_familia',$model->tblfamiliaList,['class'=>'form-control','prompt' => 'Select Category']), 
			//		'group'=>true 
			//	],
				// [ 
			   		// 'attribute'=>'tbl_categoriaitem_id_categoriaitem', 
					// 'value'=>'tblCategoriaItemIdCategoriaitem.tbl_categoriaitem_nombre', 
					// 'filter'=>Html::activeDropDownList($searchModel,'tbl_categoriaItem_id_categoriaitem',$model->tblcategoriaItemList,['class'=>'form-control','prompt' => 'Select Category']), 
					// 'group'=>true 
				// ],
				[ 
			   		'attribute'=>'tbl_marca_id_marca', 
			   		'vAlign'=>'middle',
			   		'width'=>'150px',
					'value'=>function ($model, $key, $index, $widget) { 
                	return $model->tblMarcaIdMarca->tbl_marca_nombre;
            		},
            		'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblmarcaList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
    				'format'=>'raw',
					'group'=>true 
				],
            'tbl_item_unidadmedida',
			[
					'attribute'=>'tbl_item_eprocurement',
					'width'=>'45px',					
			], 
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#item-modal',
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
        		],
        		//[
        		//'content'=>Html::dropDownList('pagination', ItemSearch::getPerPage(), ['10' => '10 '.Yii::t('app', 'Registros'), '25' => '25 '.Yii::t('app', 'Registros'), '50' => '50 '.Yii::t('app', 'Registros'), '100' => '100 '.Yii::t('app', 'Registros')],['class'=>'form-control pagination','data-change'=> Url::toRoute('pagination')])
        		//]
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
<?php	Modal::begin([
			 'id'=>'item-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="item-modal-form"></div>
 <?php Modal::end(); ?>
</div>
<?php	Modal::begin([
			 'id'=>'upload-modal',
			 'size'=>'modal-lg',
	]);
 ?>
 <div id="upload-modal">
 	
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Subir archivos</h3>
  </div>
  <div class="panel-body">
  	<div class="col-md-6 col-lg-6 col-xs-6 onhand well">
	<?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'elCaptionText' => '#customOnHand',
        'uploadUrl' => Url::to(['/archivo/fileonhand']),
    ]
	]);
	?>
	<span id="customOnHand" ><?=Yii::t('app','Subir onhand')?></span>
	<?= Html::a(Yii::t('app', 'Descarga Template on hand'), ['templateonhand'], ['class' => 'btn btn-raised btn-info']) ?>
	</div>
	<div class="col-md-6 col-lg-6 col-xs-6 listadeprecio well">
	<?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'uploadUrl' => Url::to(['/archivo/filelista']),
        'elCaptionText' => '#customlista'
    ]
	]);
	?>
	<span id="customlista" ><?=Yii::t('app','Subir lista')?></span>
	</div>
	</div>
 	</div>
 
 </div>
 <?php Modal::end(); ?>
</div>