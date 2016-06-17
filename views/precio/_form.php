<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Precio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="precio-form">

    <?php $form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

    <?= $form->field($model, 'tbl_precio_precio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_precio_cambio')->textInput() ?>

    <?= $form->field($model, 'tbl_item_id_item')->dropDownList($model->tblitemList, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_moneda_id_moneda')->dropDownList($model->tblmonedaList, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_proveedor_id_proveedor')->dropDownList($model->tblproveedorList, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_precio_unidadmedida')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_precio_unidadcompra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_precio_opcion')->textInput(['maxlength' => true]) ?>

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
