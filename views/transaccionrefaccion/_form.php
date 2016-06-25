<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaccionrefaccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaccionrefaccion-form">

    <?php $form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

    <?= $form->field($model, 'mod_transaccionrefaccion_date')->textInput() ?>

    <?= $form->field($model, 'mod_transaccionrefaccion_piezas')->textInput(['maxlength' => true]) ?>
	
	<label class="control-label" for="Linea"> Linea </label>
	<?=  Html::dropDownList('Linea', null, $model->tblLineaList ,['prompt' => '','class'=>'form-control',
				'onchange'=> '$.post( "'.Yii::$app->urlManager->createUrl('transaccionrefaccion/linea2?id=').'"+$(this).val(), function( data ) {
                  $( "select#maquina" ).html( data );
                })']) ?>
	
    <?= $form->field($model, 'tbl_maquina_id_maquina')->dropDownList($model->tblmaquinaList, ['prompt' => '','id'=>'maquina'])  ?>

    <?= $form->field($model, 'tbl_usorefaccion_id_usorefaccion')->dropDownList($model->tblusorefaccionList2, ['prompt' => ''])  ?>

    <?= $form->field($model, 'tbl_item_id_item')->dropDownList($model->tblitemList, ['prompt' => ''])  ?>

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
