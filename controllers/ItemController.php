<?php
namespace app\controllers;

use Yii;
use app\models\Item;
use app\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryparams);
		$model=new Item();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }
	
	/**
     * Lists all Item models.
     * @return mixed
     */
    public function actionModal()
    {
        return $this->renderAjax('_modal');
    }
    /**
     * Displays a single Item model.
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
     * Download link template 
     * Humberto montes de oca lobera
     * @return link download
     */
    public function actionTemplateonhand()
    {
    		$this->downloadFile(Yii::$app->basePath."/web/templates/",'onhand.xlsx');
    }
    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();
		
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
            return $this->redirect(['view', 'id' => $model->id_item]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Updates an existing Item model.
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
            return $this->redirect(['view', 'id' => $model->id_item]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
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
    	$lista=new Item();
		$atributos=$lista->customattributeLabels();
		$atributos_return=array();
		foreach ($atributos as $key => $value) {
			if($value["visible"]=="si")
			$atributos_return[$key]=$value["nombre"];
		}
		Yii::$app->response->format = 'json';
		return $atributos_return;
    }
	 /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionCsv()
    {
    	$model=new Item();
		 if ($l=$model->cargacsv(Yii::$app->request->post())){
		  	return $l;
		 }else{
		 return print_r($model->getErrors());
		 }
    }
	private function downloadFile($dir, $file)
    {
		if (is_dir($dir))
    	{
    		$path = $dir.$file;
    		if (is_file($path))
    		{
    			$file_info = pathinfo($path);
    			$extension = $file_info["extension"];
    						$size = filesize($path);
    						header("Content-Type: application/force-download");
    						header("Content-Disposition: attachment; filename=$file");
    						header("Content-Transfer-Encoding: binary");
    						header("Content-Length: " . $size);
    						readfile($path);
    						return true;
    		}
    	}
    	return false;
    }
}


