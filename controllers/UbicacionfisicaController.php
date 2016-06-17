<?php
namespace app\controllers;

use Yii;
use app\models\Ubicacionfisica;
use app\models\UbicacionfisicaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
/**
 * UbicacionfisicaController implements the CRUD actions for Ubicacionfisica model.
 */
class UbicacionfisicaController extends Controller
{
    public function behaviors()
    {
        return [
        	'access'=>[
        	'class'=>AccessControl::className(),
        	'only'=>['index','create','view','update'],
        	'rules'=>[
        			['actions'=>['index','view','create','update'],
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
     * Lists all Ubicacionfisica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UbicacionfisicaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=new Ubicacionfisica();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Ubicacionfisica model.
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
     * Creates a new Ubicacionfisica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ubicacionfisica();
		
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
            return $this->redirect(['view', 'id' => $model->id_ubicacionfisica]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Updates an existing Ubicacionfisica model.
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
            return $this->redirect(['view', 'id' => $model->id_ubicacionfisica]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Deletes an existing Ubicacionfisica model.
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
     * Finds the Ubicacionfisica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ubicacionfisica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ubicacionfisica::findOne($id)) !== null) {
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
    	$lista=new Ubicacionfisica();
		Yii::$app->response->format = 'json';
		return $lista->attributeLabels();
    }
	 /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionCsv()
    {
    	$model=new Ubicacionfisica();
		 if ($model->cargacsv(Yii::$app->request->post())){
		  	return print_r($model->cargacsv(Yii::$app->request->post()));
		 }else{
		 return print_r($model->getErrors());
		 }
    }
}
