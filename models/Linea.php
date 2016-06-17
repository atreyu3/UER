<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_linea".
 *
		 * @property integer $id_linea
 			 * @property string $tbl_linea_nombre
 			 * @property string $tbl_linea_siglas
 			 * @property integer $tbl_grupo_id_grupo
 	 *
 * @property Grupo $tblGrupoIdGrupo
 * @property Maquina[] $tblMaquinas

 */
class Linea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_linea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_grupo_id_grupo'], 'required'],
            [['tbl_grupo_id_grupo'], 'integer'],
            [['tbl_linea_nombre'], 'string', 'max' => 20],
            [['tbl_linea_siglas'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_linea' => Yii::t('app', 'Id Linea'),
            'tbl_linea_nombre' => Yii::t('app', 'Tbl Linea Nombre'),
            'tbl_linea_siglas' => Yii::t('app', 'Tbl Linea Siglas'),
            'tbl_grupo_id_grupo' => Yii::t('app', 'Tbl Grupo Id Grupo'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblGrupoIdGrupo()
    {
        return $this->hasOne(Grupo::className(), ['id_grupo' => 'tbl_grupo_id_grupo']); 
    }
        	/**
     * humberto code  
     */
		public function getTblGrupoList()
    {
          return ArrayHelper::map(Grupo::find()->all(),'id_grupo','tbl_grupo_nombre'); 
    }
	    	/**
     * humberto code  
     */
	public function getTblLineaList()
    {
          return ArrayHelper::map($this->find()->all(),'id_linea','tbl_linea_nombre'); 
    }		
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMaquinas()
    {
        return $this->hasMany(Maquina::className(), ['tbl_linea_id_linea' => 'id_linea']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_linea_nombre=ucfirst(strtolower(trim($this->tbl_linea_nombre)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_linea')->where(['tbl_linea_nombre'=>$string])->column() != false ? $this->find()->select('id_linea')->where(['tbl_linea_nombre'=>$string])->column() : false;
	}
	public function cargacsv($carga,$columns,$check){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga);
	$bandera=true;
	$csv=$columns['csv'];
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
		if(!$mar=Marca::find()->where(['tbl_marca_nombre'=>'No asignada'])->one()){
			$mar= new Marca();
			$mar->tbl_marca_nombre='No asignada';
			$mar->save();
		}
			$idMarca=$mar->id_marca;
			unset($mar);
		$Marca=ArrayHelper::map(Marca::find()->all(),'id_marca','tbl_marca_nombre');
	}
	$columnsaves=$columns['iteracion'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=Linea::find()->where(['tbl_linea_nombre'=>$csvline[0]])->one()){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
						if($modelo->$columnsave['column']!=$csvline[$columnsave['csv']])
						$modelo->$columnsave['column']=($csvline[$columnsave['csv']]==null) ? '' : $csvline[$columnsave['csv']];
					}else {
					$id='id'.Modelcustomfunction::nombrecsv(Modelcustomfunction::nombre($columnsave['column']));
					$tabla=Modelcustomfunction::nombre($columnsave['column']);
					$csvid=((array_search(Modelcustomfunction::nombrecsv($csvline[$columnsave['csv']]),$$tabla)) ? array_search($this->nombrecsv($csvline[$columnsave['csv']]),$$tabla) : $$id);
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
					$insert[]=Modelcustomfunction::nombrecsv($csvline[$columnsave['csv']]);
					else {
					$id='id'.Modelcustomfunction::nombrecsv(Modelcustomfunction::nombre($columnsave['column']));
					$tabla=Modelcustomfunction::nombre($columnsave['column']);	
					$insert[]=((array_search(Modelcustomfunction::nombrecsv($csvline[$columnsave['csv']]),$$tabla)) ? array_search(Modelcustomfunction::nombrecsv($csvline[$columnsave['csv']]),$$tabla) : $$id);
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
		 if($relacionmodelo=="Grupo")
  		$relacionmodelo=new Grupo(); 
		 if($relacionmodelo=="Maquina")
  		$relacionmodelo=new Maquina(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
