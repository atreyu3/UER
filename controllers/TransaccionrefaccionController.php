<?php
namespace app\controllers;

use Yii;
use app\models\Transaccionrefaccion;
use app\models\TransaccionrefaccionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Item;
use app\models\User;
use yii\filters\AccessControl;
use app\models\LoginForm;
/**
 * TransaccionrefaccionController implements the CRUD actions for Transaccionrefaccion model.
 */
class TransaccionrefaccionController extends Controller {
	public function behaviors() {
		return ['access' => ['class' => AccessControl::className(), 'only' => ['index', 'create', 'view', 'update', 'reporte'], 'rules' => [['actions' => [ 'index','view', 'create', 'update', 'reporte'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function($rule, $action) {
			if (Yii::$app -> User -> identity -> tblCategoriauserIdCategoriauser -> tbl_categoriauser_nombre == "Administrador" or Yii::$app -> User -> identity -> tblCategoriauserIdCategoriauser -> tbl_categoriauser_nombre == "Almacenista" or Yii::$app -> User -> identity -> tblCategoriauserIdCategoriauser -> tbl_categoriauser_nombre == "Jefe de mecanico")
				return true;
			else
				return false;
		}, ]]], 'verbs' => ['class' => VerbFilter::className(), 'actions' => ['delete' => ['post'], ], ], ];
	}

	/**
	 * Lists all Transaccionrefaccion models.
	 * @return mixed
	 */
	public function actionIndex() {
		$this -> confirmacionsalidas();
		$searchModel = new TransaccionrefaccionSearch();
		$dataProvider = $searchModel -> search(Yii::$app -> request -> queryParams);
		$model = new Transaccionrefaccion();
		return $this -> render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model, ]);
	}
	
	/**
	 * Lista todos los registros sin linea ni maquina .
	 * @return mixed
	 */
	public function actionSinregistrar() {
		$this -> confirmacionsalidas();
		$searchModel = new TransaccionrefaccionSearch();
		$dataProvider = $searchModel -> search(Yii::$app -> request -> queryParams);
		$model = new Transaccionrefaccion();
		return $this -> render('sinregistrar', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model, ]);
	}
	private function confirmacionsalidas() {
		$salidas = \app\models\Transaccionrefaccion::find() -> where(['mod_transaccionrefaccion_confirmado' => 0]) -> all();
		foreach ($salidas as $key => $salida) {
			if ($salida_antena_1 = \app\models\Read::find() -> where(['id_read' => $salida -> mod_transaccionrefaccion_antena1]) -> one()) {
				if ($salida_antena_4 = \app\models\Read::find() -> where(['tbl_read_antena' => 4, 'tbl_read_tagid' => $salida -> mod_transaccionrefaccion_tagid, 'tbl_readusuario_id_readusuario' => $salida_antena_1 -> tbl_readusuario_id_readusuario]) -> one()) {
					$salida_antena_4 -> tbl_read_activo = 0;
					if ($salida_antena_4 -> save()) {
						$salida -> mod_transaccionrefaccion_confirmado = 1;
						$salida -> mod_transaccionrefaccion_antena4 = $salida_antena_4 -> id_read;
						$salida -> save();
					}
				}
			}
		}
	}

	public function actionReporte() {
		$searchModel = new TransaccionrefaccionSearch();
		$dataProvider = $searchModel -> searchreporte(Yii::$app -> request -> queryParams);
		$model = new Transaccionrefaccion();
		return $this -> render('reporte', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model]);
	}

	public function actionReportejecutivo() {
		$searchModel = new TransaccionrefaccionSearch();
		$dataProvider = $searchModel -> searchreporte(Yii::$app -> request -> queryParams);
		$model = new Transaccionrefaccion();
		return $this -> render('reportejecutivo', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model]);
	}

	public function limpia($tring) {
		$tring = str_replace(' ', '', $tring);
		$tring = str_replace('A', '', $tring);
		$tring = str_replace('F', '', $tring);
		return $tring;
	}

	/**
	 * Lists all Transaccionrefaccion models.
	 * @return mixed
	 */
	public function actionTransaccionv() {
		$userip = Yii::$app -> request -> userIP;
		if ($userip == "127.0.0.1") {
			Yii::$app -> user -> logout();
			$model = new Transaccionrefaccion();
			$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1, 'tbl_readusuario_activoweb' => 1]) -> one();
			if (isset($readusuario -> id_readusuario)) {
				$reads = \app\models\Read::find() -> where(['tbl_readusuario_id_readusuario' => $readusuario -> id_readusuario, 'tbl_read_antena' => 1, 'tbl_read_activo' => 1]) -> all();
				foreach ($reads as $read) {
					if ($model -> Tagunico($read -> tbl_read_tagid) == true) {
						if (is_numeric($read -> tbl_read_tagid)) {
							$it5 = explode("E", $read -> tbl_read_tagid);
							if (is_array($it5))
								$Item[] = $it5[0];
						}
					}
				}

				$r = substr($readusuario -> tbl_readusuario_tagid, 0, 1);
				if ($r == 'E') {
					$i = explode("F", $readusuario -> tbl_readusuario_tagid);
					$nombre = str_replace('E', '', $i[0]);
				}
				if (isset($Item)) {
					$unicos = array_unique($Item);
					$aux = array();
					foreach ($unicos as $unico) {
						foreach ($Item as $ite) {
							if ($unico == $ite) {
								if (array_key_exists($unico, $aux)) {
									$aux[$unico]["cont"]++;
								} else {
									$aux[$unico]["cont"] = 1;
								}
							}
						}
					}
				}
				$model = new Transaccionrefaccion();
				$item = new Item();
			}else{
				$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1, 'tbl_readusuario_activoweb' => 0]) -> one();
				if (isset($readusuario -> id_readusuario)) {
					$readusuario->tbl_readusuario_activo=0;
					$readusuario->save();
				}
			}
			//$this->layout = 'publico';
			if (isset($nombre)) {
				$usuario = User::find() -> where(['id_user' => $nombre]) -> one();
				$user = new \app\models\LoginForm();
				if ($usuario) {
					$user -> login2($usuario);
				}
			}
			if (isset($aux) and isset($usuario)) {
				return $this -> render('transaccionv', ['model' => $model, 'rfid' => $aux, 'item' => $item, 'usuarioaux' => 1]);
			} else {
				return $this -> render('usuariono', ['usuarioaux' => "cambiarusuario"]);
			}
		}
	}

	public function actionRecargarusuario() {
		$devolucion=new \app\models\Devoluciones();
		$devolucion->devoluciones();
		$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1, 'tbl_readusuario_activoweb' => 1]) -> one();
		if (isset($readusuario -> id_readusuario)) {
			return $this -> redirect(['transaccionv']);
		} else {
			return $this -> redirect(['transaccionv']);
		}
	}

	
	public function idmod($tiempo, $tag, $usuario) {
		$it5 = explode("E", $tag);
		$model = new Transaccionrefaccion();
		$model -> mod_transaccionrefaccion_date = $tiempo;
		$model -> tbl_maquina_id_maquina = 0;
		$model -> tbl_usorefaccion_id_usorefaccion = 0;
		$model -> mod_transaccionrefaccion_piezas = "1";
		$model -> tbl_item_id_item = $it5[0];
		$model -> tbl_user_id_user = $usuario;
		$model -> mod_transaccionrefaccion_tagid = $tag;
		$model -> save();
		return $model -> id_transaccionrefaccion;
	}

	public function actionCambiarusuario() {
		$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1, 'tbl_readusuario_activoweb' => 1]) -> one();
		$readusuario -> tbl_readusuario_activoweb = 0;
		$readusuario -> save();
	}

	public function actionRecargar() {
		$devolucion=new \app\models\Devoluciones();
		$devolucion->devoluciones();
		$userip =Yii::$app -> request -> userIP;
		if ($userip == "127.0.0.1") {
			$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1, 'tbl_readusuario_activoweb' => 1]) -> one();
			if (!isset($readusuario -> id_readusuario)) {
				$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1]) -> one();
				$reads = \app\models\Read::find() -> where(['tbl_readusuario_id_readusuario' => $readusuario -> id_readusuario, 'tbl_read_antena' => 1, 'tbl_read_activo' => 1]) -> all();
				$r = substr($readusuario -> tbl_readusuario_tagid, 0, 1);
				if ($r == 'E') {
					$i = explode("F", $readusuario -> tbl_readusuario_tagid);
					$nombre = str_replace('E', '', $i[0]);
				}
				if (isset($nombre)) {
					$usuario = User::find() -> where(['id_user' => $nombre]) -> one();
				}
				$tiempousuario = $readusuario -> tbl_readusuario_timestamp;
				foreach ($reads as $read) {
					$it5 = explode("E", $read -> tbl_read_tagid);
					if (is_array($it5)) {
						$model = new Transaccionrefaccion();
						$model -> mod_transaccionrefaccion_date = $tiempousuario;
						$model -> tbl_maquina_id_maquina = 0;
						$model -> tbl_usorefaccion_id_usorefaccion = 0;
						$model -> mod_transaccionrefaccion_piezas = "1";
						$model -> tbl_item_id_item = $it5[0];
						$model -> tbl_user_id_user = $usuario -> id_user;
						$model -> mod_transaccionrefaccion_tagid = $read -> tbl_read_tagid;
						$model -> mod_transaccionrefaccion_antena1 = $read -> id_read;
						if ($model -> save()) {
							$read -> tbl_read_activo = 0;
							$read -> save();
						}
					}
				}
				$readusuario -> tbl_readusuario_activo = 0;
				$readusuario -> save();
				return $this -> redirect(['transaccionv']);
			} else {
				$reads = \app\models\Read::find() -> where(['tbl_readusuario_id_readusuario' => $readusuario -> id_readusuario, 'tbl_read_antena' => 1, 'tbl_read_activo' => 1]) -> all();
				$model = new Transaccionrefaccion();
				foreach ($reads as $read) {
					if ($model -> Tagunico($read -> tbl_read_tagid) == true) {
						if (is_numeric($read -> tbl_read_tagid)) {
							$it5 = explode("E", $read -> tbl_read_tagid);
							if (is_array($it5)) {
								$Item[] = $it5[0];
							}
						}
					}
				}
				$aux = array();
				if (isset($Item)) {
					$unicos = array_unique($Item);
					$aux = array();
					foreach ($unicos as $unico) {
						foreach ($Item as $ite) {
							if ($unico == $ite) {
								if (array_key_exists($unico, $aux)) {
									$aux[$unico]["cont"]++;
								} else {
									$aux[$unico]["cont"] = 1;
								}
							}
						}
					}
				}
				$iterator = Yii::$app -> request -> post('id');
				$unicoslenght = count($aux);
				$iteratorlenght = count($iterator);
				$item = new Item();
				$itr = 1;
				foreach ($aux as $key => $value) {
					if ($item -> ides($key) != "no") {
						if ($itr <= $iteratorlenght) {
							if ($key == $iterator[$itr]['id']) {
								if ($iterator[$itr]["count"] != $aux[$key]["cont"]) {
									$agregar['id'] = $key;
									$agregar["count"] = $aux[$key]["cont"];
									$agregar["existe"] = "si";
									$respuestaarray[] = $agregar;
								}
							}
						} else {
							$respuesta["id"] = $key;
							$respuesta["bim"] = $item -> bim($key);
							$respuesta["ides"] = $item -> ides($key);
							$respuesta["noparte"] = $item -> noparte($key);
							$respuesta["description"] = $item -> description($key);
							$respuesta["count"] = $aux[$key]["cont"];
							$respuesta["existe"] = "no";
							$respuestaarray[] = $respuesta;
						}
						$itr++;
					}
				}
				if (isset($respuestaarray))
					return json_encode($respuestaarray);
				else
					return true;
			}
		}
	}

	/**
	 * Displays a single Transaccionrefaccion model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this -> render('view', ['model' => $this -> findModel($id), ]);
	}

	/**
	 * Creates a new Transaccionrefaccion model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Transaccionrefaccion();

		if (Yii::$app -> request -> isAjax) {
			if ($model -> load(Yii::$app -> request -> post()) && $model -> save()) {
				return $this -> redirect(['index']);
			} else {
				return $this -> renderAjax('create', ['model' => $model, ]);
			}
		} else {
			if ($model -> load(Yii::$app -> request -> post()) && $model -> save()) {
				return $this -> redirect(['view', 'id' => $model -> id_transaccionrefaccion]);
			} else {
				return $this -> render('create', ['model' => $model, ]);
			}
		}
	}

	/**
	 * Updates an existing Transaccionrefaccion model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this -> findModel($id);
		if (Yii::$app -> request -> isAjax) {
			if ($model -> load(Yii::$app -> request -> post()) && $model -> save()) {
				return $this -> redirect(['index']);
			} else {
				return $this -> renderAjax('update', ['model' => $model, ]);
			}
		} else {
			if ($model -> load(Yii::$app -> request -> post()) && $model -> save()) {
				return $this -> redirect(['view', 'id' => $model -> id_transaccionrefaccion]);
			} else {
				return $this -> render('update', ['model' => $model, ]);
			}
		}
	}

	/**
	 * Deletes an existing Transaccionrefaccion model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this -> findModel($id) -> delete();
		return $this -> redirect(['index']);
	}

	public function actionLinea($id) {
		$model = new Transaccionrefaccion();
		$maquinas = $model -> Maquinaall($id);
		$html = '';
		foreach ($maquinas as $key => $value) {
			$html .= '<option  value=' . $key . '>' . $value . '</option>';
		}
		$html .= "<script type='text/javascript'>
				$('#mod_transaccionrefaccion_maquina').on('change',function(){
				var nombre=$(this).find('option:selected').text();
				var id=$(this).val();
				if($('#seleccionarto').hasClass('checked')){
			 	$('.bim1').html(nombre);
			 	$('.bim1').attr('maquinaid',$(this).val());
				}else{
					$('[type=checkbox]').each(function () {
    				console.log($(this).attr('item')+'joojo');	
    				if($(this).is(':checked')){
    				$('#'+$(this).attr('item')+' .bim1').html(nombre);
			 		$('#'+$(this).attr('item')+' .bim1').attr('maquinaid',id);
					}
					});
				}
				});
				</script>";
		return $html;
	}

	public function actionLinea2($id) {
		$model = new Transaccionrefaccion();
		$maquinas = $model -> Maquinaall($id);
		$html = '';
		foreach ($maquinas as $key => $value) {
			$html .= '<option value=' . $key . '>' . $value . '</option>';
		}
		return $html;
	}

	public function actionGuardarrefacciones() {
		$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1]) -> one();
		$reads = \app\models\Read::find() -> where(['tbl_read_antena' => 1, 'tbl_readusuario_id_readusuario' => $readusuario -> id_readusuario, 'tbl_read_activo' => 1]) -> all();
		if (isset($readusuario -> id_readusuario)) {
			$i = explode("F", $readusuario -> tbl_readusuario_tagid);
			$nombre = str_replace('E', '', $i[0]);
			if (isset($nombre)) {
				$usuario = User::find() -> where(['id_user' => $nombre]) -> one();
			}
		}
		$item = new Item();
		$tiempousuario = $readusuario -> tbl_readusuario_timestamp;
		$post = Yii::$app -> request -> post();
		$iditem = $post['item'];
		$idmaquina = $post['maquina'];
		$idmantenimiento = $post['mantenimiento'];
		$piezas = $post['piezas'];
		$compararbim = $item -> bim($iditem);
		$compararbim = str_replace("-", "", $compararbim);
		if (isset($usuario)) {
			for ($aux_guardar = 1; $aux_guardar <= $piezas; $aux_guardar++) {
				$model = new Transaccionrefaccion();
				$model -> mod_transaccionrefaccion_date = $tiempousuario;
				$model -> tbl_maquina_id_maquina = $idmaquina;
				$model -> tbl_usorefaccion_id_usorefaccion = $idmantenimiento;
				$model -> mod_transaccionrefaccion_piezas = "1";
				$model -> tbl_item_id_item = $iditem;
				$model -> tbl_user_id_user = $usuario -> id_user;
				$arra2 = [];
				if ($model -> save()) {
					$reads = \app\models\Read::find() -> where(['tbl_read_antena' => 1, 'tbl_readusuario_id_readusuario' => $readusuario -> id_readusuario, 'tbl_read_activo' => 1]) -> all();
					foreach ($reads as $read) {
						$tag = explode("E", strtoupper($read -> tbl_read_tagid));
						if ($tag[0] == $iditem) {
							$tagid = strtoupper($read -> tbl_read_tagid);
							$read -> tbl_read_tagid = strtoupper($read -> tbl_read_tagid);
							$read -> tbl_read_activo = 0;
							$read -> save();
							$model -> mod_transaccionrefaccion_tagid = strtoupper($read -> tbl_read_tagid);
							$model -> mod_transaccionrefaccion_antena1 = $read -> id_read;
							$model -> save();
							break;
						}
					}
				} else {
					//return print_r($model->getErrors());
					return "Maquina o mantenimiento no seleccionado";
				}
			}
			return true;
		} else {
			return "No se encontro usuario";
		}
	}

	public function actionParcial($id) {
		if (Yii::$app -> request -> get()) {
			$tag = new \app\models\Read();
			$readusuario = \app\models\Readusuario::find() -> where(['tbl_readusuario_activo' => 1]) -> one();
			$tag -> tbl_read_tagid = $id . "E1411213123";
			$tag -> tbl_readusuario_id_readusuario = $readusuario -> id_readusuario;
			$tag -> save();
			return true;
		}
	}

	public function actionReportelinea() {
		$searchModel = new TransaccionrefaccionSearch();
		$dataProvider = $searchModel -> searchreportelinea(Yii::$app -> request -> queryParams);
		return $this -> render('reportelinea', ['dataProvider' => $dataProvider, ]);
	}

	/**
	 * Finds the Transaccionrefaccion model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Transaccionrefaccion the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Transaccionrefaccion::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

}
