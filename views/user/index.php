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
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index col-lg-12 col-md-12 col-xs-12 well">
	
    <h1><?= Html::encode($this->title) ?></h1>
    <div  class=" col-lg-12 col-md-12 col-xs-12 ">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-3 col-lg-3 col-xs-3 pull-left" >
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#user-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'Subir archivos','url'=>['archivo/upload']],['label'=>'Jefe de mecánico','url'=>['user/create/?form=Jefe']]],
        'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#user-modal" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pull-right " >
     <?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'uploadUrl' => Url::to(['/archivo/subirtemplateuser']),
    	]
		]);
		?>
	<span id="customUser" class="text-info " ><?=Yii::t('app','Carga User')?></span>
	</div>    
	<div class="col-md-5 col-lg-5 pull-right"><?= Html::a(Yii::t('app', 'Descargar Formato Usuarios'), ['/user/templateuser'], ['class' => 'btn btn-raised btn-info']) ?></div>
	</div>
	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_user',
            'tbl_user_nombre',
            'tbl_user_apellidomaterno',
            'tbl_user_apellidopaterno',
            //'tbl_user_password',
            //'tbl_user_auth_key',
            'tbl_user_siglas',
				[ 
			   		'attribute'=>'tbl_categoriauser_id_categoriauser', 
					'value'=>'tblCategoriauserIdCategoriauser.tbl_categoriauser_nombre', 
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tblcategoriauserList,
					 'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
					'group'=>true 
				],
				[
					'attribute'=>'id_jefemecanico', 
					'label'=>'Jefe de mecánico',
					'value'=>function($model){if($model->checkjefe!=null) return $model->checkjefe; else "no asignado";}, 
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$model->tbluserList,
					 'filterInputOptions'=>['placeholder' => 'Selecciona '],
					'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
    				],
					'group'=>true 
				],
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#user-modal',
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
			 'id'=>'user-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="user-modal-form"></div>
 <?php Modal::end(); ?>
</div>
