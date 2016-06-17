<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PedidosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pedidos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedidos-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ButtonGroup::widget([
        'buttons'=>[
        Html::a(Yii::t('app', 'Create Pedidos'), ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#pedidos-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'create','url'=>'#']],'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	            // 'id_pedidos',
            'tbl_pedidos_cantidad',
            'tbl_pedidos_status',
				[ 
			   		'attribute'=>'tbl_user_id_user', 
					'value'=>'tblUserIdUser.tbl_user_nombre', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_user_id_user',$model->tbluserList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
				[ 
			   		'attribute'=>'tbl_item_id_item', 
					'value'=>'tblItemIdItem.tbl_item_bim', 
					'filter'=>Html::activeDropDownList($searchModel,'tbl_item_id_item',$model->tblitemList,['class'=>'form-control','prompt' => 'Select Category']), 
					'group'=>true 
				],
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#pedidos-modal',
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
			 'id'=>'pedidos-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="pedidos-modal-form"></div>
 <?php Modal::end(); ?>
</div>
