<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Requisiciones;

/**
 * RequisicionesSearch represents the model behind the search form about `\app\models\Requisiciones`.
 */
class RequisicionesSearch extends Requisiciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_requisiciones', 'tbl_requisiciones_status', 'tbl_user_id_user'], 'integer'],
            [['tbl_requisiciones_cantidad', 'tbl_requisiciones_nombre'], 'safe'],
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
        $query = Requisiciones::find();

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
            'id_requisiciones' => $this->id_requisiciones,
            'tbl_requisiciones_status' => $this->tbl_requisiciones_status,
            'tbl_user_id_user' => $this->tbl_user_id_user,
        ]);

        $query->andFilterWhere(['like', 'tbl_requisiciones_cantidad', $this->tbl_requisiciones_cantidad])
            ->andFilterWhere(['like', 'tbl_requisiciones_nombre', $this->tbl_requisiciones_nombre]);

        return $dataProvider;
    }
}
