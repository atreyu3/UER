<?php

namespace app\models;

use Yii;


use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_item".
 *
 * @property integer $id_item
 * @property string $tbl_item_bim
 * @property integer $tbl_item_stock
 * @property string $tbl_item_almacen
 * @property string $tbl_item_noParte
 * @property string $tbl_item_nombre
 * @property integer $tbl_item_costo
 * @property string $tbl_item_precio
 * @property integer $tbl_familia_id_familia
 * @property integer $tbl_categoriaitem_id_categoriaitem
 * @property integer $tbl_marca_id_marca
 * @property string $tbl_item_unidadmedida
 * @property string $tbl_item_parcialidad
 * @property string $tbl_item_parcialnumero
 * @property string $tbl_item_eprocurement
 * 
 * @property Transaccionrefaccion[] $modTransaccionrefaccions
 * @property ComprasHasTblItem[] $tblComprasHasTblItems
 * @property Compras[] $tblComprasIdCompras
 * @property Familia $tblFamiliaIdFamilia
 * @property Categoriaitem $tblCategoriaitemIdCategoriaitem
 * @property Marca $tblMarcaIdMarca
 * @property ItemHasTblInventario[] $tblItemHasTblInventarios
 * @property Inventario[] $tblInventarioIdInventarios
 * @property Precio[] $tblPrecios
 * @property RequisicionesHasTblItem[] $tblRequisicionesHasTblItems
 * @property Requisiciones[] $tblRequisicionesIdRequisiciones

 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbl_item_parcialidad','tbl_item_parcialnumero','tbl_item_stock', 'tbl_item_costo', 'tbl_familia_id_familia', 'tbl_categoriaitem_id_categoriaitem', 'tbl_marca_id_marca','tbl_item_folio'], 'integer'],
            [['tbl_item_nombre'], 'string'],
            [['tbl_familia_id_familia', 'tbl_categoriaitem_id_categoriaitem', 'tbl_marca_id_marca'], 'required'],
            [['tbl_item_bim'], 'string', 'max' => 11],
            [['tbl_item_almacen','tbl_item_eprocurement', 'tbl_item_noParte', 'tbl_item_precio', 'tbl_item_unidadmedida'], 'string', 'max' => 45],
            [['tbl_item_bim'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_item' => Yii::t('app', 'Id Item'),
            'tbl_item_bim' => Yii::t('app', 'Tbl Item Bim'),
            'tbl_item_stock' => Yii::t('app', 'Tbl Item Stock'),
            'tbl_item_almacen' => Yii::t('app', 'Tbl Item Almacen'),
            'tbl_item_noParte' => Yii::t('app', 'Tbl Item No Parte'),
            'tbl_item_nombre' => Yii::t('app', 'Tbl Item Nombre'),
            'tbl_item_costo' => Yii::t('app', 'Tbl Item Costo'),
            'tbl_item_precio' => Yii::t('app', 'Tbl Item Precio'),
            'tbl_familia_id_familia' => Yii::t('app', 'Tbl Familia Id Familia'),
            'tbl_categoriaitem_id_categoriaitem' => Yii::t('app', 'Tbl Categoriaitem Id Categoriaitem'),
            'tbl_marca_id_marca' => Yii::t('app', 'Tbl Marca Id Marca'),
            'tbl_item_unidadmedida' => Yii::t('app', 'Tbl Item Unidadmedida'),
            'tbl_item_folio' => Yii::t('app', 'Tbl Item Folio'),
            'tbl_item_parcialidad' => Yii::t('app', 'Tbl Item Parcial'),
            'tbl_item_parcialnumero' => Yii::t('app', 'Tbl Item Parcialidad'),
			'tbl_item_eprocurement'=>Yii::t('app','Tbl item eprocurement'),
			];
    }
	 /**
     * @inheritdoc
     */
    public function customattributeLabels()
    {
        return [
            'id_item' => ["nombre"=>Yii::t('app', 'Id Item'),"visible"=>"no"],
            'tbl_item_bim' =>["nombre"=> Yii::t('app', 'Tbl Item Bim'),"visible"=>"si"],
            'tbl_item_stock' => ["nombre"=> Yii::t('app', 'Tbl Item Stock'),"visible"=>"si"],
            'tbl_item_almacen' => ["nombre"=> Yii::t('app', 'Tbl Item Almacen'),"visible"=>"si"],
            'tbl_item_noParte' => ["nombre"=> Yii::t('app', 'Tbl Item No Parte'),"visible"=>"si"],
            'tbl_item_nombre' => ["nombre"=> Yii::t('app', 'Tbl Item Nombre'),"visible"=>"si"],	
            'tbl_item_costo' => ["nombre"=> Yii::t('app', 'Tbl Item Costo'),"visible"=>"no"],
            'tbl_item_precio' => ["nombre"=> Yii::t('app', 'Tbl Item Precio'),"visible"=>"no"],
            'Familia.tbl_familia_id_familia' => ["nombre"=> Yii::t('app', 'Tbl Familia Id Familia'),"visible"=>"si"],
            'Categoria.tbl_categoriaitem_id_categoriaitem' => ["nombre"=> Yii::t('app', 'Tbl Categoriaitem Id Categoriaitem'),"visible"=>"si"],
            'Marca.tbl_marca_id_marca' => ["nombre"=> Yii::t('app', 'Tbl Marca Id Marca'),"visible"=>"si"],
            'tbl_item_unidadmedida' => ["nombre"=>Yii::t('app', 'Tbl Item Unidadmedida'),"visible"=>"no"],
            'tbl_item_folio' => ["nombre"=> Yii::t('app', 'Tbl Item Folio'),"visible"=>"no"],
            'tbl_item_parcial' => ["nombre"=> Yii::t('app', 'Tbl Item Parcial'),"visible"=>"no"],
            'tbl_item_parcialidad' => ["nombre"=> Yii::t('app', 'Tbl Item Parcialidad'),"visible"=>"no"],
            'Inventario.tbl_inventario_nombre'=>["nombre"=> Yii::t('app', 'Tbl Inventario Nombre'),"visible"=>"si"],
            'Inventario.ItemHasTblInventario.tbl_item_has_tbl_inventario_cantidad'=>["nombre"=> Yii::t('app', 'Tbl Item Has Tbl Inventario Cantidad'),"visible"=>"si"],
            //'Proveeedor.tbl_proveedor_nombre'=>["nombre"=> Yii::t('app', 'Tbl Inventario Nombre'),"visible"=>"si"],
            //'Proveeedor.tbl_proveedor_numero'=>["nombre"=> Yii::t('app', 'Tbl Item Has Tbl Inventario Cantidad'),"visible"=>"si"],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModTransaccionrefaccions()
    {
        return $this->hasMany(Transaccionrefaccion::className(), ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblComprasHasTblItems()
    {
        return $this->hasMany(ComprasHasTblItem::className(), ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblComprasIdCompras()
    {
        return $this->hasMany(Compras::className(), ['id_compras' => 'tbl_compras_id_compras'])->viaTable('tbl_compras_has_tbl_item', ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblFamiliaIdFamilia()
    {
        return $this->hasOne(Familia::className(), ['id_familia' => 'tbl_familia_id_familia']); 
    }
        	/**
     * humberto code  
     */
		public function getTblFamiliaList()
    {
          return ArrayHelper::map(Familia::find()->all(),'id_familia','tbl_familia_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblCategoriaitemIdCategoriaitem()
    {
        return $this->hasOne(Categoriaitem::className(), ['id_categoriaitem' => 'tbl_categoriaitem_id_categoriaitem']); 
    }
        	/**
     * humberto code  
     */
		public function getTblCategoriaitemList()
    {
          return ArrayHelper::map(Categoriaitem::find()->all(),'id_categoriaitem','tbl_categoriaitem_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMarcaIdMarca()
    {
        return $this->hasOne(Marca::className(), ['id_marca' => 'tbl_marca_id_marca']); 
    }
        	/**
     * humberto code  
     */
		public function getTblMarcaList()
    {
          return ArrayHelper::map(Marca::find()->all(),'id_marca','tbl_marca_nombre'); 
    }	
			    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblItemHasTblInventarios()
    {
        return $this->hasMany(ItemHasTblInventario::className(), ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblInventarioIdInventarios()
    {
        return $this->hasMany(Inventario::className(), ['id_inventario' => 'tbl_inventario_id_inventario'])->viaTable('tbl_item_has_tbl_inventario', ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPrecios()
    {
        return $this->hasMany(Precio::className(), ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblRequisicionesHasTblItems()
    {
        return $this->hasMany(RequisicionesHasTblItem::className(), ['tbl_item_id_item' => 'id_item']); 
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblRequisicionesIdRequisiciones()
    {
        return $this->hasMany(Requisiciones::className(), ['id_requisiciones' => 'tbl_requisiciones_id_requisiciones'])->viaTable('tbl_requisiciones_has_tbl_item', ['tbl_item_id_item' => 'id_item']); 
    }
    	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this->tbl_item_bim=ucfirst(strtolower(trim($this->tbl_item_bim)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('id_item')->where(['tbl_item_bim'=>$string])->column() != false ? $this->find()->select('id_item')->where(['tbl_item_bim'=>$string])->column() : false;
	}
	public function cargacsv($carga,$columns,$check){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga);
	$bandera=true;
	$csv=$columns['csv'];
	
	 return $csvlines;
	 }

	public function unique_multidim_array($array, $key,$strict=false) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }else{
        	if($strict==true){
        	$indice=array_search($val[$key], array_column($temp_array,0),TRUE);
			$temp_array[$indice][3]=$temp_array[$indice][3]+$val[3];
			}
        }
        $i++;
    }
    return $temp_array;
	} 
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	    	/**
     * humberto code  
     */
		public function inventory()
    {
          return ArrayHelper::map(Inventario::find()->orderBy(['tbl_inventario_nombre'=>SORT_ASC])->all(),'id_inventario','tbl_inventario_nombre'); 
    }	
	public function bim($id){
		$user= $this->find()->select('tbl_item_bim')->where(['id_item' =>$id])->one();
		return isset($user->tbl_item_bim) ? $user->tbl_item_bim : $id ;		
	}
	public function ides($id){
		$user= $this->find()->select('id_item')->where(['id_item' =>$id])->one();
		return isset($user->id_item) ? $user->id_item : "no" ;		
	}	
		
	public function description($id){
		$user= $this->find()->select('tbl_item_nombre')->where(['id_item' =>$id])->one();
		return isset($user->tbl_item_nombre) ? $user->tbl_item_nombre : "no tiene description" ;		
	}
	public function parcialidad(){
		 return ArrayHelper::map($this->find()->where(['tbl_item_parcialidad' => "1"])->all(),"id_item","tbl_item_bim");		
	}	
	public function noparte($id){
		$user= $this->find()->select('tbl_item_noParte')->where(['id_item' =>$id])->one();
		return isset($user->tbl_item_noParte) ? $user->tbl_item_noParte : "no tiene description" ;		
	}	
}
