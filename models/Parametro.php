<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametro".
 *
 * @property string $CVE_PARAMETRO
 * @property string $VALOR
 * @property string $DESCRIPCION
 */
class Parametro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CVE_PARAMETRO'], 'required'],
            [['CVE_PARAMETRO'], 'string', 'max' => 30],
            [['VALOR', 'DESCRIPCION'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CVE_PARAMETRO' => 'Cve  Parametro',
            'VALOR' => 'Valor',
            'DESCRIPCION' => 'Descripcion',
        ];
    }
}
