<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Moneda;

/**
 * MonedaSearch represents the model behind the search form about `\app\models\Moneda`.
 */
class MonedaSearch extends Moneda
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_moneda'], 'integer'],
            [['tbl_moneda_nombre'], 'safe'],
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
        $query = Moneda::find();

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
            'id_moneda' => $this->id_moneda,
        ]);

        $query->andFilterWhere(['like', 'tbl_moneda_nombre', $this->tbl_moneda_nombre]);

        return $dataProvider;
    }
}
