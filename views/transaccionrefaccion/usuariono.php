<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaccionrefaccion */

?>
<style>
.row .btn {
    float: left!important;
}


</style>
<div class="transaccionrefaccion-update">
	<div class="col-md-12 well">
	<?php if(!isset($usuarios)){?>
    <h1> "Upss!! Usuario no  encontrado o items no leidos " </h1>
    <h2> "Por favor recarga" </h2>
    <?php } else{?>
     <h1> "Por favor seleccionate en la lista de usuarios disponibles para ingresar al sistema:" </h1>
     <?php }?>
    <?= Html::a(Yii::t('app', 'Cambiar usuario'), ['/transaccionrefaccion/cambiarusuario'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#transaccionrefaccion-modal']) ?>
   </div> 
   <div  style="clear:both">

	<?php if(isset($usuarios)){?>
	
   <?php foreach($usuarios as $usr){?>

    <div class="row" > 

   <?= Html::a(Yii::t('app', $usr['nombre'].' '.$usr['apellido']), ['/transaccionrefaccion/cambiarusuario?id_readusuario='.$usr['id_readusuario']], ['class' => 'btn btn-raised btn-warning opcion','data-toggle'=>'modal','data-target'=>'#transaccionrefaccion-modal',
   		'data' => [
   				'method' => 'GET',
   				'confirm'=>'Estas seguro que deseas continuar?',
   				'params' => [
   						'id_user'=>$usr['id_user'],
   						'id_readusuario'=>$usr['id_readusuario']
   				]
   		]
        
     ]);  
   ?>
    </div>
	
   <?php }?>

   <?php }?>
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
	},15000)});
";
$this->registerJs($js);