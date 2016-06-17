<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

?>
<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_transaccionrefaccion',
	            [ 
			   		'attribute'=>'id_lineaprovisional', 
					'value'=>'tblMaquinaIdMaquina.tblLineaIdLinea.tbl_linea_nombre', 
					'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                	return [
                    'mergeColumns'=>[[0,3]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        0=>'Resumen (' . $model->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_nombre . ')',
                        4=>GridView::F_SUM,
                        6=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                        4=>['format'=>'number', 'decimals'=>0],
                        6=>['format'=>'number', 'decimals'=>2],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        0=>['style'=>'font-variant:small-caps'],
                        4=>['style'=>'text-align:right'],
                        6=>['style'=>'text-align:right'],
                    ],
                    'options'=>['class'=>'danger','style'=>'font-weight:bold;']
					];
					}
					
				],
	            [ 
					'label'=>'Total',
					'value'=>function ($model, $key, $index, $column) {
						$items=$model->tblItemIdItem;	
						$costo=0;
						foreach ($items as  $item) {
							$precios=$item->tblPrecios;
						foreach($precios as $precio){
							if($precio->tbl_precio_opcion==1){
								$costo=$costo+$precio->tbl_precio_precio;
							}
						}
						}
     			   		return $costo*$model->sumacount;
    					}, 
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
