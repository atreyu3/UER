<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Linea;

/**
 * LineaSearch represents the model behind the search form about `\app\models\Linea`.
 */
class LineaSearch extends Linea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_linea', 'tbl_grupo_id_grupo'], 'integer'],
            [['tbl_linea_nombre', 'tbl_linea_siglas'], 'safe'],
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
        $query = Linea::find();

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
            'id_linea' => $this->id_linea,
            'tbl_grupo_id_grupo' => $this->tbl_grupo_id_grupo,
        ]);

        $query->andFilterWhere(['like', 'tbl_linea_nombre', $this->tbl_linea_nombre])
            ->andFilterWhere(['like', 'tbl_linea_siglas', $this->tbl_linea_siglas]);

        return $dataProvider;
    }
}
