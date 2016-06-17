<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_compras".
 *
		 * @property integer $id_compras
 			 * @property string $tbl_compras_entrega
 			 * @property integer $tbl_proveedor_id_proveedor
 			 * @property string $tbl_compras_fechapedido
 			 * @property string $tbl_compras_fechaentrega
 			 * @property string $tbl_compras_factura
 			 * @property integer $tbl_user_id_user
 			 * @property integer $tbl_compras_impresion
 	 *
 * @property Proveedor $tblProveedorIdProveedor
 * @property User $tblUserIdUser
 * @property ComprasHasTblItem[] $tblComprasHasTblItems
 * @property Item[] $tblItemIdItems

 */
class Compras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_compras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_compras', 'tbl_proveedor_id_proveedor', 'tbl_user_id_user'], 'required'],
            [['id_compras', 'tbl_proveedor_id_proveedor', 'tbl_user_id_user', 'tbl_compras_impresion'], 'integer'],
            [['tbl_compras_fechapedido', 'tbl_compras_fechaentrega'], 'safe'],
            [['tbl_compras_entrega', 'tbl_compras_factura'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_compras' => Yii::t('app', 'Id Compras'),
            'tbl_compras_entrega' => Yii::t('app', 'Tbl Compras Entrega'),
            'tbl_proveedor_id_proveedor' => Yii::t('app', 'Tbl Proveedor Id Proveedor'),
            'tbl_compras_fechapedido' => Yii::t('app', 'Tbl Compras Fechapedido'),
            'tbl_compras_fechaentrega' => Yii::t('app', 'Tbl Compras Fechaentrega'),
            'tbl_compras_factura' => Yii::t('app', 'Tbl Compras Factura'),
            'tbl_user_id_user' => Yii::t('app', 'Tbl User Id User'),
            'tbl_compras_impresion' => Yii::t('app', 'Tbl Compras Impresion'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblProveedorIdProveedor()
    {
        return $this->hasOne(Proveedor::className(), ['id_proveedor' => 'tbl_proveedor_id_proveedor']); 
    }
        	/**
     * humberto code  
     */
		public function getTblProveedorList()
    {
          return ArrayHelper::map(Proveedor::find()->all(),'id_proveedor','tbl_proveedor_nombre'); 
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
    public function getTblComprasHasTblItems()
    {
        return $this->hasMany(ComprasHasTblItem::className(), ['tbl_compras_id_compras' => 'id_compras']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemIdItems()
    {
        return $this->hasMany(Item::className(), ['id_item' => 'tbl_item_id_item'])->viaTable('tbl_compras_has_tbl_item', ['tbl_compras_id_compras' => 'id_compras']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_compras_entrega=ucfirst(strtolower(trim($this->tbl_compras_entrega)));
            return true;
    } else {
        return false;
    }
	}

}
