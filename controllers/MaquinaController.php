<?php
namespace app\controllers;

use Yii;
use app\models\Maquina;
use app\models\MaquinaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
/**
 * MaquinaController implements the CRUD actions for Maquina model.
 */
class MaquinaController extends Controller
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
        				'matchCallback'=>function($rule,$action){ if(Yii::$app->User->identity->tblCategoriauserIdCategoriauser->tbl_categoriauser_nombre=="Administrador" or Yii::$app->User->identity->tblCategoriauserIdCategoriauser->tbl_categoriauser_nombre=="Almacenista" or Yii::$app->User->identity->tblCategoriauserIdCategoriauser->tbl_categoriauser_nombre=="Jefe de mecanico" ) return true; else return false;},
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
	public function actionPagination($records){
		$search = new MaquinaSearch();
		$search->setPerPage($records);
		return $this->redirect(['index']);
	}
    /**
     * Lists all Maquina models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaquinaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=new Maquina();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }
	
    /**
     * Displays a single Maquina model.
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
     * Creates a new Maquina model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Maquina();
		
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
            return $this->redirect(['view', 'id' => $model->id_maquina]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Updates an existing Maquina model.
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
            return $this->redirect(['view', 'id' => $model->id_maquina]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }
	
	/*
	*UPdate para cambiar el estatus de las maquina de incativas a activas
	*
	*/
	public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);
		if (Yii::$app->request->isAjax) {
			if ($model->load(Yii::$app->request->post()) && $model->updateInactivo()) {
				return $this->redirect(['inactivo', 'tbl_status_id_status = 1' ,'id' => $model->id_maquina]);
			} 
		}
    }

    /**
     * Deletes an existing Maquina model.
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
     * Finds the Maquina model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Maquina the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Maquina::findOne($id)) !== null) {
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
    	$lista=new Maquina();
		Yii::$app->response->format = 'json';
		return $lista->attributeLabels();
    }
	 /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionCsv()
    {
    	$model=new Maquina();
		 if ($model->cargacsv(Yii::$app->request->post())){
		  	return print_r($model->cargacsv(Yii::$app->request->post()));
		 }else{
		 return print_r($model->getErrors());
		 }
    }
	 /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionFamilia()
    {
    	$models=\app\models\Maquina::find()->all();
		foreach($models as $model){
			
		}
    }
	
	public function actionMaquinainactivas(){
		$searchModel = new MaquinaSearch();
        $dataProvider = $searchModel->searchIniactivos(Yii::$app->request->queryParams);
		$model=new Maquina();
        return $this->render('inactivo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
		
	}

}
