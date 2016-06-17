<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_status".
 *
 * @property integer $id_status
 * @property string $tbl_status_nombre
 *
 * @property Maquina[] $tblMaquinas

 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_status'], 'integer'],
            [['tbl_status_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_status' => Yii::t('app', 'Id Status'),
            'tbl_status_nombre' => Yii::t('app', 'Tbl Status Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMaquinas()
    {
        return $this->hasMany(Maquina::className(), ['tbl_status_id_status' => 'id_status']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_status_nombre=ucfirst(strtolower(trim($this->tbl_status_nombre)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_status')->where(['tbl_status_nombre'=>$string])->column() != false ? $this->find()->select('id_status')->where(['tbl_status_nombre'=>$string])->column() : false;
	}
	 protected function nombrecsv($string){
		return ucfirst(strtolower(trim($string)));
	}
	
	public function cargacsv($carga,$columns,$check){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga);
	$bandera=true;
	$csv=$columns['csv'];
	$csvlines=$archivo->proccessall($csv);
	$columnsaves=$columns['iteracion'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=Status::find()->where(['tbl_status_nombre'=>$csvline[0]])->one()){
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
					if($csvline[$columnsave['csv']]==false){	
					$id='id'.$this->nombrecsv($this->nombre($columnsave['column']));
					$tabla=$this->nombre($columnsave['column']);	
					$insert[]=((array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla)) ? array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla) : $$id);
					}else{
					$id='id'.$this->nombrecsv($this->nombre($columnsave['column']));	
					$insert[]=${$id};	
					}
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
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Maquina")
  		$relacionmodelo=new Maquina(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
