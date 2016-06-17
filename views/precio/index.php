<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PrecioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Precios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precio-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Precio'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#precio-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'Subir archivos','url'=>['archivo/upload']],['label'=>'item','url'=>['item/create']] ],
        'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#precio-modal" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_precios',
            'tbl_precio_precio',
            'tbl_precio_cambio',
				[ 
			   		'attribute'=>'tbl_item_id_item', 
					'value'=>'tblItemIdItem.tbl_item_bim', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_item_id_item',$model->tblitemList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_moneda_id_moneda', 
					'value'=>'tblMonedaIdMoneda.tbl_moneda_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_moneda_id_moneda',$model->tblmonedaList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_proveedor_id_proveedor', 
					'value'=>'tblProveedorIdProveedor.tbl_proveedor_numero', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_proveedor_id_proveedor',$model->tblproveedorList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
            'tbl_precio_unidadmedida',
            'tbl_precio_unidadcompra',
            'tbl_precio_opcion',
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#precio-modal',
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
			 'id'=>'precio-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="precio-modal-form"></div>
 <?php Modal::end(); ?>
</div>
