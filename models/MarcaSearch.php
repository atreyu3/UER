<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Marca;

/**
 * MarcaSearch represents the model behind the search form about `\app\models\Marca`.
 */
class MarcaSearch extends Marca
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_marca'], 'integer'],
            [['tbl_marca_nombre'], 'safe'],
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
        $query = Marca::find();

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
            'id_marca' => $this->id_marca,
        ]);

        $query->andFilterWhere(['like', 'tbl_marca_nombre', $this->tbl_marca_nombre]);

        return $dataProvider;
    }
}
