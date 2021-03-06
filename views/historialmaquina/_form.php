<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Historialmaquina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historialmaquina-form">

    <?php $form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

    <?= $form->field($model, 'id_historialmaquina')->textInput() ?>

    <?= $form->field($model, 'tbl_historialmaquina_antes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_historialmaquina_despues')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_historialmaquina_cambio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_historialmaquina_date')->textInput() ?>

    <?= $form->field($model, 'tbl_historialmaquina_usuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_maquina_id_maquina')->dropDownList($model->tblmaquinaList, ['prompt' => ''])  ?>

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
