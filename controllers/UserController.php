<?php
namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Categoriauser;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UserHasTblUser;
use yii\filters\AccessControl;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=new User();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($form=null)
    {
    	$idjefe=\app\models\Categoriauser::find()->select('id_categoriauser')->where(['tbl_categoriauser_nombre'=>'Jefe de mecanico'])->one();
        $model = new User();
		$model2= new UserHasTblUser();
		if(Yii::$app->request->isAjax){
 	     	if ($model->load(Yii::$app->request->post())) {
 	     		$model->tbl_user_password = $model->setPassword($model['tbl_user_password']);
				if($model->save()){
				if(Yii::$app->request->post('Jefe')!='' && Yii::$app->request->post('Jefe')!='-'){
				$model3=User::findOne(Yii::$app->request->post('Jefe'));	
				$model2->tbl_user_id1=$model3->id_user;
				$model2->tbl_user_id=$model->id_user;
				$model2->save();
				//$this->impresion(['mecanico'=>$model->tbl_user_nombre,'Jefe'=>'','id'=>$model->id_user]);		
    	       	}
    	        return $this->redirect(['index']);
				}
        	} else {
            	return $this->renderAjax('create', [
                'model' => $model,'formid'=>$idjefe->id_categoriauser
            	]);
        	}
      	}
      	else{	
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_user]);
        } else {
            return $this->render('create', [
                'model' => $model,'formid'=>$idjefe->id_categoriauser
            ]);
        }
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model2= new UserHasTblUser;
		if (Yii::$app->request->isAjax) {
			$modelo_post=Yii::$app->request->post('User');
			$contrasena_old=$model->tbl_user_password;
			if ($model->load(Yii::$app->request->post()) ) {
				if ($model->tbl_user_password!='') {
					$model->tbl_user_password = $model->setPassword($modelo_post['tbl_user_password']);
				}else{
					$model->tbl_user_password=$contrasena_old;
				}	
				if(Yii::$app->request->post('Jefe')!='' && Yii::$app->request->post('Jefe')!='-'){
				$model3=User::findOne(Yii::$app->request->post('Jefe'));	
				$model2->tbl_user_id1=$model3->id_user;
				$model2->tbl_user_id=$model->id_user;
				$model2->save();
			}
				if($model->save()){
					$updatecorreo=\app\models\Parametro::find()->where(['CVE_PARAMETRO'=>'CorreoAdministrador'])->one();
					Yii::$app->mailer->compose()
					->setFrom('uersistema@gmail.com')
    				->setTo($updatecorreo->valor)
    				->setSubject('Cambio usuario')
    				->setHtmlBody('<h1>Cambio de datos del usuario </h1><br><p>Nombre de usuario:</p>'.$model->tbl_user_nombre.' '.$model->tbl_user_apellidomaterno.' '.$model->tbl_user_apellidopaterno)
    				->send();
					//$impresora=new Impresora();
					//$impresora->impresionuser(['mecanico'=>$model->tbl_user_nombre,'Jefe'=>'','id'=>$model->id_user]);		
				 return $this->redirect(['index']);
				}
        } else {
			$model->tbl_user_password="";
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
		}else{
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id_user]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
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
    	$lista=new User();
		Yii::$app->response->format = 'json';
		return $lista->attributeLabelslist();
    }
	 /**
     * Lists all Maquina json.
     * @return mixed
     */
    public function actionCsv()
    {
    	$model=new User();
		  	return print_r($model->cargacsv(Yii::$app->request->post()));
		 
    }
	/**
     * .
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionCategoria($id)
    {
    		$idjefe=\app\models\Categoriauser::find()->where(['id_categoriauser'=>$id])->one();
    		$opciones = User::find()->where(['tbl_categoriauser_id_categoriauser' => $idjefe->tbl_categoriauser_permiso])->all();
			$html="<option>-</option>";
    		foreach($opciones as $opcion){
    			$html.="<option value='".$opcion->id_user."'>".$opcion->tbl_user_nombre." ".$opcion->tbl_user_apellidomaterno." ".$opcion->tbl_user_apellidopaterno."</option>";
    		}
    		return $html;
    }
    public function actionTemplateuser()
    {
        $this->downloadFile(Yii::$app->basePath."/web/templates/",'empleados.xlsx');
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
