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
use app\models\MaquinaSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MaquinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Maquinas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maquina-index col-lg-12 col-md-12 col-xs-12 well">

   <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Maquina'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#maquina-modal']), 
        ]
        ])
        ?>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
     <?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'elCaptionText' => '#customMaquina',
        'uploadUrl' => Url::to(['/archivo/filecarga']),
    	]
		]);
		?>
	<span id="customMaquina" ><?=Yii::t('app','Carga de Equipos')?></span>
	</div>
	</div>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
            'tbl_maquina_bim',
            'tbl_maquina_modelo',
            'tbl_maquina_serie',
            'tbl_maquina_descripcion_bim',
            'tbl_maquina_descripcion',
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
				],
				[ 
			   		'attribute'=>'tbl_familia_id_familia', 
					'value'=>function ($model,$key,$index,$widget){
					return $model->tblFamiliaIdFamilia->tbl_familia_nombre;	
					},
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblfamiliaList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
				],
            'tbl_maquina_comentario',
            	[
            		'attribute'=>'tbl_maquina_activos',
            		'value'=>function ($model,$key,$index,$widget){
					return $model->tbl_maquina_activos==0 ? "Inactivo" : "Activo" ;	
					},
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>['0'=>'Inactivo','1'=>'Activo'], 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
					
            	],
				[ 
			   		'attribute'=>'tbl_status_id_status', 
					'value'=>function ($model,$key,$index,$widget){
					return $model->tblStatusIdStatus->tbl_status_nombre;	
					},
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblstatusList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
    				'format'=>'raw',
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_linea_id_linea', 
					'value'=>function($model,$key,$index,$widget){
						return isset($model->tblLineaIdLinea->tbl_linea_nombre) ? $model->tblLineaIdLinea->tbl_linea_nombre :'No tiene linea';
					},
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tbllineaList,
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				], 
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_ubicacionfisica_id_ubicacionfisica', 
					'value'=>function($model,$key,$index,$widget){
						return $model->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre;
					},
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblubicacionfisicaList, 
					'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				], 
					'group'=>true 
				],
            // 'tbl_centrodecostos_id_centrodecostos',
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
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
	<?php $maquinacount=new MaquinaSearch();?>
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
        		[
        		'content'=>Html::dropDownList('pagination', $maquinacount->getPerPage(), ['10' => '10 '.Yii::t('app', 'Registros'), '25' => '25 '.Yii::t('app', 'Registros'), '50' => '50 '.Yii::t('app', 'Registros'), '100' => '100 '.Yii::t('app', 'Registros')],['class'=>'form-control pagination','data-change'=> Url::toRoute('pagination')])
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
			 'id'=>'maquina-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="maquina-modal-form"></div>
 <?php Modal::end(); ?>
</div>
