<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_categoriauser".
 *
		 * @property integer $id_categoriauser
 			 * @property string $tbl_categoriauser_nombre
 			 * @property string $tbl_categoriauser_permiso
 	 *
 * @property User[] $tblUsers

 */
class Categoriauser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_categoriauser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_categoriauser_nombre', 'tbl_categoriauser_permiso'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoriauser' => Yii::t('app', 'Id Categoriauser'),
            'tbl_categoriauser_nombre' => Yii::t('app', 'Tbl Categoriauser Nombre'),
            'tbl_categoriauser_permiso' => Yii::t('app', 'Tbl Categoriauser Permiso'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUsers()
    {
        return $this->hasMany(User::className(), ['tbl_categoriauser_id_categoriauser' => 'id_categoriauser']); 
    }
	
}
