<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_marca".
 *
		 * @property integer $id_marca
 			 * @property string $tbl_marca_nombre
 	 *
 * @property Item[] $tblItems
 * @property Maquina[] $tblMaquinas

 */
class Marca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_marca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_marca_nombre'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_marca' => Yii::t('app', 'Id Marca'),
            'tbl_marca_nombre' => Yii::t('app', 'Tbl Marca Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItems()
    {
        return $this->hasMany(Item::className(), ['tbl_marca_id_marca' => 'id_marca']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMaquinas()
    {
        return $this->hasMany(Maquina::className(), ['tbl_marca_id_marca' => 'id_marca']); 
    }
    	
	public function checkname($string){
		return $this->find()->select('id_marca')->where(['tbl_marca_nombre'=>$string])->column() != false ? $this->find()->select('id_marca')->where(['tbl_marca_nombre'=>$string])->column() : false;
	}
	public function cargacsv($carga,$columns,$check){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga);
	$bandera=true;
	$csv=$columns['csv'];
	$bim=1;
	if(isset($check['item']) && $check['item']==true)
		$csvlines=$archivo->proccessitem($csv,$bim);
	else 
		$csvlines=$archivo->proccessall($csv);
	if($check['relations']==true){
		if(!$gr = Grupo::find()->where(['tbl_grupo_nombre' => 'No asignada'])->one()){
			$gr=new Grupo();
			$gr->tbl_grupo_nombre="No asignada";
			$gr->save();
		}
		$idGrupo=$gr->id_grupo;
		unset($grupo);
		$Grupo=ArrayHelper::map(Grupo::find()->all(),'id_grupo','tbl_grupo_nombre');
	}
	$columnsaves=$columns['iteracion'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=Marca::find()->where(['tbl_marca_nombre'=>$csvline[0]])->one()){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
						if($modelo->$columnsave['column']!=$csvline[$columnsave['csv']])
						$modelo->$columnsave['column']=($csvline[$columnsave['csv']]==null) ? '' : $csvline[$columnsave['csv']];
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
			 		if($columnsave['relacion']==false)
					$insert[]=$this->nombrecsv($csvline[$columnsave['csv']]);
					else {
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
	public function cargalista($archivoid,$columncsv,$columndb){
		$archivo = Archivo::findOne($archivoid);
		$csvlines=$archivo->proccessall($columncsv);
		$csvlines=Item::arraybase($csvlines,['1']);
		foreach ($csvlines as $key=>$csvline) {
			if ($modelo = $this->find()->where(['tbl_marca_nombre' => $this->nombrecsv($csvline[0])])->one()) {
					$modelo->tbl_marca_nombre=$this->nombrecsv($csvline[0]);
					$modelo->save();
			}else{	
			$inser[]=[$this->nombrecsv($csvline[0])];
			}
			unset($csvlines[$key]);
		}
		if(isset($inser)){
		array_map("unserialize",array_unique(array_map('serialize',$inser)));	
		$connection = Yii::$app->db;
		$transaction = Yii::$app->db->beginTransaction();
			try{
			$command=$connection->createCommand()->batchInsert($this->tableName(),$columndb,$inser)->execute();
			$transaction->commit();
			}catch(Exception $e){
				$transaction->rollback();
			}
		}
		return $csvlines;
	}
	protected function nombrecsv($string){
		return ucfirst(strtolower(trim($string)));
	}
	protected function nombre($string){
		$string=explode("_", $string);
		return $string[1];
	}
	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Item")
  		$relacionmodelo=new Item(); 
		 if($relacionmodelo=="Maquina")
  		$relacionmodelo=new Maquina(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
