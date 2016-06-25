<?php
namespace app\controllers;

use Yii;
use app\models\Archivo;
use app\models\ArchivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\BaseUrl;
use yii\filters\AccessControl;
use app\models\User;

/**
 * ArchivoController implements the CRUD actions for Archivo model.
 */
class ArchivoController extends Controller
{
    public function behaviors()
    {
        return [
        	'access'=>[
        	'class'=>AccessControl::className(),
        	'only'=>['index','create','view','update'],
        	'rules'=>[
        			['actions'=>['index','view','create','update','fileonhand','filecarga','filertr','filelista'],
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
     * Lists all Archivo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArchivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=new Archivo();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

 	/**
     * Lists all Maquina models.
     * @return mixed
     */
    public function actionUpload()
    {
    	$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;//Yii::$app -> User -> identity->id_user;
				if($model->upload() and  $model->save(false)){
	                // file is uploaded successfully
                	return $model->id_archivo;
        		    
				}
			}
			return print_r($model->getErrors());
    	}else{
    		$ref=explode('/',Yii::$app->request->referrer);
			$re=$ref[count(explode('/',Yii::$app->request->absoluteUrl))-2];
	        return $this->renderAjax('upload',['model'=>$model,'vistanterior'=>$re]);
		}
    }
	/**
     * Lists all Maquina models.
     * @return mixed
     */
    public function actionFileonhand()
    {
    	$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;
				if($model->upload() and  $model->save(false)){
	                // file is uploaded successfully
	                $model->uploadonhand();
					//return true;
					return $this->redirect(['item/index']);
				}
			}
			//return print_r($model->getErrors());
    	}
    }
	/**
     * Lists all Maquina models.
     * @return mixed
     */
    public function actionFilecarga()
    {
    	$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;
				if($model->upload() and  $model->save(false)){
	                // file is uploaded successfully
	                $model->cargamaquinas();
					//return true;
					return $this->redirect(['maquina/index']);
				}
			}
			//return print_r($model->getErrors());
    	}
    }
	/**
     * Lists all Maquina models.
     * @return mixed
     */
    public function actionFilertr()
    {
    	$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;
				if($model->upload() and  $model->save(false)){
	                // file is uploaded successfully
	                $model->cargartr();
					//return true;
					return $this->redirect(['compras/index']);
				}
			}
			//return print_r($model->getErrors());
    	}
    }
	public function actionFilelista()
    {
    	$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;
				if($model->upload() and  $model->save(false)){
	                // file is uploaded successfully
				 return	print_r($model->uploadlista());
					//return $this->redirect(['item/index']);					
				}
			}
    	}
    }
	/*
	 * upload file post massive 
	 * 
	 * @return error
	 * */
	public function actionSubirtemplateuser()
    {
    	$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;
				if($model->upload() and  $model->save(false)){
					$user=new \app\models\User();
					$array_aux=[
					'modelcsv'=>[
								'tbl_user_numeroempleado'=>'0',
								'tbl_user_nombre'=>1,
								'tbl_user_apellidomaterno'=>2,
								'tbl_user_apellidopaterno'=>3,
								'tbl_user_email'=>8,
								'tbl_user_password'=>'0',
								'tbl_user_siglas'=>6,
								'tbl_categoriauser_id_categoriauser'=>7
							],
					'id'=>$model->id_archivo,
					];
				 		$user->cargacsv($array_aux);
					return $this->redirect(['user/index']);					
				}
			}
    	}
    }
    /**
     * Displays a single Archivo model.
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
     * Creates a new Archivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Archivo();
		
		if(Yii::$app->request->isAjax){
 	     	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    	        return $this->redirect(['index']);
        	} else {
		         var_dump ($model->getErrors()); die();
        	}
      	}
      	else{	
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_archivo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Updates an existing Archivo model.
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
            return $this->redirect(['view', 'id' => $model->id_archivo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Deletes an existing Archivo model.
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
     * 
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionList()
    {
       	$id=$this->findModel(Yii::$app->request->post('id'));
		$data=$id->proccess();
		Yii::$app->response->format = 'json';
        return $data;
    }

    /**
     * Finds the Archivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Archivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Archivo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionImpresora()
    {
    	$archivo=fopen(Yii::$app->basePath."/config/impresora.txt", "r");
		while(!feof($archivo)){
			$impresora=fgets($archivo);
		}
		fclose($archivo);	
          if (Yii::$app->request->post()) {
          	$impresora=Yii::$app->request->post('nombre_impresora');
          	$archivo=fopen(Yii::$app->basePath."/config/impresora.txt", "w");
			fwrite($archivo,'\\\\'.gethostname().'\\'.$impresora);
			fclose($archivo);	
			return $this->redirect(['impresora', 'impresora' => $impresora]);
        } else {
            return $this->render('impresora', [
                'impresora' => $impresora,
            ]);
        }
    }
	public function actionFamilias(){
		$model = new Archivo();
    	if(Yii::$app->request->isPost){
    		if ($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles')){
    			$model->tbl_archivo_nombre=end($model->imageFiles);
				$model->tbl_archivo_user=1;
				if($model->upload() and  $model->save(false)){
	                // file is uploaded successfully
				 return	print_r($model->uploadfamilia());
					//return $this->redirect(['item/index']);					
				}
			}
    	}
	}
	
	public function actionSalidas(){
		$model=new Archivo();
		$salida=$model->salidas();
		
		$this->downloadFile(Yii::$app->basePath."/web/",$salida);
		return $this->redirect(['index']);
	}
	
	public function actionSalidastiempo(){
		$model=new Archivo();
		$salida=$model->salidastiempo();
		
		$this->downloadFile(Yii::$app->basePath."/web/",$salida);
		return $this->redirect(['index']);
	}
	
	public function actionDevoluciones(){
		$model=new Archivo();
		$salida=$model->devolucion();
		$this->downloadFile(Yii::$app->basePath."/web/",$salida);
		return $this->redirect(['index']);
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
