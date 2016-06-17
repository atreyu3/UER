<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Read */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="read-form">

    <?php $form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

    <?= $form->field($model, 'tbl_read_tagid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_read_antena')->textInput() ?>

    <?= $form->field($model, 'tbl_read_timestamp')->textInput() ?>

    <?= $form->field($model, 'tbl_read_rssi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_readusuario_id_readusuario')->dropDownList($model->tblreadusuarioList, ['prompt' => ''])  ?>

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
