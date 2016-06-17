<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
   	'id'=>$model->formName(),
    ]); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
    	$tabla=explode("_", $attribute);
    	if(Inflector::camel2id(StringHelper::basename($generator->modelClass))==$tabla[1]){
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
		}else{
		echo "    <?= \$form->field(\$model, '$attribute')->dropDownList(\$model->$tabla[0]$tabla[1]List, ['prompt' => ''])  ?>\n\n";	
		}
    }
} ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?= "<?php" ?>


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
