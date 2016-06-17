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
/* @var $searchModel app\models\GrupoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this -> title = Yii::t('app', 'Grupos');
$this -> params['breadcrumbs'][] = $this -> title;
?>
<div class="grupo-index col-lg-12 col-md-12 col-xs-12 well">

    <h1><?= Html::encode($this -> title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="col-md-12 col-lg-12 col-xs-12 ">
   <div class="col-md-3">
        <?= ButtonGroup::widget(['buttons' => [Html::a(Yii::t('app', 'Create Grupo'), ['create'], ['class' => 'btn btn-raised btn-success opcion', 'data-toggle' => 'modal', 'data-target' => '#grupo-modal']), Html::a('<span class="caret"></span><div class="ripple-container"></div>', ['#'], ['class' => 'btn btn-raised btn-success dropdown-toggle', 'data-target' => "#", 'data-toggle' => 'dropdown']), Menu::widget(['items' => [['label' => 'Subir archivos', 'url' => ['archivo/upload']]], 'linkTemplate' => '<a href="{url}" class="opcion" data-toggle="modal" data-target="#grupo-modal" ><span>{label}</span></a>', 'options' => ['class' => 'dropdown-menu']]), ]]) ?>
   </div>
   <?php $form = ActiveForm::begin(['action' => 'asignar', ]); ?>
   <div class="col-md-3">
   	   <p class="text-info">Jefe de mecánico </p>
	<?= Select2::widget(['name' => 'usuario', 'data' => $model -> tblUsuarioList, 'size' => Select2::SMALL, 'id' => 'lin', 'options' => ['placeholder' => 'Selecciona Usuario', ], 'pluginOptions' => ['allowClear' => true], ]); ?>
	</div>
	<div class="col-md-3">
		<p class="text-info">Grupo:</p>
		<?= Select2::widget(['name' => 'grupo', 'data' => $model -> tblGrupoList, 'size' => Select2::SMALL, 'id' => 'invnventario', 'options' => ['placeholder' => 'Selecciona Grupo', ], 'pluginOptions' => ['allowClear' => true], ]); ?>		
	</div>
	<div clas="col-md-3">
		<?= Html::submitButton('Agregar', ['class' => 'btn btn-primary pull-left']) ?>
	</div>
		<?php ActiveForm::end(); ?>
</div>
	<div class="col-md-12 col-lg-12 col-xs-12 well">
	<?php Pjax::begin(['clientOptions' => ['method' => 'POST']]); ?>
	<?php $datagrid = [['class' => 'kartik\grid\SerialColumn'], 'tbl_grupo_nombre', ['label' => 'Jefe de mecanico', 'value' => function($model, $key, $index, $widget) {
			$usuarios = $model -> tblUsers;
			$html = "<ul class=\"list-group\">";
			foreach ($usuarios as $key => $usuario) {
				$html .= "<li class=\"list-group-item\">" . $usuario -> tbl_user_nombre . ' ' . $usuario -> tbl_user_apellidomaterno . " " . Html::a('<i class="glyphicon glyphicon-trash"></i>', ['grupo/eliminarusuario/?idusuario=' . $usuario -> id_user . '&idgrupo=' . $model -> id_grupo], ['class' => 'btn btn-default', 'title' => 'Eliminar']) . "</li>";
			}
			$html .= "</ul>";
			return $html;
		}, 'format' => 'raw', ], ['label' => 'Lineas', 'value' => function($model, $key, $index, $widget) {
			$lineas = $model -> tblLineas;
			$html = "<ul class=\"list-group\">";
			foreach ($lineas as $key => $linea) {
				$html .= "<li class=\"list-group-item\">" . $linea -> tbl_linea_nombre . "</li>";
			}
			$html .= "</ul>";
			return $html;
		}, 'format' => 'raw', ], ['class' => 'yii\grid\ActionColumn', 'template' => '{update}{delete}', 'buttons' => ['update' => function($url, $model) {
			return Html::a('<span class="glyphicon glyphicon-edit "></span>', $url, ['title' => Yii::t('app', 'Update Item'), 'class' => 'opcion', 'data-target' => '#grupo-modal', 'data-toggle' => 'modal']);
		}]], ];
		$exportvar = ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $datagrid, 'target' => ExportMenu::TARGET_BLANK, 'asDropdown' => false, ]);
	?>
	
    <?= GridView::widget(['dataProvider' => $dataProvider, 'filterModel' => $searchModel, 'columns' => $datagrid, 'responsive' => true, 'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>' . Html::encode($this -> title) . '</h3>', ], 'toolbar' => ['{export}', ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['#'], ['class' => 'btn btn-default', 'title' => 'Reset Grid'])]], 'export' => ['itemsAfter' => ['<li role="presentation" class="divider"></li>', '<li class="dropdown-header">All Data</li>', $exportvar]]]); ?>
    <?php Pjax::end(); ?>
    </div>
<?php	Modal::begin(['id' => 'grupo-modal', 'size' => 'modal-lg']); ?>
 <div id="grupo-modal-form"></div>
 <?php Modal::end(); ?>
</div>
