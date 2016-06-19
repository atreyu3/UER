<?php

namespace app\models;

use Yii;
/* humberto clase customizada para los modelos */
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

class Modelcustomfunction
{
	
  	public function nombre($string){
		$string=explode("_", $string);
		return ucfirst(mb_strtolower(trim($string[1])));
	}
	public function nombrecsv($string,$filter,$filterflag){
		if(is_numeric($string) or $filter===FILTER_SANITIZE_NUMBER_INT){
			$str=filter_var($string,$filter,$filterflag);
		}
		if($filter===FILTER_SANITIZE_STRING or $filter===FILTER_SANITIZE_EMAIL){
		$str=filter_var($string,$filter,$filterflag);	
		//$str=str_replace('.', ' ', $str);
		//$str=ucfirst(mb_strtolower(trim($str)));
		}
		if($filter=="date"){
			$str=date('Y/m/d',strtotime($string));
		}
		if($filter==""){
			$str=$string;
		}
		return $str;
	}
	public function cargacsv($carga,$columns,$check,$model){
	$a=array();
	$bim=1;
	$archivo=Archivo::findOne($carga);
	$bandera=true;
	$namespace='\app\models\\';
	if($check['relations']==true){
	$llaves=$check['llaves'];
	foreach ($llaves as $key => $llave) {
		$llaveclase=$llave['clase'];
		$modeloprovicional=$namespace.$llaveclase;
		$llavecolumna=$llave['columna'];
		$llavevalor=$llave['valor'];
		$nombreprovicional='id_'.strtolower($llaveclase);
		${'id'.mb_strtolower($llaveclase)}=self::checkrelations($llaveclase,$llavecolumna,$llavevalor);
		${$llaveclase}=ArrayHelper::map($modeloprovicional::find()->all(),$nombreprovicional,$llavecolumna);
	}
	}
	if(isset($check['item']) && $check['item']==true)
		$csvlines=$archivo->proccessitem($csv,$bim);
	else 
		$csvlines=$archivo->proccessall($csv);
	if(isset($check['unique']) && $check['unique']=='on_hand')
	$csvlines=self::unique_multidim_array($csvlines, 0,true);
	$columnsaves=$columns['iteracion'];
	$nombremodelo=$namespace.$model['nombre'];
	$nombremodelo=new $nombremodelo();
	$nombrecolumn=$model['columna'];
		foreach ($csvlines as $key=>$csvline) {
		 if($modelo=$nombremodelo::find()->where([$nombrecolumn=>$csvline[0]])->one()){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
						if(isset($columnsave['variable'])){
						$modelo->{$columnsave['column']}=$columnsave['variable'];	
						}else{
						$auux=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);	
						if($modelo->{$columnsave['column']}!=$auux && $auux!=null){
						$modelo->{$columnsave['column']}=($auux==null) ? '' : self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
						}
						}
					}else {
					$id='id'.mb_strtolower(self::nombre($columnsave['column']));
					$tabla=self::nombre($columnsave['column']);
					$csvid=((array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla)) ? array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla) : $$id);
					if($modelo->{$columnsave['column']}!=$csvid)			
					$modelo->{$columnsave['column']}=$csvid;
					}
				}
				$modelo->save();
				unset($modelo);
			 }else{
			 	if(isset($check['update']) && $check['update']!=true){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
			 			if($model['nombre']=='Maquina'){
			 				$au=strtolower(trim($csvline[$columnsave['csv']]));
							if($au==="por codificar")
							$insert[]=uniqid();
							else
							$insert[]=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
			 			}else{
			 				if(isset($columnsave['variable']))
						$insert[]=$columnsave['variable'];
							else
						$insert[]=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
						}
					}else{
					$id='id'.mb_strtolower(self::nombre($columnsave['column']));
					$tabla=self::nombre($columnsave['column']);	
					$insert[]=((array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla)) ? array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla) : $$id);
					}
				}
				$inser[]=$insert;
				//$b[]= $insert;●●●●●●●●
				unset($insert);
				}
			 }
			 	 unset($csvlines[$key]);
		}
		   if(isset($inser)){
		     $connection = Yii::$app->db;
		   	 $transaction = Yii::$app->db->beginTransaction();
			  try{
			  $db=$columns['db'];
			  $command=$connection->createCommand()->batchInsert($nombremodelo::tableName(),$db,$inser)->execute();
			  $transaction->commit();
			   return true;
			   }catch(Exception $e){
				 $transaction->rollback();
			   return $e;
			   }
		 	   }else{
			   return 'todo chidin';
		   }
		  return $inser;
	 }
	public function checkrelations($model,$llavecolumna,$llavevalor)
	{
	$id='id_'.strtolower($model);	
	$namespace='\app\models\\'.$model;	
	if(!$model = $namespace::find()->where([$llavecolumna=>$llavevalor])->one()){
	$model=new $namespace();
	$row=0;	
	foreach ($model->attributes() as $k=>$key) {
			if($row==0)$modelnombre=self::nombre($key);
			if($row>0){
				if(self::nombre($key)==$modelnombre){
				 	if($key==$llavecolumna)
					$model->$llavecolumna=$llavevalor;
				}else{
					$modeloseg=self::nombre($key);
					$columnseg='tbl_'.strtolower($modeloseg).'_nombre';
					$model->$key=self::checkrelations($modeloseg,$columnseg,'No asignado');
				}
			}
			$row++;
		}
		$model->save();
	}
	 	return $model->$id;		
	}
	public function unique_multidim_array($array, $key,$strict=false) {
    $temp_array =array();
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
	public function cargapruebacsv($csvlines,$columns,$check,$model){
	$a=array();
	$bandera=true;
	$folio=false;
	$namespace='\app\models\\';
	if($check['relations']==true){
	$llaves=$check['llaves'];
	foreach ($llaves as $key => $llave) {
		$llaveclase=$llave['clase'];
		$modeloprovicional=$namespace.$llaveclase;
		$llavecolumna=$llave['columna'];
		$llavevalor=$llave['valor'];
		$nombreprovicional='id_'.mb_strtolower($llaveclase);
		${'id'.mb_strtolower($llaveclase)}=self::checkrelations($llaveclase,$llavecolumna,$llavevalor);
		${$llaveclase}=ArrayHelper::map($modeloprovicional::find()->all(),$nombreprovicional,$llavecolumna);
	}
	}
	if($model['nombre']=='Maquina'){
		$folio_maquina=\app\models\Parametro::findOne('FOLIO_MAQUINA');
		$folio_maquina_id=$folio_maquina->VALOR;
		$folio=true;
	}
	$columnsaves=$columns['iteracion'];
	$nombremodelo=$namespace.$model['nombre'];
	$nombremodelo=new $nombremodelo();
	$nombrecolumn=$model['columna'];
			foreach ($csvlines as $key=>$csvline) {
		 if($modelo=$nombremodelo::find()->where([$nombrecolumn=>$csvline[0]])->one()){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
						if(isset($columnsave['variable'])){
						$modelo->{$columnsave['column']}=$columnsave['variable'];	
						}else{
						$auux=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);		
						if($modelo->{$columnsave['column']}!=$auux){
						$modelo->{$columnsave['column']}=($auux==null) ? '' : $auux;
						}
						}
					}else {
					$id='id'.mb_strtolower(self::nombre($columnsave['column']));
					$tabla=self::nombre($columnsave['column']);
					$csvid=((array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla)) ? array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla) : $$id);
					if($modelo->{$columnsave['column']}!=$csvid)			
					$modelo->{$columnsave['column']}=$csvid;
					}
				}
				$modelo->save();
				unset($modelo);
			 }else{
			 	if(isset($check['update']) && $check['update']!=true){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
			 			if($model['nombre']=='Maquina'){
			 				$au=strtolower(trim($csvline[$columnsave['csv']]));
							if($au==="por codificar"){
                                $folio_maquinal='';
							$intnumber=strlen($folio_maquina_id);	
							for($intnumber;$intnumber<6;$intnumber++){
								$folio_maquinal.='0';
							}
							$insert[]='BMS-'.$folio_maquinal.$folio_maquina_id;
							$folio_maquina_id++;	
							}else{
							$insert[]=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
							}
			 			}else{
			 				if(isset($columnsave['variable']))
						$insert[]=$columnsave['variable'];
							else
						$insert[]=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
						}
					}else{
					$id='id'.mb_strtolower(self::nombre($columnsave['column']));
					$tabla=self::nombre($columnsave['column']);	
					$insert[]=((array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla)) ? array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla) : $$id);
					}
				}
				$inser[]=$insert;
				//$b[]= $insert;
				unset($insert);
				}
			 }
			 	 unset($csvlines[$key]);
		}
			if($folio==true){
		  	  $folio_maquina->VALOR="$folio_maquina_id";
			  if(!$folio_maquina->save()){
			  	return $folio_maquina->getErrors();
			  }
			  }
		  if(isset($inser)){
		    $connection = Yii::$app->db;
		    $transaction = Yii::$app->db->beginTransaction();
			  try{
			  $db=$columns['db'];
			  $command=$connection->createCommand()->batchInsert($nombremodelo::tableName(),$db,$inser)->execute();
			  $transaction->commit();
			  return true;
			  }catch(Exception $e){
			  $transaction->rollback();
			  return 'Tienes problemas ';
			  }
		 	  }else{
			  return print_r($csvlines);
		  }
	 return $inser;
	 }
	
	public function cargapruebamuchoscsv($csvlines,$columns,$check,$model){
	$a=array();
	$bandera=true;
	$namespace='\app\models\\';
	if($check['relations']==true){
	$llaves=$check['llaves'];
	foreach ($llaves as $key => $llave) {
		$llaveclase=$llave['clase'];
		$modeloprovicional=$namespace.$llaveclase;
		$llavecolumna=$llave['columna'];
		$llavevalor=$llave['valor'];
		$nombreprovicional='id_'.mb_strtolower($llaveclase);
		${'id'.mb_strtolower($llaveclase)}=self::checkrelations($llaveclase,$llavecolumna,$llavevalor);
		${$llaveclase}=ArrayHelper::map($modeloprovicional::find()->all(),$nombreprovicional,$llavecolumna);
	}
	}
	$columnsaves=$columns['iteracion'];
	$nombremodelo=$namespace.$model['nombre'];
	$nombreacargar=$namespace.$model['nombretabla'];
	$nombremodelo=new $nombremodelo();
	$nombrecolumn=$model['columna'];
		foreach ($csvlines as $key=>$csvline) {
			 	if(isset($check['update']) && $check['update']!=true){
			 	foreach($columnsaves as $columnsave){
			 		if($columnsave['relacion']==false){
			 			if($model['nombre']=='Maquina'){
			 				$au=strtolower(trim($csvline[$columnsave['csv']]));
							if($au==="por codificar")
							$insert[]=uniqid();
							else
							$insert[]=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
			 			}else{
			 				if(isset($columnsave['variable']))
						$insert[]=$columnsave['variable'];
							else
						$insert[]=self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']);
						}
					}else{
					$id='id'.mb_strtolower(self::nombre($columnsave['column']));
					$tabla=self::nombre($columnsave['column']);	
					$col='tbl_'.strtolower(self::nombre($columnsave['column'])).'_nombre';
					if(isset($columnsave['aux']))
					$insert[]=((array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla)) ? array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla) : self::checkrelations($tabla,$col,$csvline[$columnsave['aux']]));
					else
					$insert[]=((array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla)) ? array_search(self::nombrecsv($csvline[$columnsave['csv']],$columnsave['filter'],$columnsave['flag']),$$tabla) : $$id);
					}
				}
				$inser[]=$insert;
				//$b[]= $insert;
				unset($insert);
			 }
			 	 unset($csvlines[$key]);
		}
		  if(isset($inser)){
		    $connection = Yii::$app->db;
		    $transaction = Yii::$app->db->beginTransaction();
			  try{
			  $db=$columns['db'];
			  $command=$connection->createCommand()->batchInsert($nombreacargar::tableName(),$db,$inser)->execute();
			  $transaction->commit();
			  return true;
			  }catch(Exception $e){
			  $transaction->rollback();
			  return 'Tienes problemas ';
			  }
		 	  }else{
			  return print_r($csvlines);
		  }
	 return $inser;
	 }
}
