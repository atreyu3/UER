<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_requisiciones".
 *
		 * @property integer $id_requisiciones
 			 * @property string $tbl_requisiciones_cantidad
 			 * @property integer $tbl_requisiciones_status
 			 * @property integer $tbl_user_id_user
 			 * @property string $tbl_requisiciones_nombre
 	 *
 * @property ComprasHasTblItem[] $tblComprasHasTblItems
 * @property User $tblUserIdUser
 * @property RequisicionesHasTblItem[] $tblRequisicionesHasTblItems
 * @property Item[] $tblItemIdItems

 */
class Requisiciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_requisiciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_requisiciones_status', 'tbl_user_id_user'], 'integer'],
            [['tbl_user_id_user'], 'required'],
            [['tbl_requisiciones_cantidad', 'tbl_requisiciones_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_requisiciones' => Yii::t('app', 'Id Requisiciones'),
            'tbl_requisiciones_cantidad' => Yii::t('app', 'Tbl Requisiciones Cantidad'),
            'tbl_requisiciones_status' => Yii::t('app', 'Tbl Requisiciones Status'),
            'tbl_user_id_user' => Yii::t('app', 'Tbl User Id User'),
            'tbl_requisiciones_nombre' => Yii::t('app', 'Tbl Requisiciones Nombre'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblComprasHasTblItems()
    {
        return $this->hasMany(ComprasHasTblItem::className(), ['tbl_requisiciones_id_requisiciones' => 'id_requisiciones']); 
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
    public function getTblRequisicionesHasTblItems()
    {
        return $this->hasMany(RequisicionesHasTblItem::className(), ['tbl_requisiciones_id_requisiciones' => 'id_requisiciones']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemIdItems()
    {
        return $this->hasMany(Item::className(), ['id_item' => 'tbl_item_id_item'])->viaTable('tbl_requisiciones_has_tbl_item', ['tbl_requisiciones_id_requisiciones' => 'id_requisiciones']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_requisiciones_cantidad=ucfirst(strtolower(trim($this->tbl_requisiciones_cantidad)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_requisiciones')->where(['tbl_requisiciones_cantidad'=>$string])->column() != false ? $this->find()->select('id_requisiciones')->where(['tbl_requisiciones_cantidad'=>$string])->column() : false;
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
		$modelo= new Requisiciones();
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
		 if($relacionmodelo=="ComprasHasTblItem")
  		$relacionmodelo=new ComprasHasTblItem(); 
		 if($relacionmodelo=="User")
  		$relacionmodelo=new User(); 
		 if($relacionmodelo=="RequisicionesHasTblItem")
  		$relacionmodelo=new RequisicionesHasTblItem(); 
		 if($relacionmodelo=="Item")
  		$relacionmodelo=new Item(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
