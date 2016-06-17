<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/


/**
 * This is the model class for table "tbl_pedidos".
 *
 * @property integer $id_pedidos
 * @property string $tbl_pedidos_cantidad
 * @property integer $tbl_pedidos_status
 * @property integer $tbl_user_id_user
 * @property integer $tbl_item_id_item
 *
 * @property User $tblUserIdUser
 * @property Item $tblItemIdItem

 */
class Pedidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_pedidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_pedidos_status', 'tbl_user_id_user', 'tbl_item_id_item'], 'integer'],
            [['tbl_user_id_user', 'tbl_item_id_item'], 'required'],
            [['tbl_pedidos_cantidad'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pedidos' => Yii::t('app', 'Id Pedidos'),
            'tbl_pedidos_cantidad' => Yii::t('app', 'Tbl Pedidos Cantidad'),
            'tbl_pedidos_status' => Yii::t('app', 'Tbl Pedidos Status'),
            'tbl_user_id_user' => Yii::t('app', 'Tbl User Id User'),
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
        ];
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
    public function getTblItemIdItem()
    {
        return $this->hasOne(Item::className(), ['id_item' => 'tbl_item_id_item']); 
    }
        	/**
     * humberto code  
     */
		public function getTblItemList()
    {
          return ArrayHelper::map(Item::find()->all(),'id_item','tbl_item_bim'); 
    }	
}
