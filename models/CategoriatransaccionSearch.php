<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categoriatransaccion;

/**
 * CategoriatransaccionSearch represents the model behind the search form about `\app\models\Categoriatransaccion`.
 */
class CategoriatransaccionSearch extends Categoriatransaccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoriatransaccion'], 'integer'],
            [['tbl_categoriatransaccion_nombre'], 'safe'],
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
        $query = Categoriatransaccion::find();

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
            'id_categoriatransaccion' => $this->id_categoriatransaccion,
        ]);

        $query->andFilterWhere(['like', 'tbl_categoriatransaccion_nombre', $this->tbl_categoriatransaccion_nombre]);

        return $dataProvider;
    }
}
