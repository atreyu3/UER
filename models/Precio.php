<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_precio".
 *
 * @property integer $id_precios
 * @property string $tbl_precio_precio
 * @property string $tbl_precio_cambio
 * @property integer $tbl_item_id_item
 * @property integer $tbl_moneda_id_monedainventario
 * @property integer $tbl_proveedor_id_proveedor
 * @property string $tbl_precio_unidadmedida
 * @property string $tbl_precio_unidadcompra
 * @property string $tbl_precio_opcion
 *
 * @property Item $tblItemIdItem
 * @property Moneda $tblMonedaIdMoneda
 * @property Proveedor $tblProveedorIdProveedor

 */
class Precio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_precio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_precio_cambio'], 'safe'],
            [['tbl_item_id_item', 'tbl_moneda_id_moneda', 'tbl_proveedor_id_proveedor'], 'required'],
            [['tbl_item_id_item', 'tbl_moneda_id_moneda', 'tbl_proveedor_id_proveedor'], 'integer'],
            [['tbl_precio_precio', 'tbl_precio_unidadmedida', 'tbl_precio_unidadcompra', 'tbl_precio_opcion'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_precios' => Yii::t('app', 'Id Precios'),
            'tbl_precio_precio' => Yii::t('app', 'Tbl Precio Precio'),
            'tbl_precio_cambio' => Yii::t('app', 'Tbl Precio Cambio'),
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
            'tbl_moneda_id_moneda' => Yii::t('app', 'Tbl Moneda Id Moneda'),
            'tbl_proveedor_id_proveedor' => Yii::t('app', 'Tbl Proveedor Id Proveedor'),
            'tbl_precio_unidadmedida' => Yii::t('app', 'Tbl Precio Unidadmedida'),
            'tbl_precio_unidadcompra' => Yii::t('app', 'Tbl Precio Unidadcompra'),
            'tbl_precio_opcion' => Yii::t('app', 'Tbl Precio Opcion'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemIdItem()
    {
        return $this->hasOne(Item::className(), ['id_item' => 'tbl_item_id_item']); 
    }
        	/**
     * humberto code  
     */
		public function getTblItemList()
    {
          return ArrayHelper::map(Item::find()->all(),'id_item','tbl_item_bim'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMonedaIdMoneda()
    {
        return $this->hasOne(Moneda::className(), ['id_moneda' => 'tbl_moneda_id_moneda']); 
    }
        	/**
     * humberto code  
     */
		public function getTblMonedaList()
    {
          return ArrayHelper::map(Moneda::find()->all(),'id_moneda','tbl_moneda_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblProveedorIdProveedor()
    {
        return $this->hasOne(Proveedor::className(), ['id_proveedor' => 'tbl_proveedor_id_proveedor']); 
    }
        	/**
     * humberto code  
     */
	public function getTblProveedorList()
    {
          return ArrayHelper::map(Proveedor::find()->all(),'id_proveedor','tbl_proveedor_numero'); 
    }
    	/**
     * humberto code  
     */
	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_precio_precio=ucfirst(strtolower(trim($this->tbl_precio_precio)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_precios')->where(['tbl_precio_precio'=>$string])->column() != false ? $this->find()->select('id_precios')->where(['tbl_precio_precio'=>$string])->column() : false;
	}
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Item")
  		$relacionmodelo=new Item(); 
		 if($relacionmodelo=="Moneda")
  		$relacionmodelo=new Moneda(); 
		 if($relacionmodelo=="Proveedor")
  		$relacionmodelo=new Proveedor(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
	public function cargacsv($csvlines,$columns,$check,$id,$opcion){
	$a=array();
	$b=array();
	$bandera=true;
	$bim=$id;
	if($check['relations']==true){
		if(!$mon = Moneda::find()->where(['tbl_moneda_nombre' => 'Mxp'])->one()){
			$mon=new Moneda();
			$mon->tbl_moneda_nombre="Usd";
			$mon->save();
			unset($mon);
			$mon=new Moneda();
			$mon->tbl_moneda_nombre="Mxp";
			$mon->save();
		}
		$idMoneda=$mon->id_moneda;
		unset($mon);
		if(!$pro = Proveedor::find()->where(['tbl_proveedor_nombre' => 'No asignado'])->one()){
			$pro=new Proveedor();
			$pro->tbl_proveedor_nombre="No asignado";
			$pro->save();
		}
		$idProveedor=$pro->id_proveedor;
		unset($pro);
		$Moneda=ArrayHelper::map(Moneda::find()->all(),'id_moneda','tbl_moneda_nombre');
		$Proveedor=ArrayHelper::map(Proveedor::find()->all(),'id_proveedor','tbl_proveedor_numero');
	}
	//$csvlines=$archivo->proccessitem($csv,$bim);
	$columnsaves=$columns['iteracion'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=$this->find()->where(['tbl_item_id_item'=>$csvline[0],'tbl_precio_opcion'=>$opcion])->one()){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
			 			if($columnsave['csv']==5)	
						$modelo->{$columnsave['column']}=$opcion;
						else{
						if($modelo->{$columnsave['column']}!=filter_var($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']) && $csvline[$columnsave['csv']]!=null)
						$modelo->{$columnsave['column']}=($csvline[$columnsave['csv']]==null) ? '' : filter_var($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
						}
					}else {
					$id='id'.$this->nombrecsv($this->nombre($columnsave['column']));
					$tabla=$this->nombre($columnsave['column']);
					$csvid=((array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla)) ? array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla) : $$id);
					if($modelo->{$columnsave['column']}!=$csvid)			
					$modelo->{$columnsave['column']}=$csvid;
					}
				}
				$modelo->save();
				unset($modelo);
			 }else{
			 	if(isset($check['update']) && $check['update']!=true){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
						if($columnsave['csv']==5)	
						$insert[]=$opcion;
						else
						$insert[]=filter_var($this->nombrecsv($csvline[$columnsave['csv']]),$columnsave['filter'],$columnsave['flag']);	
					}else {
					$id='id'.$this->nombrecsv($this->nombre($columnsave['column']));
					$tabla=$this->nombre($columnsave['column']);	
					$insert[]=((array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla)) ? array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla) : $$id);
					}
				}
				$inser[]= $insert;
				unset($insert);
				}
			 }
			 	 unset($csvlines[$key]);
		}
		if(isset($inser)){
		  $connection = Yii::$app->db;
		  $transaction = Yii::$app->db->beginTransaction();
			 try{
			 $db=$columns['db'];
			 $command=$connection->createCommand()->batchInsert($this->tableName(),$db,$inser)->execute();
			 $transaction->commit();
			 return true;
			 }catch(Exception $e){
			 $transaction->rollback();
			 return 'Tienes problemas ';
			 }
		 	}else{
			return print_r($csvlines);
		}
	
	 return $csvlines;
	 }
	
	public function cargalista($carga) {
		set_time_limit(300);
		$archivo = Archivo::findOne($carga);
		$proveedors=ArrayHelper::map(Proveedor::find()->all(),'id_proveedor','tbl_proveedor_numero');
		$monedas=ArrayHelper::map(Moneda::find()->all(),'id_moneda','tbl_moneda_nombre');
		$precios[]=['1','3','15','16'];
		$precios[]=['21','22','34','35'];
		$precios[]=['40','41','53','54'];
		$precios[]=['60','61','72','73'];
		$row=1;
		$col=['tbl_precio_precio','tbl_item_id_item','tbl_moneda_id_moneda','tbl_proveedor_id_proveedor','tbl_precio_opcion'];
		foreach ($precios as $precio) {
		$csvlines=$archivo->proccessall($precio);	
		foreach ($csvlines as $key=>$csvline) {
			if($modelo=Item::find()->where(['tbl_item_bim'=>$csvline[0]])->one()){
				//$pre=$modelo->tblPrecios;
				if(isset($pre)){
					foreach ($pre as $key => $value) {
							if ($value->tblProveedorIdProveedor->tbl_proveedor_numero==$this->nombrecsv($csvline[1])  and $value->tbl_precio_precio!=$csvline[2]) {
							$value->tbl_precio_precio=$csvline[2];
							$value->save();
							}
							if ($value->tblProveedorIdProveedor->tbl_proveedor_numero!=$this->nombrecsv($csvline[1])  and $value->tbl_precio_precio!=$csvline[2]) {
							$value->tbl_proveedor_id_proveedor=array_search($this->nombrecsv($csvline[1]),$proveedors);
							$value->tbl_precio_precio=$csvline[2];
							$value->save();
							}
					}
				}else{
				$item=$modelo->id_item;
				if($csvline[2]!=null){
				$moneda=array_search($this->nombrecsv($csvline[3]),$monedas);
				$proveedor=array_search($this->nombrecsv($csvline[1]),$proveedors);
				$inser[]=[$csvline[2],$item,$moneda,$proveedor,$row];
				}
				unset($csvlines[$key]);
				}
			}
		 }
		$row++;
		}
		$connection = Yii::$app->db;
		$transaction = Yii::$app->db->beginTransaction();
			try{
			$command=$connection->createCommand()->batchInsert(Precio::tableName(),$col,$inser)->execute();
			$transaction->commit();
			}catch(Exception $e){
				$transaction->rollback();
			}
		
		return true;
	}
	protected function nombrecsv($string){
		return ucfirst(strtolower(trim($string)));
	}
}
