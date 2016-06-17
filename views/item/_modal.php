<?php
use kartik\export\ExportMenu; 
use kartik\file\FileInput;
use kartik\widgets\FileInput;
?>
<div class="col-md-4 col-lg-4 col-xs-4 onhand">
	<?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'elCaptionText' => '#customOnHand',
        'uploadUrl' => Url::to(['/archivo/fileonhand']),
    ]
	]);
	?>
	<span id="customOnHand" ><?=Yii::t('app','Subir onhand')?></span>
	</div>
	<div class="col-md-4 col-lg-4 col-xs-4 listadeprecio">
	<?= FileInput::widget([
	'name' => 'Archivo[imageFiles][]',
	'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => false,
        'uploadUrl' => Url::to(['/archivo/filelista']),
        'elCaptionText' => '#customlista'
    ]
	]);
	?>
	<span id="customlista" ><?=Yii::t('app','Subir lista')?></span>
	</div>
	</div>
	