<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LineaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lineas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linea-index col-lg-12 col-md-12 col-xs-12 well">
<div class="col-md-3 col-xs-12 ">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Linea'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#linea-modal']),        ]
        ]);
        ?>
    </p>
    </div>
	<?php $form = ActiveForm::begin([
   	'action'=>'asignar',
    ]); ?>
   <div class="col-md-3 col-xs-6">
   <p  class="text-info"> Linea: </p>
	<?= Select2::widget([
		'name' => 'linea',
		'data' => $model->tblLineaList,
		'size' => Select2::SMALL,
		'id'=> 'lin',
	   'options' => ['placeholder' => 'Selecciona ...', ],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);?>
	</div>
	<div class="col-md-3 col-xs-6">
	<p  class="text-info">Grupo: </p>
		<?= Select2::widget([
		'name' => 'grupo',
		'data' => $model->tblGrupoList,
		'size' => Select2::SMALL,
		'id'=> 'invnventario',
	   'options' => ['placeholder' => 'Selecciona ...', ],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);?>		
	<div clas="col-md-3 col-xs-6" >
		<?= Html::submitButton('Agregar', ['class' => 'btn btn-primary pull-left']) ?>
	</div>	
	<?php ActiveForm::end(); ?>	
	</div>
<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_linea',
            'tbl_linea_nombre',
            'tbl_linea_siglas',
				[ 
			   		'attribute'=>'tbl_grupo_id_grupo', 
					'value'=>'tblGrupoIdGrupo.tbl_grupo_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_grupo_id_grupo',$model->tblgrupoList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#linea-modal',
                                        'data-toggle'=>'modal'
				]);
		  	},
		  'delete'=>function($url,$model){
		  	return $model->tblMaquinas==null ? Html::a('<span class="glyphicon glyphicon-trash "></span>', $url, [
                                        'title' => Yii::t('app', 'Delete Item'),
				]): "".Yii::t('app', 'Accion no permitida')."";
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
			 'id'=>'linea-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="linea-modal-form"></div>
 <?php Modal::end(); ?>
</div>
