<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_user_has_tbl_user".
 *
 * @property integer $tbl_user_id
 * @property integer $tbl_user_id1
 *
 * @property User $tblUser
 * @property User $tblUserId1

 */
class UserHasTblUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user_has_tbl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_user_id', 'tbl_user_id1'], 'required'],
            [['tbl_user_id', 'tbl_user_id1'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tbl_user_id' => Yii::t('app', 'Tbl User ID'),
            'tbl_user_id1' => Yii::t('app', 'Tbl User Id1'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUser()
    {
        return $this->hasOne(User::className(), ['id_user' => 'tbl_user_id']); 
    }
    
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUserId1()
    {
        return $this->hasOne(User::className(), ['id_user' => 'tbl_user_id1']); 
    }
    
	public function checkname($string){
		return $this->find()->select('tbl_user_id')->where(['tbl_user_id1'=>$string])->column() != false ? $this->find()->select('tbl_user_id')->where(['tbl_user_id1'=>$string])->column() : false;
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
		$modelo= new UserHasTblUser();
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
		 if($relacionmodelo=="User")
  		$relacionmodelo=new User(); 
		 if($relacionmodelo=="User")
  		$relacionmodelo=new User(); 
		 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
