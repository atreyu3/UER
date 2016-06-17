<?php
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Button;
?>

<?php $form = ActiveForm::begin(['id'=>'mon','options' => ['enctype' => 'multipart/form-data']]) ?>
	<div>
	<div id="mensajes"></div>	
	<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'csv/*']) ?>
	<div id="filedrag" class="col-md-12 col-lg-12" data-model=<?= $vistanterior ?> >or drop files here</div>
	</div>
<div id="messages" class="col-md-12 col-lg-12 col-xs-12">
<div id="archivo-subida" ></div>
</div>
<div id="maquina" ></div>
<div id="maquina2" ></div>
<?= Button::widget([
    'label' => Yii::t('app', 'Procesar'),
    'options' => ['class' => 'btn-lg ocultar','id'=>'botonprocesar'],
]); ?>
<?= Html::a(Yii::t('app', 'Descargar Formato Usuarios'), ['/user/templateuser'], ['class' => 'btn btn-raised btn-info']) ?>
    </div>
<?php ActiveForm::end() ?>

<?php
	
		$js="
		var form = $('#mon');
		var data =  new FormData();
		function Output(msg,idf) {
       		data.append('Archivo[imageFiles][]',idf);
       		enviar(parseName(idf.name));
       		$('#archivo-subida').append(msg);
		}
		function enviar(name){
			$.ajax({
			url : form.attr('action'),
			method : 'POST',
			contentType : false,
			data : data,
			processData : false,
			success : function(d) {
			$('#id'+name).html(d);
			  console.log(d);   
			$('#botonprocesar').removeClass('ocultar');
			},
			xhrFields: {
                      // add listener to XMLHTTPRequest object directly for progress (jquery doesn't have this yet)
               onprogress: function(progress) {
               var percentage = Math.floor((progress.loaded / progress.total) * 100);
               $('#'+name).css('width',Math.floor((progress.loaded / progress.total) * 100)+'%');
               console.log('#'+name);
               if (percentage === 100) {
               //$('#archivo-subida').html('Archivo correctamente subido'); 
                                         
                }
               }
              },
			});
		}
	if (window.File && window.FileList && window.FileReader) {
	Init();
	}
	// initialize
	function Init() {

	var fileselect = document.getElementById('archivo-imagefiles'),
		filedrag = document.getElementById('filedrag');
	// file select
	fileselect.addEventListener('change', FileSelectHandler, false);
	//file drag
	filedrag.addEventListener('dragover', FileDragHover, false);
	filedrag.addEventListener('dragleave', FileDragHover, false);
	filedrag.addEventListener('drop', FileSelectHandler, false);
	filedrag.style.display = 'block';
	// remove submit button
	}
// file drag hover
	function FileDragHover(e) {
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.type == 'dragover' ? 'hover' : '');
	}
// file selection
	function FileSelectHandler(e) {
	// cancel event and hover styling
	FileDragHover(e);
	// fetch FileList object
	var files = e.target.files || e.dataTransfer.files;
	// process all File objects
	for (var i = 0, f; f = files[i]; i++) {
		ParseFile(f);
	}
	}

	function ParseFile(file) {
	var ban=true;
	var validExts = new Array(\".xlsx\", \".xls\", \".csv\");
	fileExt = file.name.split('.')[1];
	if(fileExt=='xlsx' || fileExt=='xls' || fileExt=='csv'){
	ban=false;
	Output(
		'<div name='+file.name+' class=\"archivos well col-xs-4 col-md-4 col-lg-4\">' +
		'".Html::a(Yii::t('app', 'Procesar'),['#'], ['class' => 'procesar'])." Nombre:' + file.name +'<div id=\"id'+parseName(file.name)+'\" ></div>'+
		'<div class=\"progress\"  ><div  id='+parseName(file.name)+' class=\"progress-bar progress-bar-striped\"  role=\"progressbar\"  aria-valuemin=\"0\" aria-valuemax=\"100\"></div></div> '+
		'tamaño:' + file.size +
		'bytes</div>',file );
		}
	if(ban==true){
		alerta='<div class=\"alert alert-dismissible alert-warning\">';
  		alerta+='<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>';
 		alerta+='<h4>Espera!!!</h4>';
		alerta+='<p>".Yii::t('app','Archivo no compatible')."</p>';
		alerta+='</div>';
		$('#mensajes').html(alerta);
	}	
	
	}
	function parseName(str){
	var res=str.split('.');
	var respuesta;
	if(res.length>0){
		if(res[0].split(' ').length>1){
		 respuesta=res[0].split(' ')[0];	
		}else{
		respuesta=res[0];
		}
	}
	return respuesta;
	}
	 $(document.body).on('click','.procesar',function(e){
	 	e.stopPropagation();
	 	e.preventDefault();
		$('#maquina').fadeIn();
		var csvcabecera;
		var modelcabecera;
		var model=$('#filedrag').data('model');
		var idfile=$(this).next('div').html();
		$.ajax({
		 	url:'".Url::toRoute('archivo/list/')."',
		 	method:'POST',
		 	cache:false,
		 	data:{id:$(this).next('div').html()},
		 	success:function(success){
		 		csvcabecera=success;	
		 	},
			async: false
		 });
		 $.ajax({
		 		url:'".Url::toRoute($vistanterior.'/list/')."',
		 		method:'POST',
		 		cache:false,
		 		success:function(success){
		 			modelcabecera=success;
				},
				async: false
		 		});
		 		$('#maquina').html(tabla(modelcabecera,csvcabecera,idfile));
	 });
	$('#botonprocesar').click(function(e){
		e.stopPropagation();
	 	e.preventDefault();
		var modelcsv = {};	
		$('.subir').each(function(){
			modelcsv[$(this).attr('name')]=$(this).val();
		});
		 $.ajax({
		 		url:'".Url::toRoute($vistanterior.'/csv/')."',
		 		method:'POST',
		 		cache:false,
		 		data:{modelcsv,id:$(\"#tablaidentificacion\").data(\"file\")},
		 		success:function(success){
		 			$('#maquina').fadeOut();
		 			$('#maquina2').html(tablafaltantes(success));
				},
				async: false
		 		});
		 		
	 	});
	function tabla(csv,model,idfile){
		var salida='<table id=\"tablaidentificacion\" class=\"table table-striped table-hover \" data-file='+idfile+' >';
		salida+='<thead><tr><th>".Yii::t('app', 'Texto csv')."</th><th>".Yii::t('app', 'Texto model')."</th></tr></thead><tbody>'
		var select='';
		select+='<option value=\"nulo\" >".Yii::t('app', 'nulo')."</option>';
		$.each(model,function(o,valo){
			select+='<option value=\"'+o+'\" >'+valo+'</option>';
		});
		$.each(csv,function(i,val){
			salida+='<tr><td>'+val+'</td>';
			salida+='<td><select name='+i+' class=\"form-control subir \">'+select+'</select></td></tr>';
			
		});
		salida+='</tbody></table>';
		return salida;
	}
	function tablafaltantes(csv){
		var salida='<table class=\"table table-striped table-hover \"  >';
		salida+='<thead><tr><th>".Yii::t('app', 'Texto columna')."</th><th>".Yii::t('app', 'Texto faltantes')."</th></tr></thead>';
		$.each(csv,function(i,val){
			salida+='<tr><td>'+val+'</td>';
			//$.each(csv,function(i,val){
			//salida+='<td><select name='+i+' class=\"form-control subir \">'+select+'</select></td></tr>';
			//}
		});
		salida+='</tbody></table>';
		return salida;
	}
	";
$this->registerJs($js);
