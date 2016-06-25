<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "tbl_archivo".
 *
 * @property integer $id_archivo
 * @property string $tbl_archivo_nombre
 * @property string $tbl_archivo_fecha
 * @property integer $tbl_archivo_user
 * @property string $tbl_archivo_fechamodificacion
 */
class Archivo extends \yii\db\ActiveRecord {
	public $imageFiles;
	public $linesglobal=array();
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'tbl_archivo';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['tbl_archivo_user'], 'integer'], [['tbl_archivo_fecha'], 'integer'], [['tbl_archivo_nombre'], 'string', 'max' => 200], [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'maxFiles' => 4]];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return ['id_archivo' => Yii::t('app', 'Id Archivo'), 'tbl_archivo_nombre' => Yii::t('app', 'Tbl Archivo Nombre'), 'tbl_archivo_fecha' => Yii::t('app', 'Tbl Archivo Fecha'), 'tbl_archivo_user' => Yii::t('app', 'Tbl Archivo User'), ];
	}

	public function proccess() {
		set_time_limit(300);
		$data = array();
		if (explode(".", $this -> tbl_archivo_nombre)[1] == 'csv') {
			$file = fopen('uploads/' . $this -> tbl_archivo_nombre, 'r');
			$line = fgetcsv($file);
			fclose($file);
		} else {
			$objPHPExcel = \PHPExcel_IOFactory::load('uploads/' . $this -> tbl_archivo_nombre);
			$worksheet = $objPHPExcel -> getActiveSheet();
			$row = $worksheet -> getRowIterator(1) -> current();
			$cellIterator = $row -> getCellIterator();
			$cellIterator -> setIterateOnlyExistingCells(false);
			foreach ($cellIterator as $cell) {
				$line[] = $cell -> getValue();
			}
		}
		return $line;
	}
	
	public function proccessall($lineas=null,$page=0) {
		$data = array();
		if (explode(".", $this -> tbl_archivo_nombre)[1] == 'csv') {
			$file = fopen('uploads/' . $this -> tbl_archivo_nombre, 'r');
			$row = 0;
			while (($line = fgetcsv($file)) !== false) {	
				if ($line != '' and $row > 0 and $line[0] != null) {
					$data[] = $line;
				}
				$row++;
			}
			fclose($file);
			unset($line);
			unset($row);			
		} else {
			$objPHPExcel = \PHPExcel_IOFactory::load('uploads/' . $this -> tbl_archivo_nombre);
			$worksheet = $objPHPExcel -> getActiveSheet();
			$r = 0;
			$rows=$worksheet->getRowIterator();
			foreach ($rows as $row) {
				if ($r > 0) {
					$cellIterator = $row -> getCellIterator();
					$cellIterator -> setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell) {
						$data[$r][] = $cell->getCalculatedValue();
					}
					$data[$r] = array_map(function($str) {
						return is_numeric($str) ? $str : ucfirst(strtolower(trim($str)));
					}, $data[$r]);
				}
				$r++;
			}
		}
		unlink('uploads/' . $this -> tbl_archivo_nombre);
		if($lineas!=null){
			$data2=array();
			$data3=array();
			foreach ($data as $line) {
			foreach ($lineas as $key => $value) {
					$data2[]=$line[$value];
			}
			$data3[]=$data2;
			unset($data2);
			}
			unset($data);
			$data=$data3;
			unset($data3);			
		}			
		 return array_map("unserialize",array_unique(array_map('serialize',$data)));
	}
	public function proccessglobal($lineas=null,$page=0,$listadeprecios=null) {
		$data = array();
		$l=1;
		if (explode(".", $this -> tbl_archivo_nombre)[1] == 'csv') {
			$file = fopen('uploads/' . $this -> tbl_archivo_nombre, 'r');
			$row = 0;
			while (($line = fgetcsv($file)) !== false) {	
				if ($line != '' and  $line[0] != null) {
					$data[] = $line;
				}
				$row++;
			}
			fclose($file);
			unset($line);
			unset($row);			
		} else {
			$cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cacheSettings = array( 'memoryCacheSize' => '100MB');
			\PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			$inputFile='uploads/' . $this -> tbl_archivo_nombre;
			$inputFileType = \PHPExcel_IOFactory::identify($inputFile);
			$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			if($listadeprecios==null){
			$objPHPExcel = $objReader->load($inputFile);	
			$worksheet = $objPHPExcel -> getActiveSheet()->toArray();
			}else{
			$l=5;
			$objReader->setLoadSheetsOnly('ACTIVO');
			$objPHPExcel = $objReader->load($inputFile);
			$worksheet = $objPHPExcel->getSheetByName('ACTIVO')->toArray();	
			}
			$data=$worksheet;
			$objPHPExcel->disconnectWorksheets(); 
    		unset($objPHPExcel); 
		}
		//unlink('uploads/' . $this -> tbl_archivo_nombre);
		if($lineas!=null){
			$data2=array();
			$data3=array();
			$r = 0;
			foreach ($data as $line) {
			if($r>=$l){
			foreach ($lineas as $key => $value) {
					$data2[]=$line[$value];
			}
			$data3[]=$data2;
			unset($data2);
			}
			$r++;
			}
			unset($data);
			$data=$data3;
			unset($data3);
			$this->linesglobal=array_map("unserialize",array_unique(array_map('serialize',$data)));			
		}else{
			$this->linesglobal=['0'=>'nada'];
		}			
		 
		 //return $this->linesglobal;
	}
	
	public function proccessgloballista($lineas=null) {
		$data = array();
		$l=1;
		if (explode(".", $this -> tbl_archivo_nombre)[1] == 'csv') {
			$file = fopen('uploads/' . $this -> tbl_archivo_nombre, 'r');
			$row = 0;
			while (($line = fgetcsv($file)) !== false) {
				if ($line != '' and  $line[0] != null) {
					$data[] = $line;
					$li=$line;
				}
				$row++;
			}
			fclose($file);
			unset($row);
			unset($line);			
		} else {
			$inputFile='uploads/' . $this -> tbl_archivo_nombre;
			$inputFileType = \PHPExcel_IOFactory::identify($inputFile);
			$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$l=5;
			$objReader->setLoadSheetsOnly('ACTIVO');
			$objPHPExcel = $objReader->load($inputFile);
			$data = $objPHPExcel->getSheetByName('ACTIVO')->toArray();
			//$data=$worksheet;
			$objPHPExcel->disconnectWorksheets(); 
    		unset($objPHPExcel); 
		}
		//unlink('uploads/' . $this -> tbl_archivo_nombre);
		if($lineas!=null){
			$data2=array();
			$data3=array();
			$r = 0;
			$linea_item_bim=[1,21,40,59];
			foreach ($data as $line) {
			if($r>=$l){
				if($id=Item::find()->where(['tbl_item_bim'=>$line[1]])->one()){	
					foreach ($lineas as $key => $value) {
						if(in_array($value, $linea_item_bim)){
						$data2[]=$id->id_item;
						}else{
						$data2[]=$line[$value];	
						}
					}
					$data3[]=$data2;
					unset($data2);
				}
			}
			$r++;
			}
			unset($data);
			$data=$data3;
			unset($data3);
			$this->linesglobal=array_map("unserialize",array_unique(array_map('serialize',$data)));			
		}else{
			$this->linesglobal=['0'=>'nada'];
		}			
		 
		 //return $this->linesglobal;
	}	
	
	protected function nombrecsv($string){
		return ucfirst(strtolower(trim($string)));
	}
	public function proccessitem($lineas=null,$id=0) {
		$data = array();
		if (explode(".", $this -> tbl_archivo_nombre)[1] == 'csv') {
			$file = fopen('uploads/' . $this -> tbl_archivo_nombre, 'r');
			$row = 0;
			while (($line = fgetcsv($file)) !== false) {	
				if ($line != '' and $row > 0 and $line[0] != null) {
					$data[] = $line;
				}
				$row++;
			}
			fclose($file);
			unset($line);
			unset($row);			
		} else {
			$objPHPExcel = \PHPExcel_IOFactory::load('uploads/' . $this -> tbl_archivo_nombre);
			$worksheet = $objPHPExcel -> getActiveSheet();
			$r = 0;
			$rows=$worksheet->getRowIterator();
			foreach ($rows as $row) {
				if ($r > 0) {
					$cellIterator = $row -> getCellIterator();
					$cellIterator -> setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell) {
						$data[$r][] = $cell -> getValue();
					}
					$data[$r] = array_map(function($str) {
						return is_numeric($str) ? $str : ucfirst(strtolower(trim($str)));
					}, $data[$r]);
				}
				$r++;
			}
		}
					unlink('uploads/' . $this -> tbl_archivo_nombre);
		if($lineas!=null){
			$items=ArrayHelper::map(Item::find()->all(),'id_item','tbl_item_bim');
			$data2=array();
			$data3=array();
			foreach ($data as $line) {
			$ban=false;
			if(array_search($this->nombrecsv($line[$id]),$items)){
			$ban=true;		
			$line[$id]=array_search($this->nombrecsv($line[$id]),$items);
			}
			foreach ($lineas as $key => $value) {
					$data2[]=$line[$value];
			}
			if($ban==true)
			$data3[]=$data2;
			unset($data2);
			}
			unset($data);
			$data=$data3;
			unset($data3);			
		}			
		return array_map("unserialize",array_unique(array_map('serialize',$data)));
	}

public function proccessfilter($lineas=null,$filter) {
		$data = array();
		if (explode(".", $this -> tbl_archivo_nombre)[1] == 'csv') {
			$file = fopen('uploads/' . $this -> tbl_archivo_nombre, 'r');
			$row = 0;
			while (($line = fgetcsv($file)) !== false) {	
				if ($line != '' and $row > 0 and $line[0] != null) {
					$data[] = $line;
				}
				$row++;
			}
			fclose($file);
			unset($line);
			unset($row);			
		} else {
			$objPHPExcel = \PHPExcel_IOFactory::load('uploads/' . $this -> tbl_archivo_nombre);
			$worksheet = $objPHPExcel -> getActiveSheet();
			$r = 0;
			$rows=$worksheet->getRowIterator();
			foreach ($rows as $row) {
				if ($r > 0) {
					$cellIterator = $row -> getCellIterator();
					$cellIterator -> setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell) {
						$data[$r][] = $cell -> getValue();
					}
					$data[$r] = array_map(function($str) {
						return is_numeric($str) ? $str : ucfirst(strtolower(trim($str)));
					}, $data[$r]);
				}
				$r++;
			}
		}
					unlink('uploads/' . $this -> tbl_archivo_nombre);
		if($lineas!=null){
			$data2=array();
			$data3=array();
			foreach ($data as $line) {
			$ban=false;
			if($line[$filter['colum']]===$filter['value']){
			foreach ($lineas as $key => $value) {
					$data2[]=$line[$value];
			}
			$data3[]=$data2;
			unset($data2);
			}
			}
			unset($data);
			$data=$data3;
			unset($data3);			
		}			
		return array_map("unserialize",array_unique(array_map('serialize',$data)));
	}
	public function upload() {
		foreach ($this->imageFiles as $file) {
			$file -> saveAs('uploads/' . $file -> baseName . '.' . $file -> extension);
		}
		return true;
	}
	public function cargamaquinas() {
		$this->proccessglobal(['4','11','2','3','6','7','0','1','5','10','12','13','15']);
		$uploadmaster= new Modelcustomfunction;
		$columns=[
		 'db'=>['tbl_status_nombre'],
		'iteracion'=>[
		['column'=>'tbl_status_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]
		];
		$check=['relations'=>false];
		$check['update']=false;
		$md=[
		'nombre'=>'Status',
		'columna'=>'tbl_status_nombre'
		];
		$depurar=array_map(function($v){return [$v[0]];},$this->linesglobal);
		$depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		$uploadmaster->cargapruebacsv($depurar, $columns, $check,$md);
		$columns=[
		'csv'=>['11'],
		'db'=>['tbl_marca_nombre'],
		'iteracion'=>[
		['column'=>'tbl_marca_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]
		];
		$check=['relations'=>false];
		$check['update']=false;
		$md=[
		'nombre'=>'Marca',
		'columna'=>'tbl_marca_nombre'
		];
		$depurar=array_map(function($v){return [$v[1]];},$this->linesglobal);
		$depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		$uploadmaster->cargapruebacsv($depurar, $columns, $check,$md);
		$columns=[
		'csv'=>['2','3'],
		'db'=>['tbl_linea_nombre','tbl_linea_siglas','tbl_grupo_id_grupo'],
		'iteracion'=>[
		['column'=>'tbl_linea_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_linea_siglas','csv'=>1,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_grupo_id_grupo','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],		
		]
		];
		$md=[
		'nombre'=>'Linea',
		'columna'=>'tbl_linea_nombre'
		];
		$check=['relations'=>true,
		'update'=>false,
		'llaves'=>[
			['clase'=>'Grupo','columna'=>'tbl_grupo_nombre','valor'=>'No asignado'],
			]
			];
		$depurar=array_map(function($v){return [$v[2],$v[3]];},$this->linesglobal);
		$depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		$uploadmaster->cargapruebacsv($depurar, $columns, $check,$md);
		$columns=[
		'csv'=>['6'],
		'db'=>['tbl_ubicacionfisica_nombre'],
		'iteracion'=>[
		['column'=>'tbl_ubicacionfisica_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]
		];
		$check=['relations'=>false];
		$check['update']=false;
		$md=[
		'nombre'=>'Ubicacionfisica',
		'columna'=>'tbl_ubicacionfisica_nombre'
		];
		$depurar=array_map(function($v){return [$v[4]];},$this->linesglobal);
		$depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		$uploadmaster->cargapruebacsv($depurar, $columns, $check,$md);
		unset($columns);
		$columns=[
		'csv'=>['7'],
		'db'=>['tbl_centrodecostos_nombre'],
		'iteracion'=>[
		['column'=>'tbl_centrodecostos_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]
		];
		$check=['relations'=>false];
		$check['update']=false;
		$md=[
		'nombre'=>'Centrodecostos',
		'columna'=>'tbl_centrodecostos_nombre'
		];
		$depurar=array_map(function($v){return [$v[5]];},$this->linesglobal);
		$depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		$uploadmaster->cargapruebacsv($depurar, $columns, $check,$md);
		$columns=[
		'csv'=>['0','1','4','5','10','11','12','13','15','2','6','7'],
		'db'=>[
		'tbl_maquina_bim',
		'tbl_maquina_descripcion_bim',
		'tbl_status_id_status',
		'tbl_maquina_activos',
		'tbl_maquina_descripcion',
		'tbl_marca_id_marca',
		'tbl_maquina_modelo',
		'tbl_maquina_serie',
		'tbl_maquina_comentario',
		'tbl_familia_id_familia',
		'tbl_linea_id_linea',
		'tbl_ubicacionfisica_id_ubicacionfisica',
		'tbl_centrodecostos_id_centrodecostos',
		],
		'iteracion'=>[
		['column'=>'tbl_maquina_bim','csv'=>'0','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_maquina_descripcion_bim','csv'=>'1','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_status_id_status','csv'=>'2','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_maquina_activos','csv'=>'3','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_maquina_descripcion','csv'=>'4','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_marca_id_marca','csv'=>'5','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_maquina_modelo','csv'=>'6','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_maquina_serie','csv'=>'7','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_maquina_comentario','csv'=>'8','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_familia_id_familia','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_linea_id_linea','csv'=>'9','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_ubicacionfisica_id_ubicacionfisica','csv'=>'10','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_centrodecostos_id_centrodecostos','csv'=>'11','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]	
		];
		$check=[
		'relations'=>true,
		'update'=>false,
		'llaves'=>[
			['clase'=>'Status','columna'=>'tbl_status_nombre','valor'=>'No asignado'],
			['clase'=>'Marca','columna'=>'tbl_marca_nombre','valor'=>'No asignado'],
			['clase'=>'Familia','columna'=>'tbl_familia_nombre','valor'=>'No asignado'],
			['clase'=>'Linea','columna'=>'tbl_linea_nombre','valor'=>'No asignado'],
			['clase'=>'Ubicacionfisica','columna'=>'tbl_ubicacionfisica_nombre','valor'=>'No asignado'],
			['clase'=>'Centrodecostos','columna'=>'tbl_centrodecostos_nombre','valor'=>'No asignado'],
			]
		];
		$md=['nombre'=>'Maquina','columna'=>'tbl_maquina_bim'];
		$depurar=array_map(function($v){return [$v[6],$v[7],$v[0],$v[8],$v[9],$v[1],$v[10],$v[11],$v[12],$v[2],$v[4],$v[5]];},$this->linesglobal);
		$depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		return $uploadmaster->cargapruebacsv($depurar, $columns,$check,$md);
		//return true;
	}
	public function uploadonhand() {
		$carga=$this->id_archivo;
		$uploadmaster= new Modelcustomfunction;
		$columns=[
		'db'=>['tbl_item_bim','tbl_item_almacen','tbl_item_nombre','tbl_item_stock','tbl_marca_id_marca','tbl_familia_id_familia','tbl_categoriaitem_id_categoriaitem'],
		'iteracion'=>[
		['column'=>'tbl_item_bim','csv'=>'0','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_item_almacen','csv'=>'1','relacion'=>false,'filter'=>'','flag'=>''],
		['column'=>'tbl_item_nombre','csv'=>'2','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_item_stock','csv'=>'3','relacion'=>false,'filter'=>FILTER_SANITIZE_NUMBER_INT,'flag'=>''],
		['column'=>'tbl_marca_id_marca','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_familia_id_familia','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_categoriaitem_id_categoriaitem','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''], 
		]
		];
		$check=['relations'=>true];
		$md=[
		'nombre'=>'Item',
		'columna'=>'tbl_item_bim'
		];
		$check['llaves']=[
			['clase'=>'Marca','columna'=>'tbl_marca_nombre','valor'=>'No asignado'],
			['clase'=>'Familia','columna'=>'tbl_familia_nombre','valor'=>'No asignado'],
			['clase'=>'Categoriaitem','columna'=>'tbl_categoriaitem_nombre','valor'=>'Inventory']
		]; 
		$check['update']=false;
		$this->proccessglobal(['0','1','5','6','11']);
		$depurar=array_map(function($v){return [$v[1],$v[2],$v[4],$v[3]];},$this->linesglobal);
	    $depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
	    $uploadmaster->cargapruebacsv($depurar, $columns, $check,$md);
		$inventory=new Inventario();
		$depurar=array_map(function($v){return [$v[0],$v[1],$v[3]];},$this->linesglobal);
	    $depurar=array_map("unserialize",array_unique(array_map('serialize',$depurar)));
		$inventory->cargalista($depurar); 
		return true;
	}
		public function uploadlista() {
		$this->proccessgloballista(['7','3','4','22','23','41','42','61','62','1','15','16','12','21','34','35','31','40','53','54','50','59','72','73','69','5','6','11','13']);
		$uploadmaster= new Modelcustomfunction();
		$precio=new Precio();
		$columns=[
		'db'=>['tbl_marca_nombre'],
		'iteracion'=>[['column'=>'tbl_marca_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],]];
		$md=['nombre'=>'Marca','columna'=>'tbl_marca_nombre'];
		$cargamarca=array_map(function($v){return [$v[0]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$uploadmaster->cargapruebacsv($cargamarca, $columns,['relations'=>false,'update'=>false,'item'=>true],$md);
		$columns=[
		'db'=>['tbl_proveedor_numero','tbl_proveedor_nombre'],
		'iteracion'=>[['column'=>'tbl_proveedor_numero','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],['column'=>'tbl_proveedor_nombre','csv'=>1,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],]];
		$md=['nombre'=>'Proveedor','columna'=>'tbl_proveedor_numero'];
		$cargamarca=array_map(function($v){return [$v[1],$v[2]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$uploadmaster->cargapruebacsv($cargamarca, $columns, ['relations'=>false,'update'=>false,'item'=>true],$md);
		$cargamarca=array_map(function($v){return [$v[3],$v[4]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$uploadmaster->cargapruebacsv($cargamarca, $columns, ['relations'=>false,'update'=>false,'item'=>true],$md);
		$cargamarca=array_map(function($v){return [$v[5],$v[6]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$uploadmaster->cargapruebacsv($cargamarca, $columns, ['relations'=>false,'update'=>false,'item'=>true],$md);
		$cargamarca=array_map(function($v){return [$v[7],$v[8]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$uploadmaster->cargapruebacsv($cargamarca,$columns, ['relations'=>false,'update'=>false,'item'=>true],$md);
		$columns=['db'=>['tbl_precio_precio','tbl_item_id_item','tbl_moneda_id_moneda','tbl_proveedor_id_proveedor','tbl_precio_opcion','tbl_precio_unidadcompra'],
		'iteracion'=>[['column'=>'tbl_precio_precio','csv'=>'2','relacion'=>false,'filter'=>FILTER_SANITIZE_NUMBER_FLOAT ,'flag'=>FILTER_FLAG_ALLOW_FRACTION],['column'=>'tbl_item_id_item','csv'=>'0','relacion'=>false,'filter'=>FILTER_SANITIZE_NUMBER_INT,'flag'=>''],
		['column'=>'tbl_moneda_id_moneda','csv'=>'3','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],['column'=>'tbl_proveedor_id_proveedor','csv'=>'1','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_precio_opcion','csv'=>'5','relacion'=>false,'filter'=>FILTER_SANITIZE_NUMBER_INT,'flag'=>''],['column'=>'tbl_precio_unidadcompra','csv'=>'4','relacion'=>false,'filter'=>FILTER_SANITIZE_NUMBER_INT,'flag'=>''],]];
		$id=1;
		$opcion=1;
		$carga=array_map(function($v){ return [$v[9],$v[1],$v[10],$v[11],$v[12]];},$this->linesglobal);
		$carga=array_map("unserialize",array_unique(array_map('serialize',$carga)));
		$precio->cargacsv($carga, $columns,['relations'=>true,'update'=>false],$id,$opcion);
		$carga2=[];
		$id=21;
		$opcion=2;	
		$carga=array_map(function($v){ return [$v[13],$v[3],$v[14],$v[15],$v[16]];},$this->linesglobal);
		$carga=array_map("unserialize",array_unique(array_map('serialize',$carga)));
		$precio->cargacsv($carga, $columns,['relations'=>true,'update'=>false],$id,$opcion);
		$carga2=[];
		$id=40;
		$opcion=3;
		$carga=array_map(function($v){ return [$v[17],$v[5],$v[18],$v[19],$v[20]];},$this->linesglobal);
		$carga=array_map("unserialize",array_unique(array_map('serialize',$carga)));
		$precio->cargacsv($carga, $columns,['relations'=>true,'update'=>false],$id,$opcion);
		$carga2=[];
		$id=60;
		$opcion=4;
		$carga=array_map(function($v){ return [$v[21],$v[7],$v[22],$v[23],$v[24]];},$this->linesglobal);
		$carga=array_map("unserialize",array_unique(array_map('serialize',$carga)));
		$precio->cargacsv($carga, $columns,['relations'=>true,'update'=>false],$id,$opcion);
		unset($precio);
		unset($carga2);
		$cargamarca=array_map(function($v){ return [$v[9],$v[25],$v[26],$v[0],$v[27],$v[28]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$columns=['csv'=>['1','5','6','7','11','13'],'iteracion'=>[
		['column'=>'tbl_item_nombre','csv'=>'1','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_item_noParte','csv'=>'2','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_marca_id_marca','csv'=>'3','relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_item_unidadmedida','csv'=>'4','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_item_eprocurement','csv'=>'5','relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_familia_id_familia','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_categoriaitem_id_categoriaitem','csv'=>false,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],]];
	
		$md=[
		'nombre'=>'Item',
		'columna'=>'id_item'
		];
		$checkitem=[
		'relations'=>true,
		'update'=>true,
		'lista'=>false,
		'llaves'=>[
			['clase'=>'Marca','columna'=>'tbl_marca_nombre','valor'=>'No asignado'],
			['clase'=>'Familia','columna'=>'tbl_familia_nombre','valor'=>'No asignado'],
			['clase'=>'Categoriaitem','columna'=>'tbl_categoriaitem_nombre','valor'=>'Inventory']
			]
		]; 
		return $uploadmaster->cargapruebacsv($cargamarca, $columns, $checkitem,$md);
		//return $this->linesglobal;
	}
	public function cargartr(){
		$carga=$this->id_archivo;
		$uploadmaster= new Modelcustomfunction;
		$columns=[
		'db'=>['tbl_proveedor_nombre'],
		'iteracion'=>[
		['column'=>'tbl_proveedor_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]
		];
		$md=[
		'nombre'=>'Proveedor',
		'columna'=>'tbl_proveedor_nombre'
		];
		$cargacompras=$this->proccessfilter(['0'],['colum'=>'4','value'=>'REFACCION']);
		$uploadmaster->cargapruebacsv($cargacompras, $columns, ['relations'=>false,'update'=>false],$md);
		$columns=[
		'db'=>['tbl_compras_entrega','tbl_compras_fechaentrega','tbl_compras_factura','tbl_proveedor_id_proveedor','tbl_user_id_user'],
		'iteracion'=>[
		['column'=>'tbl_compras_entrega','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_compras_fechaentrega','csv'=>1,'relacion'=>false,'filter'=>'date','flag'=>''],
		['column'=>'tbl_compras_factura','csv'=>2,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_proveedor_id_proveedor','csv'=>3,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_user_id_user','csv'=>0,'relacion'=>true,'variable'=>'1','filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		]
		];
		$md=[
		'nombre'=>'Compras',
		'columna'=>'tbl_compras_entrega'
		];
		$checkrtr=[
		'relations'=>true,
		'update'=>false,
		'llaves'=>[
			['clase'=>'Proveedor','columna'=>'tbl_proveedor_nombre','valor'=>'No asignado'],
			['clase'=>'User','columna'=>'tbl_user_nombre','valor'=>'No asignado']
			]
		]; 
		$cargacompras=$this->proccessfilter(['7','8','1','0'],['colum'=>'4','value'=>'REFACCION']);
		$uploadmaster->cargapruebacsv($cargacompras, $columns,$checkrtr,$md);
		$columns=[
		'db'=>['tbl_compras_id_compras','tbl_item_id_item','tbl_requisiciones_id_requisiciones','tbl_compras_has_tbl_item_cantidad','tbl_compras_has_tbl_item_precio'],
		'iteracion'=>[
		['column'=>'tbl_compras_id_compras','csv'=>0,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_item_id_item','csv'=>1,'relacion'=>true,'aux'=>4,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_requisiciones_id_requisiciones','csv'=>0,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_compras_has_tbl_item_cantidad','csv'=>2,'relacion'=>false,'filter'=>FILTER_SANITIZE_NUMBER_FLOAT ,'flag'=>FILTER_FLAG_ALLOW_FRACTION],
		['column'=>'tbl_compras_has_tbl_item_precio','csv'=>3,'relacion'=>FALSE,'filter'=>FILTER_SANITIZE_NUMBER_FLOAT ,'flag'=>FILTER_FLAG_ALLOW_FRACTION],
		]
		];
		$md=[
		'nombre'=>'Compras',
		'columna'=>'tbl_compras_entrega',
		'nombretabla'=>'ComprasHasTblItem'
		];
		$checkrtr=[
		'relations'=>true,
		'update'=>false,
		'llaves'=>[
			['clase'=>'Compras','columna'=>'tbl_compras_entrega','valor'=>'No asignado'],
			['clase'=>'Item','columna'=>'tbl_item_bim','valor'=>'No asignado'],
			['clase'=>'Requisiciones','columna'=>'tbl_requisiciones_nombre','valor'=>'No asignado'],
			]
		]; 
		$cargacompras=$this->proccessfilter(['7','2','11','12','5'],['colum'=>'4','value'=>'REFACCION']);
		return $uploadmaster->cargapruebamuchoscsv($cargacompras, $columns,$checkrtr,$md);
	}
	public function salidas(){
	$salida="Salidas.xlsx";
	$autoid=1;
	$objReader = \PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/Salidas.xls");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', \PHPExcel_Shared_Date::PHPToExcel(time()));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', $autoid);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A4', \PHPExcel_Shared_Date::PHPToExcel(time()));
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M3', $autoid);
        $i = 7;
        $j=1;
        $k=7;    	
	$items=Transaccionrefaccion::find()->select(['id_transaccionrefaccion','mod_transaccionrefaccion_louder','tbl_item_id_item','mod_transaccionrefaccion_tagid','mod_transaccionrefaccion_date,tbl_maquina_id_maquina,tbl_user_id_user,tbl_usorefaccion_id_usorefaccion,Sum(mod_transaccionrefaccion_piezas) as sumacount'])
	->where(["mod_transaccionrefaccion_louder"=>0])->groupBy(['mod_transaccionrefaccion_date','tbl_item_id_item'])->all();	    	
	$item=new Transaccionrefaccion();
	foreach($items as $item){
	$orgaid= new Inventario();	
	$org=explode("E", $item->mod_transaccionrefaccion_tagid);
	$orgid=substr($org[1],0,1);
	$orgaid=$orgaid->nombreinventario($orgid);
	if($j<10){
            $reng='R=0'.$j;
        }else{
            $reng='R='.$j;
        }
		if($item->tblMaquinaIdMaquina->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre=="Empaque"){
			$empaque="x";
		}else{
			$empaque="";
		}
		if($item->tblMaquinaIdMaquina->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre=="Proceso"){
			$proceso="x";
		}else{
			$proceso="";
		}
		$env="";
		if($item->tblMaquinaIdMaquina->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre=="Empaque"){
			 $env="ENV ";
		}
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $j)
        		    ->setCellValue('B'.$i,  $item->tblItemIdItem->tbl_item_bim )//item
                    ->setCellValue('C'.$i,  $item->sumacount)//cantidad
        		    ->setCellValue('D'.$i,  $item->tblItemIdItem->tbl_item_nombre)//descripcion
        		    ->setCellValue('E'.$i,  $item->tblMaquinaIdMaquina->tbl_maquina_descripcion)//maquina
                    ->setCellValue('F'.$i,  $empaque)//empaque
                    ->setCellValue('G'.$i,  $proceso)//proceso
        		    ->setCellValue('H'.$i,  strtoupper($item->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_siglas))//linea
        		    ->setCellValue('I'.$i,  $item->tblUserIdUser->tbl_user_nombre)//mecanico
        		    ->setCellValue('J'.$i,  $item->mod_transaccionrefaccion_date)//fecha
        		    ->setCellValue('K'.$i,  "")//regresa si
            		->setCellValue('L'.$i,  "")// regresa no
            		->setCellValue('M'.$i,  "");//existencia despues de consumo
            		
            		$objPHPExcel->setActiveSheetIndex(1)->insertNewRowBefore($i+1,1)
            		->setCellValue('A'.$i, $j)
        		    ->setCellValue('B'.$i,  $item->tblItemIdItem->tbl_item_bim )
                    ->setCellValue('C'.$i,  $item->tblItemIdItem->tbl_item_nombre)
                    ->setCellValue('D'.$i,  $item->sumacount)//locator
        		    ->setCellValue('E'.$i,  $item->tblItemIdItem->tbl_item_almacen)//locator
        		    ->setCellValue('F'.$i,  "")
                    ->setCellValue('G'.$i,  $autoid.', '.$reng.', '.$item->tblMaquinaIdMaquina->tbl_maquina_descripcion.', '.$item->tblUserIdUser->tbl_user_nombre)//excel
                    ->setCellValue('H'.$i,  'REFACCION-Atzcapotzalco')//source
        		    ->setCellValue('I'.$i,  $autoid)//hoja numero
        		    ->setCellValue('J'.$i,  $reng)//renglon
        		    ->setCellValue('K'.$i, strtoupper($item->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_siglas))
        		    ->setCellValue('L'.$i,  "")//existencia despues de consumo
            		->setCellValue('M'.$i,  $item->tblMaquinaIdMaquina->tbl_maquina_descripcion)
            		->setCellValue('N'.$i,  $item->tblUserIdUser->tbl_user_nombre);
                    
                    $objPHPExcel->setActiveSheetIndex(2)->insertNewRowBefore($k+1,1)
                    ->setCellValue('A'.$k, 'R'.$j)
        		    ->setCellValue('B'.$k, '1')
					->setCellValue('C'.$k, '')
					->setCellValue('D'.$k, 'TAB')
                    ->setCellValue('E'.$k, 'Account alias issue ')
                    ->setCellValue('F'.$k, 'TAB')//locator
        		    ->setCellValue('G'.$k,  'REFAC-'.$env.strtoupper($item->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_siglas))//locator
        		    ->setCellValue('H'.$k, 'ENT')
                    ->setCellValue('I'.$k,  $item->tblItemIdItem->tbl_item_bim)//ITEM
				    ->setCellValue('J'.$k, 'TAB')//excel
                    ->setCellValue('K'.$k, 'REF')
        		    ->setCellValue('L'.$k, 'TAB')//hoja numero
        		    ->setCellValue('M'.$k,  $item->tblItemIdItem->tbl_item_almacen)
        		    ->setCellValue('N'.$k, 'TAB')
            		->setCellValue('O'.$k, 'TAB')
            		->setCellValue('P'.$k,  $item->sumacount)
            		->setCellValue('Q'.$k, 'TAB')
            		->setCellValue('R'.$k, "TAB")
            		->setCellValue('S'.$k, 'TAB')
					->setCellValue('T'.$k, 'TAB')
            		->setCellValue('U'.$k,  'SALIDA, '.$reng.', '.$item->tblMaquinaIdMaquina->tbl_maquina_descripcion.', '.$item->tblUserIdUser->tbl_user_nombre)
            		->setCellValue('V'.$k, '*DN')
            		->setCellValue('W'.$k, '*SAVE')
            		->setCellValue('X'.$k, 'ENT')//excel
            		->setCellValue('Y'.$k, '\{F4}')//excel
					->setCellValue('Z'.$k, $orgaid);//excel
                    $k++;
                    $i++;
                    $j++;                                                                                          
			$item->Louderupdate($item->id_transaccionrefaccion);
        }
		$objPHPExcel->getActiveSheet(1)->removeRow($i,1);
        $objPHPExcel->getActiveSheet(2)->removeRow($k,1);
        // Export to Excel2007 (.xlsx)
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objWriter->save($salida);
        return $salida;
	}

	public function salidastiempo(){
	$salida="itemsnoasignados.xls";
	$autoid=1;
	$objReader = \PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/itemsnoasignados.xls");
        $i = 2;
        $j=1;
        $k=7;    	
	$items=Transaccionrefaccion::find()->select(['id_transaccionrefaccion','mod_transaccionrefaccion_louder','tbl_item_id_item','mod_transaccionrefaccion_tagid','mod_transaccionrefaccion_date','tbl_maquina_id_maquina','tbl_user_id_user','tbl_usorefaccion_id_usorefaccion','Sum(mod_transaccionrefaccion_piezas) as sumacount'])
	->where(['BETWEEN','mod_transaccionrefaccion_date',new Expression('DATE_SUB(NOW(), INTERVAL 24 HOUR)'),new Expression('NOW()')])->andWhere(['tbl_maquina_id_maquina'=>0,'tbl_usorefaccion_id_usorefaccion'=>0])->groupBy(['mod_transaccionrefaccion_date','tbl_item_id_item'])->all();	    	
	$item=new Transaccionrefaccion();
	//$query=Transaccionrefaccion::find()->select(['id_transaccionrefaccion','mod_transaccionrefaccion_louder','tbl_item_id_item','mod_transaccionrefaccion_tagid','mod_transaccionrefaccion_date','tbl_maquina_id_maquina','tbl_user_id_user','tbl_usorefaccion_id_usorefaccion','Sum(mod_transaccionrefaccion_piezas) as sumacount'])
	//->where(['BETWEEN','mod_transaccionrefaccion_date',new Expression('DATE_SUB(NOW(), INTERVAL 24 HOUR)'),new Expression('NOW()')],['tbl_maquina_id_maquina'=>0,'tbl_usorefaccion_id_usorefaccion'=>0])->groupBy(['mod_transaccionrefaccion_date','tbl_item_id_item']);
	//$sql=$query->createCommand()->getRawSql();
	foreach($items as $item){
	           $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $item->tblItemIdItem->tbl_item_bim)
        		    ->setCellValue('B'.$i,  strtoupper($item->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_siglas))//item
                    ->setCellValue('C'.$i,  $item->tblMaquinaIdMaquina->tbl_maquina_descripcion)//cantidad
        		    ->setCellValue('D'.$i,  $item->mod_transaccionrefaccion_date)//descripcion
        		    ->setCellValue('E'.$i,  $item->sumacount)//maquina
                    ->setCellValue('F'.$i,  $item->tblUsorefaccionIdUsorefaccion->tbl_usorefaccion_nombre)//empaque
                    ->setCellValue('G'.$i,  $item->tblUserIdUser->tbl_user_nombre);
					//->setCellValue('H'.$i,  $sql);
            		$i++;
        }
		// Export to Excel2007 (.xlsx)
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objWriter->save($salida);
        return $salida;
	}

	public function devolucion(){
		$salida="Devoluciones.xlsx";
        	
		$items=Devoluciones::find()->all();	    	
		
		$autoid=1;
		$objReader = \PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("templates/Devoluciones.xls");
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', \PHPExcel_Shared_Date::PHPToExcel(time()));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', $autoid);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A4', \PHPExcel_Shared_Date::PHPToExcel(time()));
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M3', $autoid);
        $i = 7;
        $j=1;
        $k=7;
		$item=new Devoluciones();
		foreach ($items as $item) {
        $orgaid= new Inventario();	
        $org=explode("E", $item->tbl_devolucion_tagid);
		$orgid=substr($org[1],0,1);
		$orgaid=$orgaid->nombreinventario($orgid);
        if($j<10){
            $reng='R=0'.$j;
        }else{
            $reng='R='.$j;
        }
		if($item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre=="Empaque"){
			$empaque="x";
		}else{
			$empaque="";
		}
		if($item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre=="Proceso"){
			$proceso="x";
		}else{
			$proceso="";
		}
		$env="";
		if($item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tblUbicacionfisicaIdUbicacionfisica->tbl_ubicacionfisica_nombre=="Empaque"){
			 $env="ENV ";
		}
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $j)
        		    ->setCellValue('B'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_bim)//item
                    ->setCellValue('C'.$i,  $item->sumacount)//cantidad
        		    ->setCellValue('D'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_nombre)//descripcion
        		    ->setCellValue('E'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tbl_maquina_bim)//maquina
                    ->setCellValue('F'.$i,  $empaque)//empaque
                    ->setCellValue('G'.$i,  $proceso)//proceso
        		    ->setCellValue('H'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_nombre)//linea
        		    ->setCellValue('I'.$i,  $item->tblUserIdUser->tbl_user_nombre)//mecanico
        		    ->setCellValue('J'.$i,  $item->tbl_devolucion_date)//fecha
        		    ->setCellValue('K'.$i,  "")//regresa si
            		->setCellValue('L'.$i,  "")// regresa no
            		->setCellValue('M'.$i,  "");//existencia despues de consumo

            $objPHPExcel->setActiveSheetIndex(1)->insertNewRowBefore($i+1,1)
                    ->setCellValue('A'.$i, $j)
        		    ->setCellValue('B'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_bim)
                    ->setCellValue('C'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_nombre)
                    ->setCellValue('D'.$i,  "")//locator
        		    ->setCellValue('E'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_almacen)//locator
        		    ->setCellValue('F'.$i,  $item->sumacount)
                    ->setCellValue('G'.$i,  $autoid.', '.$reng.', '.$item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tbl_maquina_bim.', '.$item->tblUserIdUser->tbl_user_nombre)//excel
                    ->setCellValue('H'.$i,  "Refaccion".'-'."atzcapotzalco")//source
        		    ->setCellValue('I'.$i,  $autoid)//hoja numero
        		    ->setCellValue('J'.$i,  $reng)//renglon
        		    ->setCellValue('K'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_nombre)
        		    ->setCellValue('L'.$i,  "")
            		->setCellValue('M'.$i,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tbl_maquina_bim)
            		->setCellValue('N'.$i,  $item->tblUserIdUser->tbl_user_nombre);
			
			$objPHPExcel->setActiveSheetIndex(2)->insertNewRowBefore($k+1,1)
                    ->setCellValue('A'.$k, 'R'.$j)
        		    ->setCellValue('B'.$k, '1')
					->setCellValue('C'.$k, '')
					->setCellValue('D'.$k, 'TAB')
                    ->setCellValue('E'.$k, 'Account alias receipt')
                    ->setCellValue('F'.$k, 'TAB')//locator
        		    ->setCellValue('G'.$k,  'REFAC-'.$env.strtoupper($item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tblLineaIdLinea->tbl_linea_siglas))//locator
        		    ->setCellValue('H'.$k, 'ENT')
                    ->setCellValue('I'.$k,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_bim)//ITEM
				    ->setCellValue('J'.$k, 'TAB')//excel
                    ->setCellValue('K'.$k, 'REF')
        		    ->setCellValue('L'.$k, 'TAB')//hoja numero
        		    ->setCellValue('M'.$k,  $item->modTransaccionrefaccionIdTransaccionrefaccion->tblItemIdItem->tbl_item_almacen)
        		    ->setCellValue('N'.$k, 'TAB')
            		->setCellValue('O'.$k, 'TAB')
            		->setCellValue('P'.$k,  $item->sumacount)
            		->setCellValue('Q'.$k, 'TAB')
            		->setCellValue('R'.$k, "TAB")
            		->setCellValue('S'.$k, 'TAB')
					->setCellValue('T'.$k, 'TAB')
            		->setCellValue('U'.$k,  'Devolucion, '.$reng.', '.$item->modTransaccionrefaccionIdTransaccionrefaccion->tblMaquinaIdMaquina->tbl_maquina_descripcion.', '.$item->tblUserIdUser->tbl_user_nombre)
            		->setCellValue('V'.$k, '*DN')
            		->setCellValue('W'.$k, '*SAVE')
            		->setCellValue('X'.$k, 'ENT')//excel
            		->setCellValue('Y'.$k, '\{F4}')//excel
					->setCellValue('Z'.$k, $orgaid);//excel
					
                    $k++;
                    $i++;
                    $j++;
				
				$item->tbl_devolucion_louder=1;
				$item->save();
        }
        $objPHPExcel->getActiveSheet(1)->removeRow($i,1);
        $objPHPExcel->getActiveSheet(2)->removeRow($k,1);
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objWriter->save($salida);
		return $salida;
	}
	
	public function uploadfamilia(){
		set_time_limit(300);	
		$this->proccessglobal(['0','1','2'],$page=0);
		$uploadmaster= new Modelcustomfunction;
		$columns=[
		'db'=>['tbl_catfamilia_nombre'],
		'iteracion'=>[['column'=>'tbl_catfamilia_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],]];
		$md=['nombre'=>'Catfamilia','columna'=>'tbl_catfamilia_nombre'];
		$cargamarca=array_map(function($v){return [$v[0]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$uploadmaster->cargapruebacsv($cargamarca, $columns,['relations'=>false,'update'=>false,'lista'=>false],$md);
		$columns=[                          
		'db'=>['tbl_familia_nombre','tbl_familia_siglas','tbl_catfamilia_id_catfamilia'],
		'iteracion'=>[['column'=>'tbl_familia_nombre','csv'=>0,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_familia_siglas','csv'=>1,'relacion'=>false,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],
		['column'=>'tbl_catfamilia_id_catfamilia','csv'=>2,'relacion'=>true,'filter'=>FILTER_SANITIZE_STRING,'flag'=>''],]];
		$md=['nombre'=>'Familia','columna'=>'tbl_familia_nombre'];
		$cargamarca=array_map(function($v){return [$v[2],$v[1],$v[0]];},$this->linesglobal);
		$cargamarca=array_map("unserialize",array_unique(array_map('serialize',$cargamarca)));
		$checkitem=[
		'relations'=>true,
		'update'=>false,
		'lista'=>false,
		'llaves'=>[
			['clase'=>'Catfamilia','columna'=>'tbl_catfamilia_nombre','valor'=>'No asignado'],
			]
		]; 
		return $uploadmaster->cargapruebacsv($cargamarca, $columns, $checkitem,$md);
	}
}
