<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_historialmaquina".
 *
		 * @property integer $id_historialmaquina
 			 * @property string $tbl_historialmaquina_antes
 			 * @property string $tbl_historialmaquina_despues
 			 * @property string $tbl_historialmaquina_cambio
 			 * @property string $tbl_historialmaquina_date
 			 * @property string $tbl_historialmaquina_usuario
 			 * @property integer $tbl_maquina_id_maquina
 	 *
 * @property Maquina $tblMaquinaIdMaquina

 */
class Historialmaquina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_historialmaquina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historialmaquina', 'tbl_maquina_id_maquina'], 'required'],
            [['id_historialmaquina', 'tbl_maquina_id_maquina'], 'integer'],
            [['tbl_historialmaquina_date'], 'safe'],
            [['tbl_historialmaquina_antes', 'tbl_historialmaquina_despues', 'tbl_historialmaquina_cambio', 'tbl_historialmaquina_usuario'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_historialmaquina' => Yii::t('app', 'Id Historialmaquina'),
            'tbl_historialmaquina_antes' => Yii::t('app', 'Tbl Historialmaquina Antes'),
            'tbl_historialmaquina_despues' => Yii::t('app', 'Tbl Historialmaquina Despues'),
            'tbl_historialmaquina_cambio' => Yii::t('app', 'Tbl Historialmaquina Cambio'),
            'tbl_historialmaquina_date' => Yii::t('app', 'Tbl Historialmaquina Date'),
            'tbl_historialmaquina_usuario' => Yii::t('app', 'Tbl Historialmaquina Usuario'),
            'tbl_maquina_id_maquina' => Yii::t('app', 'Tbl Maquina Id Maquina'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMaquinaIdMaquina()
    {
        return $this->hasOne(Maquina::className(), ['id_maquina' => 'tbl_maquina_id_maquina']); 
    }
        	/**
     * humberto code  
     */
		public function getTblMaquinaList()
    {
          return ArrayHelper::map(Maquina::find()->all(),'id_maquina','tbl_maquina_bim'); 
    }	
				public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_historialmaquina_antes=ucfirst(strtolower(trim($this->tbl_historialmaquina_antes)));
            return true;
    } else {
        return false;
    }
	}

}
