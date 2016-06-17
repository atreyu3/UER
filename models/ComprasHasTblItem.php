<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_compras_has_tbl_item".
 *
		 * @property integer $tbl_compras_id_compras
 			 * @property integer $tbl_item_id_item
 			 * @property integer $tbl_requisiciones_id_requisiciones
 			 * @property integer $tbl_compras_has_tbl_item_cantidad
 			 * @property double $tbl_compras_has_tbl_item_precio
 	 *
 * @property Compras $tblComprasIdCompras
 * @property Item $tblItemIdItem
 * @property Requisiciones $tblRequisicionesIdRequisiciones

 */
class ComprasHasTblItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_compras_has_tbl_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_compras_id_compras', 'tbl_item_id_item', 'tbl_requisiciones_id_requisiciones'], 'required'],
            [['tbl_compras_id_compras', 'tbl_item_id_item', 'tbl_requisiciones_id_requisiciones', 'tbl_compras_has_tbl_item_cantidad'], 'integer'],
            [['tbl_compras_has_tbl_item_precio'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tbl_compras_id_compras' => Yii::t('app', 'Tbl Compras Id Compras'),
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
            'tbl_requisiciones_id_requisiciones' => Yii::t('app', 'Tbl Requisiciones Id Requisiciones'),
            'tbl_compras_has_tbl_item_cantidad' => Yii::t('app', 'Tbl Compras Has Tbl Item Cantidad'),
            'tbl_compras_has_tbl_item_precio' => Yii::t('app', 'Tbl Compras Has Tbl Item Precio'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblComprasIdCompras()
    {
        return $this->hasOne(Compras::className(), ['id_compras' => 'tbl_compras_id_compras']); 
    }
        	/**
     * humberto code  
     */
		public function getTblComprasList()
    {
          return ArrayHelper::map(Compras::find()->all(),'id_compras','tbl_compras_entrega'); 
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
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblRequisicionesIdRequisiciones()
    {
        return $this->hasOne(Requisiciones::className(), ['id_requisiciones' => 'tbl_requisiciones_id_requisiciones']); 
    }
        	/**
     * humberto code  
     */
		public function getTblRequisicionesList()
    {
          return ArrayHelper::map(Requisiciones::find()->all(),'id_requisiciones','tbl_requisiciones_cantidad'); 
    }	
				public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_item_id_item=ucfirst(strtolower(trim($this->tbl_item_id_item)));
            return true;
    } else {
        return false;
    }
	}

}
