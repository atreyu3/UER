<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\db\ColumnSchema;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;
use yii\widgets\Menu;
use yii\widgets\Pjax;
use kartik\export\ExportMenu; 
use kartik\grid\GridView;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <p>
        <?= "<?= " ?>ButtonGroup::widget([
        'buttons'=>[
        Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-modal']), 
        Html::a('<span class="caret"></span><div class="ripple-container"></div>',['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle','data-target'=>"#",'data-toggle'=>'dropdown']),
        Menu::widget(['items'=>[['label'=>'Subir archivos','url'=>['archivo/upload']],['label'=>'item','url'=>['item/create']] ],
        'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-modal" ><span>{label}</span></a>',
        'options'=>['class'=>'dropdown-menu']]),
        ]
        ])
        ?>
    </p>

<?php if ($generator->indexWidgetType === 'grid'): ?>
	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?= "<?php" ?> Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?= "<?php" ?> $datagrid=[
	['class' => 'kartik\grid\SerialColumn'],
	<?php
	$count = 0;
	if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
    if (++$count < 6 and  $count > 1 ) {
    		echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
      }
	} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 15  and $count>1) {
        	if($count==2)$tabla=tabla($column->name);
				if($tabla==tabla($column->name)){
					echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
				}else{
					echo "				[ "."\n";
            		echo "			   		'attribute'=>'".$column->name."', \n";
					echo "					'value'=>'".valueformat($column->name).".".firstcolumn($column->name)."', \n";
					echo "					'filter'=>Html::activeDropDownList(\$searchModel,'".$column->name."',\$model->".prefijo($column->name)."List,['class'=>'form-control','prompt' => 'Select Category']), \n";
					echo "					'group'=>true \n";		
					echo "				],"."\n";
				}
				
		} else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        	}
    	}
	}
	?>
	['class' => 'yii\grid\ActionColumn',
		'template'=>'{update}{delete}',
		'buttons'=>[
		  'update'=>function ($url, $model) {
		  	return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, [
                                        'title' => Yii::t('app', 'Update Item'),
                                        'class'=>'opcion',
                                        'data-target'=>'#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-modal',
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
	
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => " : "'columns' => "; ?>
        $datagrid,
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
    <?= "<?php" ?> Pjax::end(); ?>
    </div>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
<?= "<?php" ?>
	Modal::begin([
			 'id'=>'<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-modal',
			 'size'=>'modal-lg'
	]);
 ?>
 <div id="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-modal-form"></div>
 <?= "<?php" ?> Modal::end(); ?>
</div>
<?php
	function tabla($string){
		$i=explode("_", $string);
		return $i[1];		
	}
	function prefijo($string){
		$i=explode("_", $string);
		return $i[0].$i[1];		
	}
	function valueformat($string){
		$a=explode("_", $string);
		return $a[0].ucfirst($a[1]).ucfirst($a[2]).ucfirst($a[3]);		
	}
	function firstcolumn($string){
		$l=null;
		$a=explode("_", $string);
		$namelists=Yii::$app->db->getTableSchema(strtolower($a[0]."_".$a[1]))->getColumnNames();
		return $namelists[1];
	}
?>