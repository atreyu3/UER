<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Archivo;

/**
 * ArchivoSearch represents the model behind the search form about `\app\models\Archivo`.
 */
class ArchivoSearch extends Archivo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_archivo', 'tbl_archivo_user'], 'integer'],
            [['tbl_archivo_nombre', 'tbl_archivo_fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Archivo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_archivo' => $this->id_archivo,
            'tbl_archivo_fecha' => $this->tbl_archivo_fecha,
            'tbl_archivo_user' => $this->tbl_archivo_user,
        ]);

        $query->andFilterWhere(['like', 'tbl_archivo_nombre', $this->tbl_archivo_nombre]);

        return $dataProvider;
    }
}
