<?php
namespace app\controllers;

use Yii;

class Impresora
{
	
		
	public function impresionuser($impre){
	$archivo=fopen(Yii::$app->basePath."/config/impresora.txt", "r");
		while(!feof($archivo)){
			$impresora=fgets($archivo);
		}
		fclose($archivo);	  	
		$idprint=$idprint=$impre['id'].'f'.bin2hex($impre['mecanico']);
		$idprint=substr($idprint,0,11);
		$string="
﻿	^XA
	^RS,,,3,N
	^RR10
	^XZ
	^XA
	^SZ2^JMA
	^MCY^PMN
	^PW795
	^MTT
	^MNW
	~JSN
	^MD3
	^JZY
	^LH0,0^LRN
	^XZ
	^XA
	^FT45,60
	^A0N,20,32^FDGrupo Bimbo^FS
	^FT45,143
	^A0N,20,32^FD".$impre['mecanico']."^FS
	^FT45,107
	^A0N,20,32^FD".$impre['Jefe']."^FS
	^FT40,179
	^A0N,20,32^FDEtiqueta de Usuario^FS
	^FT620,179
	^A0N,20,32^FD Prueba ^FS
	^RFW,H,1,2,1^FD1C00^FS
	^RFW,H,2,5,1^FDe".$idprint."^FS
	^PQ.1,0,1,Y
	^XZ
	";
	$printer=$impresora;
	$fp=fopen($printer, 'w');
	fwrite($fp,$string);
	fclose($fp);
	}
public function impresionitem($impre){
	$archivo=fopen(Yii::$app->basePath."/config/impresora.txt", "r");
		while(!feof($archivo)){
			$impresora=fgets($archivo);
		}
		fclose($archivo);	  	
	$idprint=$impre['id'].'e'.$impre['inventario'].ltrim(str_replace('-','',$impre['bim']));
	$idprint=substr($idprint,0,12);
	$string="
﻿	^XA
	^RS,,,3,N
	^RR10
	^XZ
	^XA
	^SZ2^JMA
	^MCY^PMN
	^PW795
	^MTT
	^MNW
	~JSN
	^MD3
	^JZY
	^LH0,0^LRN
	^XZ
	^XA
	^FT45,60
	^A0N,20,32^FD".$impre['descripcion']."^FS
	^FT45,143
	^A0N,20,32^FD".$impre['noparte']."^FS
	^FT45,107
	^A0N,20,32^FD".$impre['bim']."^FS
	^FT40,179
	^A0N,20,32^FD".$impre['almacen']."^FS
	^FT620,179
	^A0N,20,32^FD".$impre['marca']."^FS
	^RFW,H,1,2,1^FD1C00^FS
	^RFW,H,2,5,1^FD".$idprint."^FS
	^PQ.1,0,1,Y
	^XZ
	";
	$printer=$impresora;
	$fp=fopen($printer, 'w');
	fwrite($fp,$string);
	fclose($fp);
	}
}