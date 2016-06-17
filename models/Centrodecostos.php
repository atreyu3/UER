<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_centrodecostos".
 *
		 * @property integer $id_centrodecostos
 			 * @property string $tbl_centrodecostos_nombre
 			 * @property string $tbl_centrodecostos_siglas
 	 *
 * @property Maquina[] $tblMaquinas

 */
class Centrodecostos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_centrodecostos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_centrodecostos_nombre', 'tbl_centrodecostos_siglas'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_centrodecostos' => Yii::t('app', 'Id Centrodecostos'),
            'tbl_centrodecostos_nombre' => Yii::t('app', 'Tbl Centrodecostos Nombre'),
            'tbl_centrodecostos_siglas' => Yii::t('app', 'Tbl Centrodecostos Siglas'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMaquinas()
    {
        return $this->hasMany(Maquina::className(), ['tbl_centrodecostos_id_centrodecostos' => 'id_centrodecostos']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_centrodecostos_nombre=ucfirst(strtolower(trim($this->tbl_centrodecostos_nombre)));
            return true;
    } else {
        return false;
    }
	}

}
