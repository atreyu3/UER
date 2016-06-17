 <div class="col-lg-6 col-md-6 col-xs-6 ">
 <table class="table table-striped table-hover ">
	    	<thead>
	    		<tr>
	    			<th><?= Yii::t('app','Item');?></th>
	    			<th><?= Yii::t('app','Descripcion');?></th>
	    			<th><?= Yii::t('app','Cantidad');?></th>
	    		</tr>
	    	</thead>
	  <?php 
	  $items=$model->tblComprasHasTblItems;?>
<?php foreach( $items as $key ):?>
	<tr >
		<td><?= $key->tblItemIdItem->tbl_item_bim ?></td>
		<td><?= $key->tblItemIdItem->tbl_item_nombre ?></td>
		<td><?= $key->tbl_compras_has_tbl_item_cantidad ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>