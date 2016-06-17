<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_categoriaitem".
 *
		 * @property integer $id_categoriaitem
 			 * @property string $tbl_categoriaitem_nombre
 			 * @property string $tbl_categoriaitem_nomenclatura
 	 *
 * @property Item[] $tblItems

 */
class Categoriaitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_categoriaitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_categoriaitem_nombre', 'tbl_categoriaitem_nomenclatura'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoriaitem' => Yii::t('app', 'Id Categoriaitem'),
            'tbl_categoriaitem_nombre' => Yii::t('app', 'Tbl Categoriaitem Nombre'),
            'tbl_categoriaitem_nomenclatura' => Yii::t('app', 'Tbl Categoriaitem Nomenclatura'),
        ];
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItems()
    {
        return $this->hasMany(Item::className(), ['tbl_categoriaitem_id_categoriaitem' => 'id_categoriaitem']); 
    }
	
	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_categoriaitem_nombre=ucfirst(strtolower(trim($this->tbl_categoriaitem_nombre)));
            return true;
    } else {
        return false;
    }
	}
    
}
