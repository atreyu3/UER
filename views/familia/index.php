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
/* @var $searchModel app\models\FamiliaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Familias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="familia-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
       <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Familia'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#familia-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'Subir archivos','url'=>['archivo/upload']],['label'=>'item','url'=>['item/create']] ],
        'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#familia-modal" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
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
        'uploadUrl' => Url::to(['/archivo/familias']),
    	]
		]);
		?>
	<span id="customMaquina" ><?=Yii::t('app','Carga de Equipos')?></span>
	</div>
	</div>
	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_familia',
            'tbl_familia_nombre',
            'tbl_familia_siglas',
				[ 
			   		'attribute'=>'tbl_catfamilia_id_catfamilia', 
					'value'=>'tblCatfamiliaIdCatfamilia.tbl_catfamilia_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_catfamilia_id_catfamilia',$model->tblcatfamiliaList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#familia-modal',
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
			 'id'=>'familia-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="familia-modal-form"></div>
 <?php Modal::end(); ?>
</div>
