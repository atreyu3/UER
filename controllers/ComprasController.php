<?php
namespace app\controllers;

use Yii;
use app\models\Compras;
use app\models\ComprasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use yii\helpers\ArrayHelper;


/**
 * ComprasController implements the CRUD actions for Compras model.
 */
class ComprasController extends Controller
{
    public function behaviors()
    {
        return [
        	'access'=>[
        	'class'=>AccessControl::className(),
        	'only'=>['index','create','view','update','impresionprovisional'],
        	'rules'=>[
        			['actions'=>['index','view','create','update','impresionprovisional'],
        				'allow'=>true,
        				'roles'=>['@'],
        				'matchCallback'=>function($rule,$action){ if(Yii::$app->User->identity->tblCategoriauserIdCategoriauser->tbl_categoriauser_nombre=="Administrador" or Yii::$app->User->identity->tblCategoriauserIdCategoriauser->tbl_categoriauser_nombre=="Almacenista" ) return true; else return false;},
        			]
        		]
        	],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Compras models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComprasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=new Compras();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Compras model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    		return $this->render('view', [
            'model' => $this->findModel($id),
        	]);
    }

    /**
     * Creates a new Compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Compras();
		
		if(Yii::$app->request->isAjax){
 	     	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    	        return $this->redirect(['index']);
        	} else {
            	return $this->renderAjax('create', [
                'model' => $model,
            	]);
        	}
      	}
      	else{	
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_compras]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }
    }
	    /**
     * Creates a new Compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
	public function actionImpresion($id){
		$model=$this->findModel($id);
		$items=$model->tblComprasHasTblItems;
		$inventario=\app\models\Inventario::find()->where(['tbl_inventario_nombre'=>'Rav'])->one();
		$idinven=$inventario->id_inventario;
		$html="<div class='col-lg-12 col-md-12 col-xs-12 '>
 		<table class='table table-striped table-hover '>
	    	<thead>
	    		<tr>
	    			<th>".Yii::t('app','Item')."</th>
	    			<th>". Yii::t('app','Descripcion')."</th>
	    			<th>".Yii::t('app','Cantidad')."</th>
	    			<th>".Yii::t('app','Status')."</th>
	    		</tr>
	    	</thead>";
		foreach ($items as $key) {
			$html.="<tr >
		<td>".$key->tblItemIdItem->tbl_item_bim."</td>
		<td>".$key->tblItemIdItem->tbl_item_nombre."</td>
		<td>".$key->tbl_compras_has_tbl_item_cantidad."</td>
		<td>Imprimiendo</td>
		</tr>";
		$key->tblItemIdItem->tbl_item_stock=$key->tblItemIdItem->tbl_item_stock+$key->tbl_compras_has_tbl_item_cantidad;
		$key->tblItemIdItem->save();
		$ban=false;
		foreach ($key->tblItemIdItem->tblItemHasTblInventarios as $inventario) {
			if($inventario->tbl_inventario_id_inventario==$idinven){
				$inventario->tbl_item_has_tbl_inventario_cantidad=$inventario->tbl_item_has_tbl_inventario_cantidad+$key->tbl_compras_has_tbl_item_cantidad;
				$ban=true;	
			}
			if($ban==true)
			$inventario->save();
		}
		if($ban==false){
			$inventario=new \app\models\ItemHasTblInventario();
			$inventario->tbl_item_id_item=$key->tblItemIdItem->id_item;
			$inventario->tbl_inventario_id_inventario=$idinven;
			$inventario->tbl_item_has_tbl_inventario_cantidad=$key->tbl_compras_has_tbl_item_cantidad;
			$inventario->save();
		}
		if(strlen($key->tblItemIdItem->tbl_item_nombre)>52){
		$descripcion=substr($key->tblItemIdItem->tbl_item_nombre,0,52);
		$descripcion2=substr($key->tblItemIdItem->tbl_item_nombre,52);	
		}else{
		$descripcion=$key->tblItemIdItem->tbl_item_nombre;
		$descripcion2="";	
		}
		$impresora =new Impresora();
		$buscari=$key->tblItemIdItem->tbl_item_folio+$key->tbl_compras_has_tbl_item_cantidad;
		for($fol=$key->tblItemIdItem->tbl_item_folio;$fol<$buscari;$fol++){	
		 $impresora->impresionitem([
			 'id'=>$key->tblItemIdItem->id_item,
			 'descripcion'=>$descripcion,
			 'descripcion2'=>$descripcion2,
			 'noparte'=>$key->tblItemIdItem->tbl_item_noParte,
			 'bim'=>$key->tblItemIdItem->tbl_item_bim, 
			 'almacen'=>$key->tblItemIdItem->tbl_item_almacen,
			 'marca'=>$key->tblItemIdItem->tblMarcaIdMarca->tbl_marca_nombre,
			 'inventario'=>$idinven.$fol.$key->tblItemIdItem->id_item,
			 ]);
		}
		$key->tblItemIdItem->tbl_item_folio=$buscari;
		$key->tblItemIdItem->save();
		}
		$html.='</table>
		</div>';
		$model->tbl_compras_impresion=1;
		$model->save();
		return $html;
	}
	public function impresionbim($bim){
		return str_replace("-", "A", $bim).'F';
	}
    /**
     * Updates an existing Compras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		if (Yii::$app->request->isAjax) {
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
		}else{
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_compras]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Deletes an existing Compras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Compras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compras::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
     /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionList()
    {
    	$lista=new Compras();
		Yii::$app->response->format = 'json';
		return $lista->attributeLabels();
    }
	 /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionCsv()
    {
    	$model=new Compras();
		 if ($model->cargacsv(Yii::$app->request->post())){
		  	return print_r($model->cargacsv(Yii::$app->request->post()));
		 }else{
		 return print_r($model->getErrors());
		 }
    }
	
	public function actionImpresionprovisional()
    {
    	$model=new \app\models\ItemHasTblInventario();
    	$item= ArrayHelper::map(\app\models\Item::find()->all(),'id_item','tbl_item_bim');
		$inventario=ArrayHelper::map(\app\models\Inventario::find()->all(),'id_inventario','tbl_inventario_nombre');
		 if (Yii::$app->request->post()){
		 	$post=Yii::$app->request->post('ItemHasTblInventario');
			$buscar=\app\models\Item::find()->where(['id_item'=>$post['tbl_item_id_item']])->one();
			if(strlen($buscar->tbl_item_nombre)>67){
			$descripcion=substr($buscar->tbl_item_nombre,0,52);
			$descripcion2=substr($buscar->tbl_item_nombre,52);	
			}else{
			$descripcion=$buscar->tbl_item_nombre;
			$descripcion2="";	
			}
			$impresora =new Impresora();
			$numero=Yii::$app->request->post('cantidad');
			$inventario2=Yii::$app->request->post('tbl_inventario_id_inventario');
			if($post['tbl_inventario_id_inventario']!=null){
				if($inventario=\app\models\ItemHasTblInventario::find()->where(['tbl_item_id_item'=>$buscar->id_item,'tbl_inventario_id_inventario'=>$inventario2])->one()){
				$inventario->tbl_item_has_tbl_inventario_cantidad=$inventario->tbl_item_has_tbl_inventario_cantidad+$numero;
				$inventario->save();
				}else{
					$inventario=new \app\models\ItemHasTblInventario();
					$inventario->tbl_item_id_item=$buscar->id_item;
					$inventario->tbl_inventario_id_inventario=$inventario2;
					$inventario->tbl_item_has_tbl_inventario_cantidad=$numero;
					$inventario->save();
				}
			}
			$fol=$buscar->tbl_item_folio;
			$buscari=$buscar->tbl_item_folio+$numero;
			for($fol=$buscar->tbl_item_folio;$fol<$buscari;$fol++){
			$impresora->impresionitem([
			'id'=>$buscar->id_item,
			'descripcion'=>$descripcion,
			'descripcion2'=>$descripcion2,
			'noparte'=>$buscar->tbl_item_noParte,
			'bim'=>$buscar->tbl_item_bim, 
			'almacen'=>$buscar->tbl_item_almacen,
			'marca'=>$buscar->tblMarcaIdMarca->tbl_marca_nombre,
			'inventario'=>$inventario2.$fol,
			]);
			}
			$buscar->tbl_item_folio=$buscar->tbl_item_folio+$numero;
			if($buscar->save()){
			return $this->redirect('impresionprovisional', [
                'item' => $item,
                'model'=>$model,
				'inventario'=>$inventario,
            ]);
			}else{
				echo "vuelve a imprimir ";
			}
		 }else{
		  return $this->render('impresionprovisional', [
                'item' => $item,
                'model'=>$model,
				'inventario'=>$inventario,
            ]);
		 }
    }
}
