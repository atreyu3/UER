<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_proveedor".
 *
 * @property integer $id_proveedor
 * @property string $tbl_proveedor_numero
 * @property string $tbl_proveedor_nombre
 *
 * @property Compras[] $tblCompras
 * @property Precio[] $tblPrecios

 */
class Proveedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_proveedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_proveedor_numero', 'tbl_proveedor_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_proveedor' => Yii::t('app', 'Id Proveedor'),
            'tbl_proveedor_numero' => Yii::t('app', 'Tbl Proveedor Numero'),
            'tbl_proveedor_nombre' => Yii::t('app', 'Tbl Proveedor Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblCompras()
    {
        return $this->hasMany(Compras::className(), ['tbl_proveedor_id_proveedor' => 'id_proveedor']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPrecios()
    {
        return $this->hasMany(Precio::className(), ['tbl_proveedor_id_proveedor' => 'id_proveedor']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_proveedor_numero=ucfirst(strtolower(trim($this->tbl_proveedor_numero)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_proveedor')->where(['tbl_proveedor_numero'=>$string])->column() != false ? $this->find()->select('id_proveedor')->where(['tbl_proveedor_numero'=>$string])->column() : false;
	}
	public function cargacsv($carga,$columns,$check){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga);
	$bandera=true;
	$csv=$columns['csv'];
	$bim=1;
	$csvlines=$archivo->proccessitem($csv,$bim);
	$columnsaves=$columns['iteracion'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=$this->find()->where(['tbl_proveedor_numero'=>$csvline[0]])->one()){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
						if($modelo->$columnsave['column']!=$this->nombrecsv($csvline[$columnsave['csv']]) && $this->nombrecsv($csvline[$columnsave['csv']])!=null)
						$modelo->$columnsave['column']=($csvline[$columnsave['csv']]==null) ? '' : $this->nombrecsv($csvline[$columnsave['csv']]);
					}else {
					$id='id'.$this->nombrecsv($this->nombre($columnsave['column']));
					$tabla=$this->nombre($columnsave['column']);
					$csvid=((array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla)) ? array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla) : $$id);
					if($modelo->$columnsave['column']!=$csvid)			
					$modelo->$columnsave['column']=$csvid;
					}
				}
				$modelo->save(false);
				unset($modelo);
			 }else{
			 	if(isset($check['update']) && $check['update']!=true){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
					$insert[]=$this->nombrecsv($csvline[$columnsave['csv']]);
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

	public function cargalista($carga){
		$archivo = Archivo::findOne($carga);
		$col=['tbl_proveedor_numero','tbl_proveedor_nombre'];
		$rs[]=['1','3','4'];
		$rs[]=['1','22','23'];
		$rs[]=['1','41','42'];
		$rs[]=['1','61','62'];
		$columstoreturn=['1','2'];
		foreach ($rs as $r) {
			$csvlines=$archivo->proccessall($r);
			$csvlines=Item::arraybase($csvlines, $columstoreturn);
			foreach ($csvlines as $key=>$csvline) {
				if ($modelo = Proveedor::find()->where(['tbl_proveedor_numero' => $csvline[0]])->one()) {
					if($modelo->tbl_proveedor_nombre!=$this->nombrecsv($csvline[1])){
						$modelo->tbl_proveedor_nombre=$this->nombrecsv($csvline[1]);
						$modelo->save();
						unset($modelo);
					}
				}else{
					if($csvline[0]!=null)	
					$inser[]=[$csvline[0],$this->nombrecsv($csvline[1])];
				}
			unset($csvlines[$key]);
			unset($item);
			}
		}	
		
		if(isset($inser)){
		$inser=array_map("unserialize",array_unique(array_map('serialize',$inser)));	
		$connection = Yii::$app->db;
		$transaction = Yii::$app->db->beginTransaction();
			try{
			$command=$connection->createCommand()->batchInsert($this->tableName(),$col,$inser)->execute();
			$transaction->commit();
			}catch(Exception $e){
				$transaction->rollback();
			}
		}
		return true;				
	}
	protected function nombrecsv($string){
		return ucfirst(strtolower(trim($string)));
	}
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}
	
	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Compras")
  		$relacionmodelo=new Compras(); 
		 if($relacionmodelo=="Precio")
  		$relacionmodelo=new Precio(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
