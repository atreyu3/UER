<?php
namespace app\controllers;

use Yii;
use app\models\Pedidos;
use app\models\PedidosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
/**
 * PedidosController implements the CRUD actions for Pedidos model.
 */
class PedidosController extends Controller
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
     * Lists all Pedidos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PedidosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=new Pedidos();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Pedidos model.
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
     * Creates a new Pedidos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pedidos();
		
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
            return $this->redirect(['view', 'id' => $model->id_pedidos]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Updates an existing Pedidos model.
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
            return $this->redirect(['view', 'id' => $model->id_pedidos]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Deletes an existing Pedidos model.
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
     * Finds the Pedidos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedidos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedidos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
