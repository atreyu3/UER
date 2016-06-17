<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_readusuario".
 *
 * @property integer $id_readusuario
 * @property string $tbl_readusuario_tagid
 * @property integer $tbl_readusuario_antena
 * @property string $tbl_readusuario_timestamp
 * @property string $tbl_readusuario_rssi
 * @property integer $tbl_readusuario_activo
 * @property integer $tbl_readusuario_activoweb
 * @property integer $tbl_readusuario_analizado
 */
class Readusuario extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'tbl_readusuario';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['tbl_readusuario_antena', 'tbl_readusuario_activo'], 'integer'], [['tbl_readusuario_timestamp'], 'safe'], [['tbl_readusuario_tagid'], 'string', 'max' => 45], [['tbl_readusuario_rssi'], 'string', 'max' => 3]];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return ['id_readusuario' => Yii::t('app', 'Id Readusuario'), 'tbl_readusuario_tagid' => Yii::t('app', 'Tbl Readusuario Tagid'), 'tbl_readusuario_antena' => Yii::t('app', 'Tbl Readusuario Antena'), 'tbl_readusuario_timestamp' => Yii::t('app', 'Tbl Readusuario Timestamp'), 'tbl_readusuario_rssi' => Yii::t('app', 'Tbl Readusuario Rssi'), 'tbl_readusuario_activo' => Yii::t('app', 'Tbl Readusuario Activo'), ];
	}

	public function checkname($string) {
		return $this -> find() -> select('id_readusuario') -> where(['tbl_readusuario_tagid' => $string]) -> column() != false ? $this -> find() -> select('id_readusuario') -> where(['tbl_readusuario_tagid' => $string]) -> column() : false;
	}

	protected function checkrelation($relacion, $csvcolumna) {
		$relacionmodelo = ucfirst($this -> nombre($relacion));
		$nombre = $relacionmodelo -> checkname($csvcolumna);
		return $nombre;
	}

}
