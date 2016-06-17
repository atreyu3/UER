<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedidos;

/**
 * PedidosSearch represents the model behind the search form about `\app\models\Pedidos`.
 */
class PedidosSearch extends Pedidos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pedidos', 'tbl_pedidos_status', 'tbl_user_id_user', 'tbl_item_id_item'], 'integer'],
            [['tbl_pedidos_cantidad'], 'safe'],
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
        $query = Pedidos::find();

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
            'id_pedidos' => $this->id_pedidos,
            'tbl_pedidos_status' => $this->tbl_pedidos_status,
            'tbl_user_id_user' => $this->tbl_user_id_user,
            'tbl_item_id_item' => $this->tbl_item_id_item,
        ]);

        $query->andFilterWhere(['like', 'tbl_pedidos_cantidad', $this->tbl_pedidos_cantidad]);

        return $dataProvider;
    }
}
