<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_inventario".
 *
 * @property integer $id_inventario
 * @property string $tbl_inventario_nombre
 *
 * @property ItemHasTblInventario[] $tblItemHasTblInventarios
 * @property Item[] $tblItemIdItems

 */
class Inventario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_inventario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inventario'], 'integer'],
            [['tbl_inventario_nombre'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_inventario' => Yii::t('app', 'Id Inventario'),
            'tbl_inventario_nombre' => Yii::t('app', 'Tbl Inventario Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemHasTblInventarios()
    {
        return $this->hasMany(ItemHasTblInventario::className(), ['tbl_inventario_id_inventario' => 'id_inventario']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemIdItems()
    {
        return $this->hasMany(Item::className(), ['id_item' => 'tbl_item_id_item'])->viaTable('tbl_item_has_tbl_inventario', ['tbl_inventario_id_inventario' => 'id_inventario']); 
    }
	public function nombreinventario($id)
    {
        $inventario=$this->findOne($id);	
        return $inventario->tbl_inventario_nombre; 
    }
    
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_inventario_nombre=ucfirst(strtolower(trim($this->tbl_inventario_nombre)));
            return true;
    } else {
        return false;
    }
	}
	public function cargalista($csvlines) {
		set_time_limit(300);
		$row=1;
		$col=['tbl_inventario_nombre'];
		foreach ($csvlines as $key=>$csvline) {
			if($item=Item::find()->where(['tbl_item_bim'=>$csvline[1]])->one()){		
			if(!$modelo=Inventario::find()->where(['tbl_inventario_nombre'=>$csvline[0]])->one()){
				$modelo=new Inventario();
				$modelo->tbl_inventario_nombre=$csvline[0];
				$modelo->save();
			}
				if($iteminvent=ItemHasTblInventario::find()->where(['tbl_item_id_item'=>$item->id_item,'tbl_inventario_id_inventario'=>$modelo->id_inventario])->one()){
						$iteminvent->tbl_item_has_tbl_inventario_cantidad=$csvline[2];
						$iteminvent->save();	
					}else{
					$iteminventario= new ItemHasTblInventario();
					$iteminventario->tbl_item_id_item=$item->id_item;
					$iteminventario->tbl_inventario_id_inventario=$modelo->id_inventario;
					$iteminventario->tbl_item_has_tbl_inventario_cantidad=$csvline[2];
					$iteminventario->save();
					}	
			}
			
		}
		return true;
	}

}
