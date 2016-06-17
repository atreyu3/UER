<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

    <?= $form->field($model, 'tbl_item_bim')->textInput(['maxlength' => true]) ?>
    <?php if($model->tbl_item_stock ==''):?>
    <?= $form->field($model, 'tbl_item_stock')->textInput() ?>
    <?php else: ?>
    <?= $form->field($model, 'tbl_item_stock')->textInput(['readOnly' =>true]) ?>
    <?php endif;?>
    <?= $form->field($model, 'tbl_item_almacen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_item_noParte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_item_nombre')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'tbl_familia_id_familia')->dropDownList($model->tblfamiliaList, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_categoriaitem_id_categoriaitem')->dropDownList($model->tblcategoriaitemList, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_marca_id_marca')->dropDownList($model->tblmarcaList, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_item_unidadmedida')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'tbl_item_parcialidad')->checkbox() ?>
	
	<?= $form->field($model, 'tbl_item_parcialnumero')->textInput() ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$js='$("form#'.$model->formName().'").on("beforeSubmit",function(e){
		var form = $("#'.$model->formName().'");
		var formaction=form.attr("action");
		if(form.find(".has-error").length) {
            return false;
        }                               
        $.ajax({
            url: formaction,
            type: "post",
            data: form.serialize(),
            success: function(response) {                                       
                $("#'.strtolower($model->formName()).'-modal-form").html(response);
            }
       });                              
       return false;
    });';
$this->registerJs($js);
