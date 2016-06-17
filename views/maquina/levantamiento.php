<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MaquinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Maquinas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maquina-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Maquina'), ['maquina/create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#maquina-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'Subir archivos','url'=>['archivo/upload']],['label'=>'item','url'=>['item/create']] ],
        'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#maquina-modal" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_maquina',
            'tbl_maquina_bim',
            'tbl_maquina_modelo',
            'tbl_maquina_serie',
            //'tbl_maquina_hp',
            //'tbl_maquina_dimensiones',
            'tbl_maquina_descripcion:ntext',
				[ 
			   		'attribute'=>'tbl_marca_id_marca', 
					'value'=>'tblMarcaIdMarca.tbl_marca_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_marca_id_marca',$model->tblmarcaList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_familia_id_familia', 
					'value'=>'tblFamiliaIdFamilia.tbl_familia_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_familia_id_familia',$model->tblfamiliaList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
            'tbl_maquina_estatus',
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
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $datagrid,
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
			 'id'=>'maquina-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="maquina-modal-form"></div>
 <?php Modal::end(); ?>
</div>
