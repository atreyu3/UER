<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_categorialinea".
 *
		 * @property integer $id_categorialinea
 			 * @property string $tbl_categorialinea_nombre
 	 *
 * @property LineaHasTblMaquina[] $tblLineaHasTblMaquinas

 */
class Categorialinea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_categorialinea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_categorialinea_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categorialinea' => Yii::t('app', 'Id Categorialinea'),
            'tbl_categorialinea_nombre' => Yii::t('app', 'Tbl Categorialinea Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblLineaHasTblMaquinas()
    {
        return $this->hasMany(LineaHasTblMaquina::className(), ['tbl_categorialinea_id_categorialinea' => 'id_categorialinea']); 
    }

}
