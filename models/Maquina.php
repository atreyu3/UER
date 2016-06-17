<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_maquina".
 *
 * @property integer $id_maquina
 * @property string $tbl_maquina_bim
 * @property string $tbl_maquina_codigo
 * @property string $tbl_maquina_modelo
 * @property string $tbl_maquina_serie
 * @property string $tbl_maquina_descripcion_bim
 * @property string $tbl_maquina_descripcion
 * @property integer $tbl_marca_id_marca
 * @property integer $tbl_familia_id_familia
 * @property string $tbl_maquina_comentario
 * @property integer $tbl_maquina_activos
 * @property integer $tbl_status_id_status
 * @property integer $tbl_linea_id_linea
 * @property integer $tbl_ubicacionfisica_id_ubicacionfisica
 * @property integer $tbl_centrodecostos_id_centrodecostos
 *
 * @property Transaccionrefaccion[] $modTransaccionrefaccions
 * @property Historialmaquina[] $tblHistorialmaquinas
 * @property Marca $tblMarcaIdMarca
 * @property Familia $tblFamiliaIdFamilia
 * @property Status $tblStatusIdStatus
 * @property Linea $tblLineaIdLinea
 * @property Ubicacionfisica $tblUbicacionfisicaIdUbicacionfisica
 * @property Centrodecostos $tblCentrodecostosIdCentrodecostos

 */
class Maquina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_maquina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_maquina_descripcion'], 'string'],
            [['tbl_marca_id_marca', 'tbl_familia_id_familia', 'tbl_status_id_status', 'tbl_linea_id_linea', 'tbl_ubicacionfisica_id_ubicacionfisica', 'tbl_centrodecostos_id_centrodecostos'], 'required'],
            [['tbl_marca_id_marca', 'tbl_familia_id_familia', 'tbl_maquina_activos', 'tbl_status_id_status', 'tbl_linea_id_linea', 'tbl_ubicacionfisica_id_ubicacionfisica', 'tbl_centrodecostos_id_centrodecostos'], 'integer'],
            [['tbl_maquina_bim'], 'string', 'max' => 15],
            [['tbl_maquina_codigo'], 'string', 'max' => 14],
            [['tbl_maquina_modelo', 'tbl_maquina_serie', 'tbl_maquina_descripcion_bim', 'tbl_maquina_comentario'], 'string', 'max' => 45],
            [['tbl_maquina_bim'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_maquina' => Yii::t('app', 'Id Maquina'),
            'tbl_maquina_bim' => Yii::t('app', 'Tbl Maquina Bim'),
            'tbl_maquina_codigo' => Yii::t('app', 'Tbl Maquina Codigo'),
            'tbl_maquina_modelo' => Yii::t('app', 'Tbl Maquina Modelo'),
            'tbl_maquina_serie' => Yii::t('app', 'Tbl Maquina Serie'),
            'tbl_maquina_descripcion_bim' => Yii::t('app', 'Tbl Maquina Descripcion Bim'),
            'tbl_maquina_descripcion' => Yii::t('app', 'Tbl Maquina Descripcion'),
            'tbl_marca_id_marca' => Yii::t('app', 'Tbl Marca Id Marca'),
            'tbl_familia_id_familia' => Yii::t('app', 'Tbl Familia Id Familia'),
            'tbl_maquina_comentario' => Yii::t('app', 'Tbl Maquina Comentario'),
            'tbl_maquina_activos' => Yii::t('app', 'Tbl Maquina Activos'),
            'tbl_status_id_status' => Yii::t('app', 'Tbl Status Id Status'),
            'tbl_linea_id_linea' => Yii::t('app', 'Tbl Linea Id Linea'),
            'tbl_ubicacionfisica_id_ubicacionfisica' => Yii::t('app', 'Tbl Ubicacionfisica Id Ubicacionfisica'),
            'tbl_centrodecostos_id_centrodecostos' => Yii::t('app', 'Tbl Centrodecostos Id Centrodecostos'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModTransaccionrefaccions()
    {
        return $this->hasMany(Transaccionrefaccion::className(), ['tbl_maquina_id_maquina' => 'id_maquina']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblHistorialmaquinas()
    {
        return $this->hasMany(Historialmaquina::className(), ['tbl_maquina_id_maquina' => 'id_maquina']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMarcaIdMarca()
    {
        return $this->hasOne(Marca::className(), ['id_marca' => 'tbl_marca_id_marca']); 
    }
        	/**
     * humberto code  
     */
		public function getTblMarcaList()
    {
          return ArrayHelper::map(Marca::find()->all(),'id_marca','tbl_marca_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblFamiliaIdFamilia()
    {
        return $this->hasOne(Familia::className(), ['id_familia' => 'tbl_familia_id_familia']); 
    }
        	/**
     * humberto code  
     */
		public function getTblFamiliaList()
    {
          return ArrayHelper::map(Familia::find()->all(),'id_familia','tbl_familia_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblStatusIdStatus()
    {
        return $this->hasOne(Status::className(), ['id_status' => 'tbl_status_id_status']); 
    }
        	/**
     * humberto code  
     */
		public function getTblStatusList()
    {
          return ArrayHelper::map(Status::find()->all(),'id_status','tbl_status_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblLineaIdLinea()
    {
        return $this->hasOne(Linea::className(), ['id_linea' => 'tbl_linea_id_linea']); 
    }
        	/**
     * humberto code  
     */
		public function getTblLineaList()
    {
          return ArrayHelper::map(Linea::find()->all(),'id_linea','tbl_linea_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUbicacionfisicaIdUbicacionfisica()
    {
        return $this->hasOne(Ubicacionfisica::className(), ['id_ubicacionfisica' => 'tbl_ubicacionfisica_id_ubicacionfisica']); 
    }
        	/**
     * humberto code  
     */
		public function getTblUbicacionfisicaList()
    {
          return ArrayHelper::map(Ubicacionfisica::find()->all(),'id_ubicacionfisica','tbl_ubicacionfisica_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblCentrodecostosIdCentrodecostos()
    {
        return $this->hasOne(Centrodecostos::className(), ['id_centrodecostos' => 'tbl_centrodecostos_id_centrodecostos']); 
    }
        	/**
     * humberto code  
     */
		public function getTblCentrodecostosList()
    {
          return ArrayHelper::map(Centrodecostos::find()->all(),'id_centrodecostos','tbl_centrodecostos_nombre'); 
    }	
				public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_maquina_bim=ucfirst(strtolower(trim($this->tbl_maquina_bim)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_maquina')->where(['tbl_maquina_bim'=>$string])->column() != false ? $this->find()->select('id_maquina')->where(['tbl_maquina_bim'=>$string])->column() : false;
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
	if($check['relations']==true){
		if(!$fam=Familia::find()->where(['tbl_familia_nombre'=>'No asignada'])->one()){
			$catfam= new Catfamilia();
			$catfam->tbl_catfamilia_nombre="No asignada";
			$catfam->save();	
			$fam= new Familia();
			$fam->tbl_familia_nombre='No asignada';
			$fam->tbl_catfamilia_id_catfamilia= $catfam->id_catfamilia;
			$fam->save();
			
		}
		$idFamilia=$fam->id_familia;
		unset($fam);
		if(!$sta =Status::find()->where(['tbl_status_nombre' => 'Pendiente'])->one()){
			$sta=new Grupo();
			$sta->tbl_grupo_nombre="Pendiente";
			$sta->save();
		}
		$idStatus=$sta->id_status;
		unset($sta);
		if(!$lin=Linea::find()->where(['tbl_linea_nombre'=>'No asignada'])->one()){
			$lin= new Linea();
			$lin->tbl_linea_nombre='No asignada';
			$lin->save();
		}
			$idLinea=$lin->id_linea;
			unset($lin);
		if(!$mar=Marca::find()->where(['tbl_marca_nombre'=>'No asignada'])->one()){
			$mar= new Marca();
			$mar->tbl_marca_nombre='No asignada';
			$mar->save();
		}
			$idMarca=$mar->id_marca;
			unset($mar);
		if(!$centr=Centrodecostos::find()->where(['tbl_centrodecostos_nombre'=>'No asignada'])->one()){
			$centr= new Centrodecostos();
			$centr->tbl_centrodecostos_nombre='No asignada';
			$centr->save();
		}
			$idCentrodecosto=$centr->id_centrodecostos;
			unset($centr);
		if(!$ubi=Ubicacionfisica::find()->where(['tbl_ubicacionfisica_nombre'=>'No asignada'])->one()){
			$ubi= new Ubicacionfisica();
			$ubi->tbl_ubicacionfisica_nombre='No asignada';
			$ubi->save();
		}
			$idUbicacionfisica=$ubi->id_ubicacionfisica;
			unset($ubi);
		$Familia=ArrayHelper::map(Familia::find()->all(),'id_familia','tbl_familia_nombre');
		$Status=ArrayHelper::map(Status::find()->all(),'id_status','tbl_status_nombre');
		$Marca=ArrayHelper::map(Marca::find()->all(),'id_marca','tbl_marca_nombre');
		$Linea=ArrayHelper::map(Linea::find()->all(),'id_linea','tbl_linea_nombre');
		$Centrodecostos=ArrayHelper::map(Centrodecostos::find()->all(),'id_centrodecostos','tbl_centrodecostos_nombre');
		$Ubicacionfisica=ArrayHelper::map(Ubicacionfisica::find()->all(),'id_ubicacionfisica','tbl_ubicacionfisica_nombre');
	}
	$columnsaves=$columns['iteracion'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=Maquina::find()->where(['tbl_maquina_bim'=>$csvline[0]])->one()){
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
			 		if($columnsave['relacion']==false){
			 			$au=strtolower(trim($csvline[$columnsave['csv']]));
						if($au==="por codificar")
						$insert[]=uniqid();
						else
						$insert[]=strtolower(trim($csvline[$columnsave['csv']]));
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
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Transaccionrefaccion")
  		$relacionmodelo=new Transaccionrefaccion(); 
		 if($relacionmodelo=="Historialmaquina")
  		$relacionmodelo=new Historialmaquina(); 
		 if($relacionmodelo=="Marca")
  		$relacionmodelo=new Marca(); 
		 if($relacionmodelo=="Familia")
  		$relacionmodelo=new Familia(); 
		 if($relacionmodelo=="Status")
  		$relacionmodelo=new Status(); 
		 if($relacionmodelo=="Linea")
  		$relacionmodelo=new Linea(); 
		 if($relacionmodelo=="Ubicacionfisica")
  		$relacionmodelo=new Ubicacionfisica(); 
		 if($relacionmodelo=="Centrodecostos")
  		$relacionmodelo=new Centrodecostos(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
