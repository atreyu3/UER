<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\base\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id_user
 * @property string $tbl_user_nombre
 * @property string $tbl_user_apellidomaterno
 * @property string $tbl_user_apellidopaterno
 * @property string $tbl_user_password
 * @property string $tbl_user_numeroempleado
 * @property string $tbl_user_auth_key
 * @property string $tbl_user_siglas
 * @property integer $tbl_categoriauser_id_categoriauser
 * @property string $tbl_user_email
 * 
 * @property Transaccionrefaccion[] $modTransaccionrefaccions
 * @property Compras[] $tblCompras
 * @property GrupoHasTblUser[] $tblGrupoHasTblUsers
 * @property Grupo[] $tblGrupos
 * @property MaquinaHasTblCentrodecostos[] $tblMaquinaHasTblCentrodecostos
 * @property Requisiciones[] $tblRequisiciones
 * @property Categoriauser $tblCategoriauserIdCategoriauser
 * @property UserHasTblUser[] $tblUserHasTblUsers
 * @property UserHasTblUser[] $tblUserHasTblUsers0

 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {
	public $id_jefemecanico;
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'tbl_user';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['tbl_categoriauser_id_categoriauser','tbl_user_nombre'], 'required'], [['tbl_categoriauser_id_categoriauser'], 'integer'],[['tbl_user_email'],'string', 'max' => 255] ,[['tbl_user_nombre', 'tbl_user_apellidomaterno', 'tbl_user_apellidopaterno', 'tbl_user_numeroempleado', 'tbl_user_siglas', 'tbl_user_auth_key'], 'string', 'max' => 45], [['tbl_user_password','tbl_user_email'], 'string', 'max' => 100]];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return ['id_user' => Yii::t('app', 'Id User'), 'tbl_user_nombre' => Yii::t('app', 'Tbl User Nombre'), 'tbl_user_apellidomaterno' => Yii::t('app', 'Tbl User Apellidomaterno'), 'tbl_user_apellidopaterno' => Yii::t('app', 'Tbl User Apellidopaterno'), 'tbl_user_password' => Yii::t('app', 'Tbl User Password'), 'tbl_user_numeroempleado' => Yii::t('app', 'Numero Empleado'), 'tbl_user_siglas' => Yii::t('app', 'Tbl User Siglas'), 'tbl_categoriauser_id_categoriauser' => Yii::t('app', 'Tbl Categoriauser Id Categoriauser'), 'id_jefemecanico' => Yii::t('app', 'Id Jefemecanico'),'tbl_user_email'=>Yii::t('app','Email') ];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabelslist() {
		return ['tbl_user_numeroempleado' => Yii::t('app', 'Numero Empleado'),'tbl_user_nombre' => Yii::t('app', 'Tbl User Nombre'), 'tbl_user_apellidomaterno' => Yii::t('app', 'Tbl User Apellidomaterno'), 'tbl_user_apellidopaterno' => Yii::t('app', 'Tbl User Apellidopaterno'),'tbl_user_email'=>Yii::t('app','Tbl User Email'), 'tbl_user_password' => Yii::t('app', 'Tbl User Password'), 'tbl_user_siglas' => Yii::t('app', 'Tbl User Siglas'), 'tbl_categoriauser_id_categoriauser' => Yii::t('app', 'Tbl Categoriauser Id Categoriauser')];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModTransaccionrefaccions() {
		return $this -> hasMany(Transaccionrefaccion::className(), ['tbl_user_id_user' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblCompras() {
		return $this -> hasMany(Compras::className(), ['tbl_user_id_user' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblGrupoHasTblUsers() {
		return $this -> hasMany(GrupoHasTblUser::className(), ['tbl_user_id' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblGrupos() {
		return $this -> hasMany(Grupo::className(), ['id_grupo' => 'tbl_grupo_id']) -> viaTable('tbl_grupo_has_tbl_user', ['tbl_user_id' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblMaquinaHasTblCentrodecostos() {
		return $this -> hasMany(MaquinaHasTblCentrodecostos::className(), ['tbl_user_id_user' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblRequisiciones() {
		return $this -> hasMany(Requisiciones::className(), ['tbl_user_id_user' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblCategoriauserIdCategoriauser() {
		return $this -> hasOne(Categoriauser::className(), ['id_categoriauser' => 'tbl_categoriauser_id_categoriauser']);
	}

	/**
	 * humberto code
	 */
	public function getTblCategoriauserList() {
		return ArrayHelper::map(Categoriauser::find() -> all(), 'id_categoriauser', 'tbl_categoriauser_nombre');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblUserHasTblUsers() {
		return $this -> hasMany(UserHasTblUser::className(), ['tbl_user_id' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTblUserHasTblUsers0() {
		return $this -> hasMany(UserHasTblUser::className(), ['tbl_user_id1' => 'id_user']);
	}

	public function checkname($string) {
		return $this -> find() -> select('id_user') -> where(['tbl_user_nombre' => $string]) -> column() != false ? $this -> find() -> select('id_user') -> where(['tbl_user_nombre' => $string]) -> column() : false;
	}

	public function cargacsv($carga) {
		$a = array();
		$b = array();
		$modelo[] = new User();
		$archivo = Archivo::findOne($carga['id']);
		$bandera = true;
		$csvcolumn = 0;
		foreach ($carga['modelcsv'] as $envia => $key) {
			if ($key != 'nulo')
				$a[$envia] = $key;

		}
		$categoria = false;
		$keys = array_keys($a);
		foreach ($keys as $key => $value) {
			$db[] = $value;
			$csv[] = $a[$value];
			if ($value == 'tbl_user_password') {
				$password_aux = $key;
			}
			if ($value == 'tbl_categoriauser_id_categoriauser') {
				$categoria = true;
				$iteracion[] = ['column' => $value, 'csv' => $key, 'relacion' => true, 'filter' => FILTER_SANITIZE_STRING, 'flag' => ''];
			} else {
				if ($value == 'tbl_user_password') {
					$iteracion[] = ['column' => $value, 'csv' => $key, 'relacion' => false, 'filter' => '', 'flag' => ''];
				} else {
					if($value=='tbl_user_email')
					$iteracion[] = ['column' => $value, 'csv' => $key, 'relacion' => false, 'filter' => FILTER_SANITIZE_EMAIL, 'flag' => ''];
					else
					$iteracion[] = ['column' => $value, 'csv' => $key, 'relacion' => false, 'filter' => FILTER_SANITIZE_STRING, 'flag' => ''];
				}
			}
			
		}
		$column = ['db' => $db, 'iteracion' => $iteracion];
		$archivo -> proccessglobal($csv, $page = 0, null);
		$lines = $archivo -> linesglobal;
		unset($archivo);
		$carga = new Modelcustomfunction();
		foreach ($lines as $key => $line) {
			$line_aux = array();
			foreach ($line as $key => $value) {
				if ($key == $password_aux) {
					$pass = '';
					$pass = mb_strtolower($value);
					$line_aux[] =$this->setPassword($pass);
				} else {
					$line_aux[] =$value;
				}
			}
			$line_procees[] = $line_aux;
			unset($line_aux);
		}
		if ($categoria == true) {
			$check = ['relations' => true, 'update' => false, 'llaves' => [['clase' => 'Categoriauser', 'columna' => 'tbl_categoriauser_nombre', 'valor' => 'No asignado']]];
		} else {
			$check = ['relations' => false, 'update' => true];
		}
		$md = ['nombre' => 'User', 'columna' => 'tbl_user_numeroempleado'];
		return $carga -> cargapruebacsv($line_procees, $column, $check, $md);
	}

	protected function nombre($string) {
		$string = explode("_", $string);
		return $string[1];
	}

	/** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne($id);
	}

	/**
	 * @inheritdoc
	 */
	/* modified */
	public static function findIdentityByAccessToken($token, $type = null) {
		return static::findOne(['access_token' => $token]);
	}

	/* removed
	 public static function findIdentityByAccessToken($token)
	 {
	 throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	 }
	 */
	/**
	 * Finds user by username
	 *
	 * @param  string      $username
	 * @return static|null
	 */
	public static function findByUsername($username) {
		return static::findOne(['tbl_user_numeroempleado' => $username]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param  string      $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token) {
		$expire = \Yii::$app -> params['usuario.passwordResetTokenExpire'];
		$parts = explode('_', $token);
		$timestamp = (int) end($parts);
		if ($timestamp + $expire < time()) {
			// token expired
			return null;
		}

		return static::findOne(['password_reset_token' => $token]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this -> getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this -> tbl_user_auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this -> getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param  string  $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		$security = new yii\base\Security();
		if ($security -> validatePassword($password, $this -> tbl_user_password)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$security = new yii\base\Security();
		return $security -> generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey() {
		$this -> auth_key = Security::generateRandomKey();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		$this -> password_reset_token = Security::generateRandomKey() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this -> password_reset_token = null;
	}

	/** EXTENSION MOVIE **/
	public function getCheckJefe() {
		if ($this -> tblUserHasTblUsers != null) {
			$jefe = UserHasTblUser::find() -> where(['tbl_user_id' => $this -> id_user]) -> one();
			return $jefe -> tblUserId1 -> tbl_user_nombre . ' ' . $jefe -> tblUserId1 -> tbl_user_apellidomaterno;
		} else {
			return null;
		}

	}

	/**
	 * humberto code
	 */
	public function getTblUserList() {
		$id_categoria=\app\models\Categoriauser::find()->where(['tbl_categoriauser_nombre'=>'Jefe de mecanico'])->one();
		return isset($id_categoria) ? ArrayHelper::map($this -> find() -> where(['tbl_categoriauser_id_categoriauser' => $id_categoria->id_categoriauser]) -> all(), 'id_user', 'tbl_user_nombre') :'';
	}

}
