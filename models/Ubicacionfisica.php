<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_ubicacionfisica".
 *
		 * @property integer $id_ubicacionfisica
 			 * @property string $tbl_ubicacionfisica_nombre
 			 * @property integer $tbl_ubicacionfisica_planta
 	 *
 * @property LineaHasTblMaquina[] $tblLineaHasTblMaquinas

 */
class Ubicacionfisica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_ubicacionfisica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ubicacionfisica', 'tbl_ubicacionfisica_planta'], 'integer'],
            [['tbl_ubicacionfisica_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ubicacionfisica' => Yii::t('app', 'Id Ubicacionfisica'),
            'tbl_ubicacionfisica_nombre' => Yii::t('app', 'Tbl Ubicacionfisica Nombre'),
            'tbl_ubicacionfisica_planta' => Yii::t('app', 'Tbl Ubicacionfisica Planta'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblLineaHasTblMaquinas()
    {
        return $this->hasMany(LineaHasTblMaquina::className(), ['tbl_ubicacionfisica_id_ubicacionfisica' => 'id_ubicacionfisica']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_ubicacionfisica_nombre=ucfirst(strtolower(trim($this->tbl_ubicacionfisica_nombre)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_ubicacionfisica')->where(['tbl_ubicacionfisica_nombre'=>$string])->column() != false ? $this->find()->select('id_ubicacionfisica')->where(['tbl_ubicacionfisica_nombre'=>$string])->column() : false;
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
		 if($modelo=Ubicacionfisica::find()->where(['tbl_ubicacionfisica_nombre'=>$csvline[0]])->one()){
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
					$insert[]=$csvline[$columnsave['csv']];
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
	
	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="LineaHasTblMaquina")
  		$relacionmodelo=new LineaHasTblMaquina(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
