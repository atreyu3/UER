<?php

namespace app\models;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

/**
 * This is the model class for table "tbl_read".
 *
 * @property integer $id_read
 * @property string $tbl_read_tagid
 * @property integer $tbl_read_antena
 * @property string $tbl_read_timestamp
 * @property string $tbl_read_rssi
 * @property integer $tbl_readusuario_id_readusuario
 * @property integer $tbl_read_activo
 * @property integer $tbl_read_analizado
 */
class Read extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'tbl_read';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['tbl_read_antena', 'tbl_readusuario_id_readusuario'], 'integer'], [['tbl_read_timestamp'], 'safe'], [['tbl_read_tagid'], 'string', 'max' => 45], [['tbl_read_rssi'], 'string', 'max' => 3]];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return ['id_read' => Yii::t('app', 'Id Read'), 'tbl_read_tagid' => Yii::t('app', 'Tbl Read Tagid'), 'tbl_read_antena' => Yii::t('app', 'Tbl Read Antena'), 'tbl_read_timestamp' => Yii::t('app', 'Tbl Read Timestamp'), 'tbl_read_rssi' => Yii::t('app', 'Tbl Read Rssi'), 'tbl_readusuario_id_readusuario' => Yii::t('app', 'Tbl Readusuario Id Readusuario'), ];
	}

	

	public function checkname($string) {
		return $this -> find() -> select('id_read') -> where(['tbl_read_tagid' => $string]) -> column() != false ? $this -> find() -> select('id_read') -> where(['tbl_read_tagid' => $string]) -> column() : false;
	}

	protected function checkrelation($relacion, $csvcolumna) {
		$relacionmodelo = ucfirst($this -> nombre($relacion));
		$nombre = $relacionmodelo -> checkname($csvcolumna);
		return $nombre;
	}

}
