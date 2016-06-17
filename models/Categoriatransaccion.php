<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_categoriatransaccion".
 *
		 * @property integer $id_categoriatransaccion
 			 * @property string $tbl_categoriatransaccion_nombre
 	 *
 * @property Transaccionrefaccion[] $modTransaccionrefaccions

 */
class Categoriatransaccion extends \yii\db\ActiveRecord
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_categoriatransaccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_categoriatransaccion_nombre'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoriatransaccion' => Yii::t('app', 'Id Categoriatransaccion'),
            'tbl_categoriatransaccion_nombre' => Yii::t('app', 'Tbl Categoriatransaccion Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModTransaccionrefaccions()
    {
        return $this->hasMany(Transaccionrefaccion::className(), ['tbl_categoriatransaccion_id_categoriatransaccion' => 'id_categoriatransaccion']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_categoriatransaccion_nombre=ucfirst(strtolower(trim($this->tbl_categoriatransaccion_nombre)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_categoriatransaccion')->where(['tbl_categoriatransaccion_nombre'=>$string])->column() != false ? $this->find()->select('id_categoriatransaccion')->where(['tbl_categoriatransaccion_nombre'=>$string])->column() : false;
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
