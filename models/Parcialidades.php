<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_parcialidades".
 *
		 * @property integer $id_parcialidades
 			 * @property integer $tbl_parcialidades_suma
 			 * @property integer $tbl_item_id_item
 	 *
 * @property Item $tblItemIdItem

 */
class Parcialidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_parcialidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parcialidades', 'tbl_item_id_item'], 'required'],
            [['id_parcialidades', 'tbl_parcialidades_suma', 'tbl_item_id_item'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_parcialidades' => Yii::t('app', 'Id Parcialidades'),
            'tbl_parcialidades_suma' => Yii::t('app', 'Tbl Parcialidades Suma'),
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
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
				public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_parcialidades_suma=ucfirst(strtolower(trim($this->tbl_parcialidades_suma)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_parcialidades')->where(['tbl_parcialidades_suma'=>$string])->column() != false ? $this->find()->select('id_parcialidades')->where(['tbl_parcialidades_suma'=>$string])->column() : false;
	}
	
	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Item")
  		$relacionmodelo=new Item(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
