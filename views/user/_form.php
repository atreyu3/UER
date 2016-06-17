<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$jefe=[""=>"--"];
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

    <?= $form->field($model, 'tbl_user_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_user_apellidomaterno')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'tbl_user_apellidopaterno')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'tbl_user_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_user_password')->passwordInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'tbl_user_numeroempleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbl_user_siglas')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tbl_categoriauser_id_categoriauser')->dropDownList($model->tblcategoriauserList,['prompt'=>'----','onchange'=> '
                $.post( "'.Yii::$app->urlManager->createUrl('user/categoria?id=').'"+$(this).val(), function( data ) {
                  $( "select#categoriauser" ).html( data );
                })']) ?>
                
	 <?=  Html::dropDownList('Jefe', null, $jefe,['id'=>'categoriauser','class'=>'form-control']) ?>
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
    });
    ';
if(isset($formid)){
$js.='$("#user-tbl_categoriauser_id_categoriauser")
    .val("'.$formid.'")
    .trigger("change");';
}	
$this->registerJs($js);