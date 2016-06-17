<?php

use yii\helpers\Html;
use app\assets\TransaccionAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use kartik \ Widgets \ DepDrop;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
$uso=$model->tblusorefaccionList;
$ma=$model->tblmaquinaList;
$cescos=['---','----'];
$maquina=['---','----'];

?>

<div id="grid" class="grid clearfix wrap well" >
 <div class="row">
<div class="st-container" style="min-height: 600px">
<div class=" col-lg-12 col-md-12 col-xs-12 " >
<div class=" col-lg-12 col-md-12 col-xs-12 " style="margin-top: 30px;">
<div id="alertas"></div>
	<div class="col-md-4 col-lg-4 col-xs-12" >
	<p><b>Línea</b></p>
 		<?= Select2::widget([
		'name' => 'kv-state-220',
		'data' => $model->tbllineaList,
		'size' => Select2::SMALL,
		'id'=> 'lin',
	   'options' => ['placeholder' => 'Selecciona ...',
				'onchange' =>'
				var id=$(this).val();
				var nombre=$(this).find("option:selected").text();
				$.get ("'.Url::toRoute('transaccionrefaccion/linea').'",{ id } )
			 	.done(function (data){
			    $("#mod_transaccionrefaccion_maquina").html(data);
				var lin=document.getElementById("lin");
				if($("#seleccionarto").hasClass("checked")){
			 	$(".linea1").html(nombre);
				}else{
					$("[type=checkbox]").each(function () {
    				if($(this).is(":checked")) {
    				var id=$(this).attr("id");	
        			$("#"+$(this).attr("item")+" .linea1").html(nombre);
        			console.log($(this).text());
					}
					});
				}
			 	}
			 	);
				'],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);
		?>
		</div>
		<div class="col-md-4 col-lg-4 col-xs-12">
		<p><b>Máquina</b></p>
		<?= Select2::widget([
			'name' => 'kv-state-220',
			'data' => array(),
			'size' => select2::SMALL,
			'id'=>'mod_transaccionrefaccion_maquina',
			'class'=> 'bim1',
			'options' => ['placeholder' => 'Selecciona ...'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
		?>
		</div>
		<div class="col-md-4 col-lg-4 col-xs-12">
		<?= Html::a(Yii::t('app', 'Cambiar usuario'), ['/transaccionrefaccion/cambiarusuario'], ['class' => 'btn btn-raised btn-success opcion','data-toggle'=>'modal','data-target'=>'#transaccionrefaccion-modal']) ?>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12">
		<p><b>Parcialidad</b></p>
 		<?= Select2::widget([
		'name' => 'parcialidad',
		'data' => $item->parcialidad(),
		'size' => Select2::SMALL,
		'id'=> 'parcialidad',
	   'options' => ['placeholder' => 'Selecciona ...',
				'onchange' =>'
				var id=$(this).val();
				var nombre=$(this).find("option:selected").text();
				$.get ("'.Url::toRoute('transaccionrefaccion/parcial').'",{ id } )
			 	.done(function (data){});
				'],
			'pluginOptions' => [
				'allowClear' => true
			],
	]);
		?>
		</div>
	</div>
	    <div class=" col-lg-12 col-md-12 col-xs-12 ">
		 	<div class="btn-group btn-group-justified">
	    		<?php foreach($uso as $us): ?>
				<a onclick='var nombremant=$(this).text(); var idmante=$(this).attr("mant"); $("[type=checkbox]").each(function () { if($(this).is(":checked")) { var idman=$(this).attr("item"); console.log(nombremant+idman); $("#"+idman+"_manto").attr("itmantenimiento",idmante);  $("#"+idman+"_manto").html(nombremant); }else{ $(idman).html("Sin asignar");}});' class="btn btn-raised btn-info seleccionarmantenimiento" style="background-color:<?= $us->tbl_usorefaccion_color ?>;" mant="<?= $us->id_usorefaccion ?>" ><?= $us->tbl_usorefaccion_nombre ?></a>
				<?php endforeach; ?>
			</div>	
			<?= Html::submitButton('Asignar', ['class' => $model->isNewRecord ? 'btn btn-raised btn-info asignar' : 'btn btn-primary']) ?>
	    <table id="tablaenviar" class="table table-striped table-hover col-lg-12 col-md-12 col-xs-12 ">
	    	<thead>
	    		<tr>
	    			<th>	
	    			<div id="seleccionarto" class="checkbox">
					<input type="checkbox" id="chek" ><span class="checkbox-material"><span class="check"></span></span>
					</div> 
        			</th>
	    			<th><?= Yii::t('app','Tbl Item Bim');?></th>
	    			<th><?= Yii::t('app','Tbl Item No Parte');?></th>
	    			<th><?= Yii::t('app','Tbl Item Nombre');?></th>
	    			<th>Piezas</th>	
				    <th>Mantenimiento</th>
					<th>Linea</th>
					<th >Maquina</th>
	    			<th></th>
	    		</tr>
	    	</thead>
<?php $for=0; ?>
<?php foreach($rfid as $key =>$rf ):?>
    <?php if($key!=""): ?>
    	<?php if($item->ides($key)!="no"): ?>	
	<tr id="<?= $item->ides($key) ?>" class="itemenviar" csv="" count=<?= $rf["cont"] ?> >
		<td>
			<label>
			<div class="checkbox">
				<input name="itemcheck" type="checkbox" item="<?= $item->ides($key) ?>" ><span class="checkbox-material"><span class="check"></span></span>
			</div> 
            </label>
        </td>
		<td><?= $item->bim($key) ?></td>
		<td><?= $item->noparte($key)?></td>
		<td><?= $item->description($key)?></td>
		<td><input class="piezas" class="form-control" type="number" value="<?= $rf["cont"] ?>" style="width:100px; height:100px" ></input></td>
		<td class="mantenimiento " id="<?= $item->ides($key) ?>_manto" itmantenimiento="" ></td>
	<td class='linea1 ' data-linea="" ><?= Html::dropDownList('maquina',null,$model->tbllineaList,
	['class'=> 'linea','onchange'=>' var id=$(this).val(); $.get("'.Url::toRoute('transaccionrefaccion/linea2').'",{ id }).done(function (data){ $("#maquina'.$key.'").html(data); });']
	); ?></td>
   <td maquinaid="" class='bim1' ><?= Html::dropDownList('maquina',null,['--'],
   ['class'=> 'maquinaid','style'=>'width: 100px;','id'=>'maquina'.$key,'onchange'=>'var valor=$(this).val();$("#'.$item->ides($key).' .bim1").attr("maquinaid",valor);']
   ); ?></td>
	</tr>
		<?php endif;?>
	<?php endif;?>
<?php endforeach; ?>
		</div>
</div>
	</div>
</div>
<?php
$js='
$(document).ready(function(){
	setInterval(function(){
		var dataenviar=[];
		$("#tablaenviar tr").each(function(){
		var ide=$(this).attr("id");
		var value=$("#"+$(this).attr("id")+" .piezas").val();
		dataenviar.push({id:ide,count:value});
		});
		$.ajax({
  			type: "POST",
  			url: "recargar",
  			data: {id:dataenviar},
  			success:function(data2){
  				if(data2==true){
  					
  				}else{
  					response=JSON.parse(data2);
  					$.each(response,function(k,v){
  						if(v.existe=="si"){
  							if(v.count==0){
  								
  							}else{
  							$("#"+v.id+" .piezas").val(v.count);
							}
  						}else{
  						$("#tablaenviar tr:last").after(\'<tr id="\'+v.id+\'" class="itemenviar" count="\'+v.count+\'" ><td><label>\'
  						+\'<div class="checkbox"><input name="itemcheck" type="checkbox" item="\'+v.ides+\'" ><span class="checkbox-material"><span class="check"></span></span>\'
						+\'</div></label></td>\'
						+\'<td>\'+v.bim+\'</td>\'
						+\'<td>\'+v.noparte+\'</td>\'
						+\'<td>\'+v.description+\'</td>\'
						+\'<td><input class="piezas" class="form-control" type="number" value="\'+ v.count +\'" style="width:100px; height:100px" ></input></td>\'
						+\'<td class="mantenimiento " id="\'+v.ides+\'_manto" itmantenimiento="" ></td>\'
						+\'<td class="linea1" data-linea="" >\'
						+\''.str_replace("\n", "", Html::dropDownList('maquina',null,$model->tbllineaList,['class'=> 'linea','onchange'=>' var id=$(this).val(); $.get("'.Url::toRoute('transaccionrefaccion/linea2').'",{ id }).done(function (data){ $("#maquina").html(data); })'])).'</td>\'
   						+\'<td maquinaid="" class="bim1" >'.str_replace("\n", "", Html::dropDownList('maquina',null,['--'],['class'=> 'maquinaid','style'=>'width: 100px;','onchange'=>'var valor=$(this).val(); $("#"+v.id+" .bim1").attr("maquinaid",valor);','id'=>'maquina'.$key])).'</td>\'
						+\'</tr>\');
						}
  					console.log("valor bim"+v.bim);
  					});
  				}
  			},
  			});
	},5000);
		});
	$("input[type=checkbox]").click(function(){
		if(!$("#seleccionarto").hasClass("checkedp")){
		$(this).attr("checked",true);
		$("#seleccionarto").toggleClass("checkedp");
		}else{
		$(this).removeAttr("checked");
		$("#seleccionarto").toggleClass("checkedp");
		}
	});
   $("#seleccionarto").click(function() {
			if(!$(this).hasClass("checked")){
			$(this).addClass("checked");
				$("input[type=checkbox]").prop("checked", true);
			    $(".linea").fadeOut();
			     $(".bim").fadeOut();
			}else{
			     $(this).removeClass("checked");
				$("input[type=checkbox]").removeAttr("checked");
				$(".mantenimiento").html("");
				//$("#proyecto").prop("disabled", true);
			   $(".linea").fadeIn();
			     $(".bim").fadeIn();
				}
	});
	$(".asignar").click(function(){
		if (confirm("¿Desea continuar?")) {
		$("[type=checkbox]").each(function () {
		console.log("idmon"+$(this).attr("id"));	
		if($(this).attr("id")!="chek"){
        if($(this).is(":checked")) {
        	if($("#"+$(this).attr("item")).css("display") != "none"){
        	console.log("si pasa:"+$(this).attr("item"));
			var iditemaux=$(this).attr("item");
         	$.ajax({
  			type: "POST",
  			url: "guardarrefacciones",
  			data: {item:$(this).attr("item"),piezas:$("#"+$(this).attr("item")+" .piezas").val(),mantenimiento:$("#"+$(this).attr("item")+" .mantenimiento").attr("itmantenimiento"),maquina:$("#"+$(this).attr("item")+" .bim1").attr("maquinaid")},
  			success : function(response){
  				if(response==true){
  				console.log("idrespuesta "+iditemaux);	
  				$("#"+iditemaux).fadeOut();
				$(this).attr("checked",false);
				$("#alertas").html("<div class=\"alert alert-success\">"
  				+"<p>Item asignado correctamente!!</p>"
				+"</div>");
				}else{
				$("#alertas").html("<div class=\"alert alert-danger\">"
  				+"<p>"+response+"</p>"
				+"</div>");	
				}	
  			}
			});
			}else{
				console.log("no entro "+$(this).is(":visible"));
			}
		}else{
			console.log($(this).html()+"Sin asignar");
		}
		}
		});
    // Save it!
	} else {
    // Do nothing!
	}
	});
	';
$this->registerJs($js);