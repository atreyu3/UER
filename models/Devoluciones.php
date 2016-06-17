<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_devoluciones".
 *
 * @property integer $id_devolucion
 * @property string $tbl_devolucion_tagid
 * @property integer $mod_transaccionrefaccion_id_transaccionrefaccion
 * @property integer $tbl_user_id_user
 * @property string $tbl_devolucion_date
 * @property integer $tbl_devolucion_louder
 * @property integer $tbl_devolucion_cantidad
 * @property integer $tbl_devolucion_antena3
 * @property integer $tbl_devolucion_antena2
 * @property integer $tbl_item_id_item
 * 
 * @property Transaccionrefaccion $modTransaccionrefaccionIdTransaccionrefaccion
 * @property User $tblUserIdUser
 * @property Item $tblItemIdItem
 * 

 */
class Devoluciones extends \yii\db\ActiveRecord
{
	public $sumacount;
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_devoluciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mod_transaccionrefaccion_id_transaccionrefaccion', 'tbl_user_id_user','tbl_item_id_item'], 'required'],
            [['mod_transaccionrefaccion_id_transaccionrefaccion','tbl_devolucion_louder','tbl_devolucion_cantidad', 'tbl_user_id_user','tbl_devolucion_antena3','tbl_devolucion_antena2','tbl_item_id_item'], 'integer'],
            [['tbl_devolucion_date'], 'safe'],
            [['tbl_devolucion_tagid'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_devolucion' => Yii::t('app', 'Id Devolucion'),
            'tbl_devolucion_tagid' => Yii::t('app', 'Tbl Devolucion Tagid'),
            'mod_transaccionrefaccion_id_transaccionrefaccion' => Yii::t('app', 'Mod Transaccionrefaccion Id Transaccionrefaccion'),
            'tbl_user_id_user' => Yii::t('app', 'Tbl User Id User'),
            'tbl_devolucion_date' => Yii::t('app', 'Tbl Devolucion Date'),
            'tbl_item_id_item' => Yii::t('app', 'Tbl Item Id Item'),
			'sumacount'=>'Total'
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModTransaccionrefaccionIdTransaccionrefaccion()
    {
        return $this->hasOne(Transaccionrefaccion::className(), ['id_transaccionrefaccion' => 'mod_transaccionrefaccion_id_transaccionrefaccion']); 
    }
     /**
     * humberto code  
     */
		public function getModTransaccionrefaccionList()
    {
          return ArrayHelper::map(Transaccionrefaccion::find()->all(),'id_transaccionrefaccion','mod_transaccionrefaccion_date'); 
    }	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getTblUserIdUser()
    {
        return $this->hasOne(User::className(), ['id_user' => 'tbl_user_id_user']); 
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
	public function getTblUserList()
    {
          return ArrayHelper::map(User::find()->all(),'id_user','tbl_user_nombre'); 
    }
/**
     * humberto code  
     */
	public function getItemList()
    {
          return ArrayHelper::map(Item::find()->all(),'id_item','tbl_item_bim'); 
    }	
	public function devoluciones() {
		$devoluciones = \app\models\Read::find() -> where(['tbl_read_antena' => 3, 'tbl_read_activo' => 1]) -> all();
		$transaccionrefaccionunico=new \app\models\Transaccionrefaccion();
		foreach ($devoluciones as $key => $devolucion) {
			$modelo = new \app\models\Devoluciones();
			if($readusuario = \app\models\Readusuario::find() -> where(["id_readusuario" => $devolucion -> tbl_readusuario_id_readusuario]) -> one()){
				$r = substr($readusuario -> tbl_readusuario_tagid, 0, 1);
				if ($r == 'E') {
					$i = explode("F", $readusuario -> tbl_readusuario_tagid);
					$nombre = str_replace('E', '', $i[0]);
				}
					if(!\app\models\User::find()->where(['id_user'=>$nombre])->one()){
						$user=new \app\models\User();
						$user->id_user=$nombre;
						$user->tbl_categoriauser_id_categoriauser=2;
						$user->tbl_user_nombre="no identificado";	
						$user->save();
					}
								
				}else{
					$nombre=1;
				}
				if ($transaccion = Transaccionrefaccion::find() -> where(["mod_transaccionrefaccion_tagid" => $devolucion -> tbl_read_tagid, "mod_transaccionrefaccion_devolucion" => 0]) -> one()) {
					$transaccion -> mod_transaccionrefaccion_devolucion = 1;
						$idmod = $transaccion -> id_transaccionrefaccion;
				}else {
					$idmod=$this->idmod($devolucion->tbl_read_timestamp,$devolucion->tbl_read_tagid,$nombre);
					$transaccion = Transaccionrefaccion::findOne($idmod);
				}	
			if (isset($idmod)) {
				$modelo -> tbl_devolucion_tagid = $devolucion -> tbl_read_tagid;
				$modelo -> mod_transaccionrefaccion_id_transaccionrefaccion = $idmod;
				$modelo -> tbl_item_id_item=$this->iditem($devolucion -> tbl_read_tagid);
				$modelo -> tbl_user_id_user = $nombre;
				$modelo -> tbl_devolucion_date = $devolucion -> tbl_read_timestamp;
				$modelo -> tbl_devolucion_antena3 = $devolucion -> id_read;
				$devolucion -> tbl_read_activo = 0;
				if ($devolucion -> save()) {
					if ($salida_antena_2 = \app\models\Read::find() -> where(['tbl_read_activo' => 1, 'tbl_read_antena' => 2, 'tbl_read_tagid' => $devolucion -> tbl_read_tagid, 'tbl_readusuario_id_readusuario' => $devolucion -> tbl_readusuario_id_readusuario]) -> one()) {
						$modelo -> tbl_devolucion_antena2 = $salida_antena_2 -> id_read;
						$salida_antena_2 -> tbl_read_activo = 0;
						$salida_antena_2 -> save();
					}
					if($modelo -> save()){
						if($idmod!=1)
						$transaccion->save();
					if(isset($readusuario)){
						$readusuario->tbl_readusuario_devolucion=0;
						$readusuario->save();
					}
					}
				}
			}
		}
	}
	public function iditem($item){
		$id=explode('E', $item);
		return $id[0];
	}
	private function idmod($tiempo, $tag, $usuario) {
		$it5 = explode("E", $tag);
		$itemodel=new \app\models\Item();
		$model = new \app\models\Transaccionrefaccion();
		$model -> mod_transaccionrefaccion_date = $tiempo;
		$model -> tbl_maquina_id_maquina = 0;
		$model -> tbl_usorefaccion_id_usorefaccion = 0;
		$model -> mod_transaccionrefaccion_piezas = "1";
		$model -> tbl_item_id_item = $it5[0];
		$model -> tbl_user_id_user = $usuario;
		$model -> mod_transaccionrefaccion_tagid = $tag;
		if($item=$itemodel->find()->where(['id_item'=>$it5[0]])->one()){
		$model -> save();
		}else{
			$item=new \app\models\Item();
			$item->id_item=$it5[0];
			$item->tbl_familia_id_familia=1;
			$item->tbl_categoriaitem_id_categoriaitem=1;
			$item->tbl_marca_id_marca=1;
			if($item->save()){
				$model -> tbl_item_id_item =$item->id_item;
				$model->save();
			}
		}
		return $model -> id_transaccionrefaccion;
	}
	
}
