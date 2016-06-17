<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_catfamilia".
 *
 * @property integer $id_catfamilia
 * @property string $tbl_catfamilia_nombre
 *
 * @property Familia[] $tblFamilias

 */
class Catfamilia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_catfamilia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_catfamilia_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_catfamilia' => Yii::t('app', 'Id Catfamilia'),
            'tbl_catfamilia_nombre' => Yii::t('app', 'Tbl Catfamilia Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblFamilias()
    {
        return $this->hasMany(Familia::className(), ['tbl_catfamilia_id_catfamilia' => 'id_catfamilia']); 
    }
    
}
