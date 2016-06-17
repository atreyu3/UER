<div class="col-md-12 col-lg-12 col-xs-12">
 <div class="col-lg-4 col-md-4 col-xs-12 ">
 <table class="table table-striped table-hover ">
	    	<thead>
	    		<tr>
	    			<th><?= Yii::t('app','Inventory');?></th>
	    			<th><?= Yii::t('app','No Piezas');?></th>
	    		</tr>
	    	</thead>
	  <?php 
	  $inve=$model->inventory();
	  $inventorys=$model->tblItemHasTblInventarios;?>
<?php foreach( $inventorys as $key ):?>
	<tr >
		<td><?= isset($inve[$key->tbl_inventario_id_inventario]) ? $inve[$key->tbl_inventario_id_inventario] : null ?></td>
		<td><?= $key->tbl_item_has_tbl_inventario_cantidad ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="col-lg-6 col-md-6 col-xs-12 ">
<table class="table table-striped table-hover col-lg-6 col-md-6 col-xs-6 ">
	    	<thead>
	    		<tr>
	    			<th><?= Yii::t('app','No opcion');?></th>
	    			<th><?= Yii::t('app','No Proveedor');?></th>
	    			<th><?= Yii::t('app','Nombre Proveedor');?></th>
	    			<th><?= Yii::t('app','Numero de conversión');?></th>
	    			<th><?= Yii::t('app','Precio');?></th>
	    			<th><?= Yii::t('app','Moneda');?></th>
                    
	    		</tr>
	    	</thead>
	  <?php $precios=$model->tblPrecios;?>
<?php foreach( $precios as $key ):?>
	<tr >
		<td><?= $key->tbl_precio_opcion ?></td>
		<td><?= $key->tblProveedorIdProveedor->tbl_proveedor_numero ?></td>
		<td><?= $key->tblProveedorIdProveedor->tbl_proveedor_nombre ?></td>
		<td><?= $key->tbl_precio_unidadcompra ?></td>
		<td><?= $key->tbl_precio_precio ?></td>
		<td><?= $key->tblMonedaIdMoneda->tbl_moneda_nombre ?></td>

	</tr>
<?php endforeach; ?>
</table>
</div>
</div>