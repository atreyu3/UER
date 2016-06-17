<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_familia".
 *
 * @property integer $id_familia
 * @property string $tbl_familia_nombre
 * @property string $tbl_familia_siglas
 * @property integer $tbl_catfamilia_id_catfamilia
 *
 * @property Catfamilia $tblCatfamiliaIdCatfamilia
 * @property Item[] $tblItems
 * @property Maquina[] $tblMaquinas

 */
class Familia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_familia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_catfamilia_id_catfamilia'], 'required'],
            [['tbl_catfamilia_id_catfamilia'], 'integer'],
            [['tbl_familia_nombre'], 'string', 'max' => 70],
            [['tbl_familia_siglas'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_familia' => Yii::t('app', 'Id Familia'),
            'tbl_familia_nombre' => Yii::t('app', 'Tbl Familia Nombre'),
            'tbl_familia_siglas' => Yii::t('app', 'Tbl Familia Siglas'),
            'tbl_catfamilia_id_catfamilia' => Yii::t('app', 'Tbl Catfamilia Id Catfamilia'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblCatfamiliaIdCatfamilia()
    {
        return $this->hasOne(Catfamilia::className(), ['id_catfamilia' => 'tbl_catfamilia_id_catfamilia']); 
    }
        	/**
     * humberto code  
     */
		public function getTblCatfamiliaList()
    {
          return ArrayHelper::map(Catfamilia::find()->all(),'id_catfamilia','tbl_catfamilia_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItems()
    {
        return $this->hasMany(Item::className(), ['tbl_familia_id_familia' => 'id_familia']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMaquinas()
    {
        return $this->hasMany(Maquina::className(), ['tbl_familia_id_familia' => 'id_familia']); 
    }
    	
}
