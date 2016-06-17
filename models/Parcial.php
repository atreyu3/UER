<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_parcial".
 *
 * @property integer $id_parcial
 * @property double $tbl_parcial_cantidad
 * @property integer $tbl_item_id_item
 *
 * @property TblItem $tblItemIdItem
 */
class Parcial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_parcial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parcial', 'tbl_item_id_item'], 'required'],
            [['id_parcial', 'tbl_item_id_item'], 'integer'],
            [['tbl_parcial_cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_parcial' => 'Id Parcial',
            'tbl_parcial_cantidad' => 'Tbl Parcial Cantidad',
            'tbl_item_id_item' => 'Tbl Item Id Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemIdItem()
    {
        return $this->hasOne(TblItem::className(), ['id_item' => 'tbl_item_id_item']);
    }
}
