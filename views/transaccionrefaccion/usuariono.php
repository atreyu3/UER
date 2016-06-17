<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaccionrefaccion */

?>
<div class="transaccionrefaccion-update">
	<div class="col-md-12 well">
    <h1> "Upss!! Usuario no  encontrado o items no leidos " </h1>
    
    <h2> "Por favor recarga" </h2>
    <?= Html::a(Yii::t('app', 'Cambiar usuario'), ['/transaccionrefaccion/cambiarusuario'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#transaccionrefaccion-modal']) ?>
   </div> 
</div>
<?php
$js="$(document).ready(function(){
	setInterval(function(){
		$.ajax({
  			type: \"POST\",
  			url: \"recargarusuario\",
  			success:function(data2){
  				if(data2==false){
  					console.log(\"todo igual\");
  				}
  			}
  			});	
	},5000)});
";
$this->registerJs($js);