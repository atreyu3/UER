<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaccionrefaccionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transaccionrefaccions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaccionrefaccion-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Transaccionrefaccion'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#transaccionrefaccion-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'louder salidas','url'=>['archivo/salidas'],['label'=>'louder devoluciones','url'=>['archivo/devoluciones'],'target'=>'_blank']]],'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_transaccionrefaccion',
	            [ 
			   		'attribute'=>'tbl_item_id_item', 
					'value'=>'tblItemIdItem.tbl_item_bim',
					'filterType'=>GridView::FILTER_SELECT2, 
					'filter'=>$model->tblitemList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '], 
				],
				[ 
			   		'attribute'=>'id_lineaprovisional', 
					'value'=>'tblMaquinaIdMaquina.tblLineaIdLinea.tbl_linea_nombre', 
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tbllineaList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
    			],
				[ 
			   		'attribute'=>'tbl_maquina_id_maquina', 
					'value'=>'tblMaquinaIdMaquina.tbl_maquina_bim', 
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblmaquinaList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'group'=>true 
				],
	            [ 
			   		'attribute'=>'mod_transaccionrefaccion_date', 
					'value'=>'mod_transaccionrefaccion_date', 
					'filter'=> kartik\daterange\DateRangePicker::widget([
       				'model' => $searchModel,
      				'attribute'=>'mod_transaccionrefaccion_date',
       			    'convertFormat'=>true,
        			'pluginOptions'=>[
            		'locale'=>[
                		'format'=>'Y-m-d',
                		'separator' => 'to',
            			]
        			]
    				]),
					
				],
            	'sumacount',
				[
			   		'attribute'=>'tbl_usorefaccion_id_usorefaccion',
					'value'=>'tblUsorefaccionIdUsorefaccion.tbl_usorefaccion_nombre',
					'filterType'=>GridView::FILTER_SELECT2, 
					'filter'=>$model->tblusorefaccionList2, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'group'=>true 
				],
				[
					'label'=>'Total',
					'value'=>function ($model, $key, $index, $column) {
						if(isset($model->tblItemIdItem->tblPrecios)){
                            $precios=$model->tblItemIdItem->tblPrecios;
						$costo=0;
						foreach($precios as $precio){
							if($precio->tbl_precio_opcion==1){
								$costo=$costo+$precio->tbl_precio_precio;
							}
						}
     			   		return $costo*$model->sumacount;
    					}else{
                            return "no tiene precio ";
                        }
                        },
				],
				[ 
			   		'attribute'=>'tbl_user_id_user', 
					'value'=>'tblUserIdUser.tbl_user_nombre',
					'filterType'=>GridView::FILTER_SELECT2, 
					'filter'=>$model->tbluserList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'group'=>true 
				],
				[
					'label'=>'Jefe de mecanico',
					//'attribute'=>'tbl_user_id_user', 
					'value'=>function($model){if($model->tblUserIdUser->checkjefe!=null) return $model->tblUserIdUser->checkjefe; else "no asignado";},
					'filterType'=>GridView::FILTER_SELECT2, 
					'filter'=>$model->tbluserList,
					'filterInputOptions'=>['placeholder' => 'Selecciona '], 
					'group'=>true 
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
    </div>
<?php	Modal::begin([
			 'id'=>'transaccionrefaccion-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="transaccionrefaccion-modal-form"></div>
 <?php Modal::end(); ?>
</div>
