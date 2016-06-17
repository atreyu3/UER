<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DevolucionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Devoluciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devoluciones-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Devoluciones'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#devoluciones-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'Devoluciones','url'=>['archivo/devoluciones']] ],
        'linkTemplate' => '<a href="{url}" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_devolucion',
            //'tbl_devolucion_tagid',
            'tbl_devolucion_date',
            	[	 
            		'label'=>'Usuario salida',
					'value'=>'modTransaccionrefaccionIdTransaccionrefaccion.tblUserIdUser.tbl_user_nombre', 
					'filterType'=>GridView::FILTER_SELECT2, 
					'attribute'=>'tbl_user_id_user',
					'filter'=>$model->tbluserList,	
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'group'=>true 
				],
				[	 
					'label'=>'item',
					'attribute'=>'tbl_item_id_item',
					'value'=>'tblItemIdItem.tbl_item_bim', 
					'filterType'=>GridView::FILTER_SELECT2, 
					'filter'=>$model->itemList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '], 
					'group'=>true 
				],
				[	 
					'label'=>'Descripción',
					'attribute'=>'tbl_item_nombre',
					'value'=>'tblItemIdItem.tbl_item_nombre', 
					'filterType'=>GridView::FILTER_SELECT2, 
					'filter'=>$model->itemList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '], 
					'group'=>true 
				],
				
				'sumacount',
				[ 
			   		'attribute'=>'mod_transaccionrefaccion_id_transaccionrefaccion', 
					'value'=>'modTransaccionrefaccionIdTransaccionrefaccion.mod_transaccionrefaccion_date', 
					'filter'=>Html::activeDropDownList($searchModel,'mod_transaccionrefaccion_id_transaccionrefaccion',$model->modtransaccionrefaccionList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_user_id_user', 
					'value'=>'tblUserIdUser.tbl_user_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_user_id_user',$model->tbluserList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#devoluciones-modal',
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
    </div>
<?php	Modal::begin([
			 'id'=>'devoluciones-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="devoluciones-modal-form"></div>
 <?php Modal::end(); ?>
</div>
