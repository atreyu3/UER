<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_usorefaccion".
 *
		 * @property integer $id_usorefaccion
 			 * @property string $tbl_usorefaccion_nombre
 			 * @property integer $tbl_usorefaccion_orden
 			 * @property integer $tbl_usorefaccion_visible
 * 	 			@property integer $tbl_usorefaccion_color
 	 *
 * @property Transaccionrefaccion[] $modTransaccionrefaccions

 */
class Usorefaccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_usorefaccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['tbl_usorefaccion_visible'],'boolean'],
            [['tbl_usorefaccion_orden'], 'integer'],
            [['tbl_usorefaccion_nombre'], 'string', 'max' => 45],
			[['tbl_usorefaccion_color'], 'string', 'max' => 10]	            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usorefaccion' => Yii::t('app', 'Id Usorefaccion'),
            'tbl_usorefaccion_nombre' => Yii::t('app', 'Tbl Usorefaccion Nombre'),
            'tbl_usorefaccion_orden' => Yii::t('app', 'Tbl Usorefaccion Orden'),
            'tbl_usorefaccion_visible' => Yii::t('app', 'Tbl Usorefaccion Visible'),
             'tbl_usorefaccion_color' => Yii::t('app', 'Tbl Usorefaccion Color'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModTransaccionrefaccions()
    {
        return $this->hasMany(Transaccionrefaccion::className(), ['tbl_usorefaccion_id_usorefaccion' => 'id_usorefaccion']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_usorefaccion_nombre=ucfirst(strtolower(trim($this->tbl_usorefaccion_nombre)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_usorefaccion')->where(['tbl_usorefaccion_nombre'=>$string])->column() != false ? $this->find()->select('id_usorefaccion')->where(['tbl_usorefaccion_nombre'=>$string])->column() : false;
	}
	public function cargacsv($carga){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga['id']);
	$bandera=true;
	$csvcolumn=0;
	foreach ($carga['modelcsv'] as $envia=>$key) {
		$a[$envia]=$key;	
		}
	foreach ($archivo->proccessall() as $csvline) {
		$row=0;
		$modelo= new Usorefaccion();
		$bandera=true;
		foreach ($this->attributes() as $k=>$key) {
			if($row==0)$modelnombre=$this->nombre($key);
			if($row>0){
				if($this->nombre($key)==$modelnombre){
				$modelo->$key=$csvline[$a[$key]];
				}else{
				if($rela=$this->checkrelation($key,$csvline[$a[$key]]))
				$modelo->$key=$rela[0];
				else{
				$bandera=false;
				$b[$key][$csvcolumn]=$csvline[$a[$key]];
				}	
				}
			}
			$row++;
		}
			if($bandera==true){
			$csvcolumn++;
			$modelo->save();
			}
		}
		$b['columnasadd']=$csvcolumn;
	 return $b;
	 }
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Transaccionrefaccion")
  		$relacionmodelo=new Transaccionrefaccion(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
