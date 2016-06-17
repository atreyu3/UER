<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categoriaitem;

/**
 * CategoriaitemSearch represents the model behind the search form about `\app\models\Categoriaitem`.
 */
class CategoriaitemSearch extends Categoriaitem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoriaitem'], 'integer'],
            [['tbl_categoriaitem_nombre', 'tbl_categoriaitem_nomenclatura'], 'safe'],
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
        $query = Categoriaitem::find();

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
            'id_categoriaitem' => $this->id_categoriaitem,
        ]);

        $query->andFilterWhere(['like', 'tbl_categoriaitem_nombre', $this->tbl_categoriaitem_nombre])
            ->andFilterWhere(['like', 'tbl_categoriaitem_nomenclatura', $this->tbl_categoriaitem_nomenclatura]);

        return $dataProvider;
    }
}
