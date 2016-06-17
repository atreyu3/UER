<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArchivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Archivos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archivo-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Archivo'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#archivo-modal']), 
        //Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        //Menu::widget(['items'=>[['label'=>'create','url'=>'#']],'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_archivo',
            'tbl_archivo_nombre',
            'tbl_archivo_fecha',
            'tbl_archivo_user',
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#archivo-modal',
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
			 'id'=>'archivo-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="archivo-modal-form"></div>
 <?php Modal::end(); ?>
</div>
