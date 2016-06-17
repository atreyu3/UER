<?php

use yii\helpers\Html;
use app\assets\TransaccionAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

TransaccionAsset::register($this);
$uso=$model->tblusorefaccionList;
$ma=$model->tblmaquinaList;
$cescos=['---','----'];
$maquina=['---','----'];
?>
<div id="grid" class="grid clearfix wrap" >
   

<div class="st-container" style="min-height: 600px">
<div class=" col-lg-12 col-md-12 col-xs-12 " style="margin-top: 55px;">
	    <div class=" col-lg-8 col-md-8 col-xs-12">
	    	
<?php foreach($rfid as $key =>$rf ):?>
	<?php if($key!=""): ?>
	<div class="grid__item" mant="no" ><div style="padding-left:60px;padding-top:15px;color: #fff;" ><div >Piezas  <?= $rf["cont"] ?></div> <?= $item->description($key)?></div></div>
	<?php endif;?>
<?php endforeach; ?>
		</div>
		<!-- <div class=" col-lg-4 col-md-4 col-xs-12">
      <label class="control-label" >Ubicación</label>
			     Html::dropDownList('Grupo', null, $model->CentrodecostosList, ['prompt'=>'----','class'=>'form-control','id'=>'cescos', 'onchange'=> '
                $.post( "'.Yii::$app->urlManager->createUrl('maquina/lists?id=').'"+$(this).val(), function( data ) {
                  $( "#maquina" ).html( data );
                })
            ','multiple'=>'multiple','size'=>'25','style'=>'font-size:16px;' ])
         </div>
         -->
		<div id="drop-area" class="drop-area" >
			<div id="maquina" style="overflow: auto;">
				<div class="drop-area__item"></div>
				<?php for($i=1;$i<=count($ma);$i++):?>
				<div class="drop-area__item"  id="<?= $i ?>" ><?= $ma[$i] ?> </div>
				<?php endfor; ?>
		
			</div>
		</div>
<div id="drop-area2" class="drop-area">
			<div>
				<?php for($i=1;$i<=count($uso);$i++):?>
				<div class="drop-area__item"  id="<?= $i ?>" ><?= $uso[$i] ?> </div>
				<?php endfor; ?>
				
			</div>
		</div>

		<div class="drop-overlay"></div>

</div>


	</div>
</div>