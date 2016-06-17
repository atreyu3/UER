<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Centrodecostos;

/**
 * CentrodecostosSearch represents the model behind the search form about `\app\models\Centrodecostos`.
 */
class CentrodecostosSearch extends Centrodecostos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_centrodecostos'], 'integer'],
            [['tbl_centrodecostos_nombre', 'tbl_centrodecostos_siglas'], 'safe'],
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
        $query = Centrodecostos::find();

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
            'id_centrodecostos' => $this->id_centrodecostos,
        ]);

        $query->andFilterWhere(['like', 'tbl_centrodecostos_nombre', $this->tbl_centrodecostos_nombre])
            ->andFilterWhere(['like', 'tbl_centrodecostos_siglas', $this->tbl_centrodecostos_siglas]);

        return $dataProvider;
    }
}
