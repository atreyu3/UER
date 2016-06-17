<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/


/**
 * This is the model class for table "mod_transaccionrefaccion".
 *
 * @property integer $id_transaccionrefaccion
 * @property string $mod_transaccionrefaccion_date
 * @property string $mod_transaccionrefaccion_piezas
 * @property integer $tbl_maquina_id_maquina
 * @property integer $tbl_item_id_item
 * @property integer $tbl_user_id_user
 * @property integer $tbl_usorefaccion_id_usorefaccion
 * @property integer $mod_transaccionrefaccion_louder
 * @property integer $mod_transaccionrefaccion_confirmado
 * @property string  $mod_transaccionrefaccion_tagid
 * @property integer $mod_transaccionrefaccion_devolucion
 * 
 * @property Item $tblItemIdItem
 * @property Maquina $tblMaquinaIdMaquina
 * @property User $tblUserIdUser
 * @property Usorefaccion $tblUsorefaccionIdUsorefaccion
 * @property Devoluciones[] $tblDevoluciones
 */
class Transaccionrefaccion extends \yii\db\ActiveRecord
{
	
	public $sumacount;
	public $id_lineaprovisional;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mod_transaccionrefaccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mod_transaccionrefaccion_date'], 'safe'],
            [['tbl_maquina_id_maquina', 'tbl_item_id_item', 'tbl_user_id_user', 'tbl_usorefaccion_id_usorefaccion'], 'required'],
            [['mod_transaccionrefaccion_louder','mod_transaccionrefaccion_confirmado','tbl_maquina_id_maquina', 'tbl_item_id_item', 'tbl_user_id_user', 'tbl_usorefaccion_id_usorefaccion','mod_transaccionrefaccion_devolucion'], 'integer'],
            [['mod_transaccionrefaccion_piezas','mod_transaccionrefaccion_tagid'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_transaccionrefaccion' => Yii::t('app', 'Id Transaccionrefaccion'),
            'mod_transaccionrefaccion_date' => Yii::t('app', 'Mod Transaccionrefaccion Date'),
            'mod_transaccionrefaccion_piezas' => Yii::t('app', 'Mod Transaccionrefaccion Piezas'),
            'tbl_maquina_id_maquina' => Yii::t('app', 'Tbl Maquina Id Maquina'),
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
            'tbl_user_id_user' => Yii::t('app', 'Tbl User Id User'),
            'tbl_usorefaccion_id_usorefaccion' => Yii::t('app', 'Tbl Usorefaccion Id Usorefaccion'),
            'mod_transaccionrefaccion_louder'=>Yii::t('app', 'Mod Transaccionrefaccion Louder'),
            'mod_transaccionrefaccion_confirmado'=>Yii::t('app', 'Mod Transaccionrefaccion Confirmado'),
            'mod_transaccionrefaccion_tagid'=>Yii::t('app', 'Mod Transaccionrefaccion Tag id'),
            'id_lineaprovisional'=>Yii::t('app','Linea'),
            'sumacount'=>Yii::t('app','Cantidad'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getTblDevoluciones()
    {
        return $this->hasMany(Devoluciones::className(), ['mod_transaccionrefaccion_id_transaccionrefaccion' => 'id_transaccionrefaccion']); 
    }
     /**
     * humberto code  
     */
		public function getTblItemList()
    {
          return ArrayHelper::map(Item::find()->all(),'id_item','tbl_item_bim'); 
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
          return ArrayHelper::map(Maquina::find()->all(),'id_maquina','tbl_maquina_descripcion'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUserIdUser()
    {
        return $this->hasOne(User::className(), ['id_user' => 'tbl_user_id_user']); 
    }
        	/**
     * humberto code  
     */
		public function getTblUserList()
    {
          return ArrayHelper::map(User::find()->all(),'id_user','tbl_user_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUsorefaccionIdUsorefaccion()
    {
        return $this->hasOne(Usorefaccion::className(), ['id_usorefaccion' => 'tbl_usorefaccion_id_usorefaccion']); 
    }
        	/**
     * humberto code  
     */
		public function getTblUsorefaccionList()
    {
          return Usorefaccion::find()->where(['tbl_usorefaccion_visible'=>1])->orderBy('tbl_usorefaccion_orden')->all(); 
    }
	
	   	/**
     * humberto code  
     */
	public function getTblUsorefaccionList2()
    {
          return ArrayHelper::map(Usorefaccion::find()->all(),'id_usorefaccion','tbl_usorefaccion_nombre'); 
    }	
	   	/**
     * humberto code  
     */
	public function getTblLineaList()
    {
          return ArrayHelper::map(Linea::find()->all(),'id_linea','tbl_linea_nombre'); 
    }
	   	/**
     * humberto code  
     */
	public function getTblCatlineaList()
    {
          return ArrayHelper::map(Categorialinea::find()->all(),'id_categorialinea','tbl_categorialinea_nombre'); 
    }
   	/**
     * humberto code  
     */
	public function Maquinaall($id)
    {
          return ArrayHelper::map(Maquina::find()->where(['tbl_linea_id_linea'=>$id])->all(),'id_maquina','tbl_maquina_descripcion'); 
    }
	
	public function Louderupdate($transaccion){
		$model = new Transaccionrefaccion();
		$model=$model->findOne($transaccion);
		$model->mod_transaccionrefaccion_louder=1;                                                                                          
		$model->save();		
	}
	
	public function Tagunico($tag){
		if(!Transaccionrefaccion::find()->where(['mod_transaccionrefaccion_tagid'=>$tag,'mod_transaccionrefaccion_devolucion'=>0])->one())
		return true;
		else 
		return false;
	}
}
