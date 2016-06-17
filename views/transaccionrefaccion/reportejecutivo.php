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
	
 <div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_transaccionrefaccion',
	            [ 
			   		'attribute'=>'id_lineaprovisional', 
					'value'=>'tblMaquinaIdMaquina.tblLineaIdLinea.tbl_linea_nombre', 
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tbllineaList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
					'group'=>true,
					'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                	return [
                    'mergeColumns'=>[[0,2]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        0=>'Resumen (' . $model->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_nombre . ')',
                        2=>GridView::F_SUM,
                        3=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                       2=>['format'=>'number', 'decimals'=>0],
                       3=>['format'=>'number', 'decimals'=>2],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        0=>['style'=>'font-variant:small-caps'],
                        2=>['style'=>'text-align:right'],
                        3=>['style'=>'text-align:right'],
                    ],
                    'options'=>['class'=>'danger','style'=>'font-weight:bold;']
					];
					}
					
				],
	            [ 
			   		'attribute'=>'tbl_maquina_id_maquina', 
					'value'=>'tblMaquinaIdMaquina.tbl_maquina_bim', 
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblmaquinaList,
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'group'=>true, 
					'subGroupOf'=>1, 
					'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                	return [
                    'mergeColumns'=>[[3]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        2=>'Resumen (' . $model->tblMaquinaIdMaquina->tbl_maquina_bim . ')',
                        3=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                        3=>['format'=>'number', 'decimals'=>0],
                        4=>['format'=>'number', 'decimals'=>2],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        2=>['style'=>'font-variant:small-caps'],
                        3=>['style'=>'text-align:right'],
                        
                    ],
                    'options'=>['class'=>'success','style'=>'font-weight:bold;']
					];
					},
				],
				[ 
					'label'=>'Total',
					'value'=>function ($model, $key, $index, $column) {
						$precios=$model->tblItemIdItem->tblPrecios;	
						$costo=0;
						foreach($precios as $precio){
							if($precio->tbl_precio_opcion==1){
								$costo=$costo+$precio->tbl_precio_precio;
							}
						}
     			   		return $costo*$model->sumacount;
    					}, 
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
					'format' => ['date', 'php:Y-m-d'],
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
        		'content'=>Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['reporte'], ['class' => 'btn btn-default', 'title'=> 'Reset Grid'])
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
