<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_grupo".
 *
		 * @property integer $id_grupo
 			 * @property string $tbl_grupo_nombre
 	 *
 * @property GrupoHasTblUser[] $tblGrupoHasTblUsers
 * @property User[] $tblUsers
 * @property Linea[] $tblLineas

 */
class Grupo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_grupo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_grupo_nombre'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_grupo' => Yii::t('app', 'Id Grupo'),
            'tbl_grupo_nombre' => Yii::t('app', 'Tbl Grupo Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblGrupoHasTblUsers()
    {
        return $this->hasMany(GrupoHasTblUser::className(), ['tbl_grupo_id' => 'id_grupo']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUsers()
    {
        return $this->hasMany(User::className(), ['id_user' => 'tbl_user_id'])->viaTable('tbl_grupo_has_tbl_user', ['tbl_grupo_id' => 'id_grupo']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblLineas()
    {
        return $this->hasMany(Linea::className(), ['tbl_grupo_id_grupo' => 'id_grupo']); 
    }
   	
	    	/**
     * humberto code  
     */
		public function getTblUsuarioList()
    {
			$jefe_user=\app\models\Categoriauser::find()->where(['tbl_categoriauser_nombre'=>'Jefe de mecanico'])->one();
          return ArrayHelper::map(User::find()->where(['tbl_categoriauser_id_categoriauser'=>$jefe_user->id_categoriauser])->all(),'id_user','tbl_user_nombre'); 
    }	
	    	/**
     * humberto code  
     */
		public function getTblGrupoList()
    {
          return ArrayHelper::map($this->find()->all(),'id_grupo','tbl_grupo_nombre'); 
    }	
	
	
}
