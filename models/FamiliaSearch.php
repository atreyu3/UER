<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Familia;

/**
 * FamiliaSearch represents the model behind the search form about `\app\models\Familia`.
 */
class FamiliaSearch extends Familia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_familia', 'tbl_catfamilia_id_catfamilia'], 'integer'],
            [['tbl_familia_nombre', 'tbl_familia_siglas'], 'safe'],
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
        $query = Familia::find();

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
            'id_familia' => $this->id_familia,
            'tbl_catfamilia_id_catfamilia' => $this->tbl_catfamilia_id_catfamilia,
        ]);

        $query->andFilterWhere(['like', 'tbl_familia_nombre', $this->tbl_familia_nombre])
            ->andFilterWhere(['like', 'tbl_familia_siglas', $this->tbl_familia_siglas]);

        return $dataProvider;
    }
}
