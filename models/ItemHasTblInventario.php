<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_item_has_tbl_inventario".
 *
 * @property integer $tbl_item_id_item
 * @property integer $tbl_inventario_id_inventario
 * @property integer $tbl_item_has_tbl_inventario_cantidad
 *
 * @property Item $tblItemIdItem
 * @property Inventario $tblInventarioIdInventario

 */
class ItemHasTblInventario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_item_has_tbl_inventario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_item_id_item', 'tbl_inventario_id_inventario'], 'required'],
            [['tbl_item_id_item', 'tbl_inventario_id_inventario', 'tbl_item_has_tbl_inventario_cantidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
            'tbl_inventario_id_inventario' => Yii::t('app', 'Tbl Inventario Id Inventario'),
            'tbl_item_has_tbl_inventario_cantidad' => Yii::t('app', 'Tbl Item Has Tbl Inventario Cantidad'),
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
     * humberto code  
     */
		public function getTblItemList()
    {
          return ArrayHelper::map(Item::find()->all(),'id_item','tbl_item_bim'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblInventarioIdInventario()
    {
        return $this->hasOne(Inventario::className(), ['id_inventario' => 'tbl_inventario_id_inventario']); 
    }
        	/**
     * humberto code  
     */
		public function getTblInventarioList()
    {
          return ArrayHelper::map(Inventario::find()->all(),'id_inventario','tbl_inventario_nombre'); 
    }	
				public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_inventario_id_inventario=ucfirst(strtolower(trim($this->tbl_inventario_id_inventario)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('tbl_item_id_item')->where(['tbl_inventario_id_inventario'=>$string])->column() != false ? $this->find()->select('tbl_item_id_item')->where(['tbl_inventario_id_inventario'=>$string])->column() : false;
	}
	public function cargacsv($carga){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga['id']);
	$bandera=true;
	$csvcolumn=0;
	foreach ($carga['modelcsv'] as $envia=>$key) {
		$a[$envia]=$key;	
		}
	foreach ($archivo->proccessall() as $csvline) {
		$row=0;
		$modelo= new ItemHasTblInventario();
		$bandera=true;
		foreach ($this->attributes() as $k=>$key) {
			if($row==0)$modelnombre=$this->nombre($key);
			if($row>0){
				if($this->nombre($key)==$modelnombre){
				$modelo->$key=$csvline[$a[$key]];
				}else{
				if($rela=$this->checkrelation($key,$csvline[$a[$key]]))
				$modelo->$key=$rela[0];
				else{
				$bandera=false;
				$b[$key][$csvcolumn]=$csvline[$a[$key]];
				}	
				}
			}
			$row++;
		}
			if($bandera==true){
			$csvcolumn++;
			$modelo->save();
			}
		}
		$b['columnasadd']=$csvcolumn;
	 return $b;
	 }
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		 if($relacionmodelo=="Item")
  		$relacionmodelo=new Item(); 
		 if($relacionmodelo=="Inventario")
  		$relacionmodelo=new Inventario(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
