<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Compras;

/**
 * ComprasSearch represents the model behind the search form about `\app\models\Compras`.
 */
class ComprasSearch extends Compras
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_compras', 'tbl_proveedor_id_proveedor', 'tbl_user_id_user', 'tbl_compras_impresion'], 'integer'],
            [['tbl_compras_entrega', 'tbl_compras_fechapedido', 'tbl_compras_fechaentrega', 'tbl_compras_factura'], 'safe'],
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
        $query = Compras::find();

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
            'id_compras' => $this->id_compras,
            'tbl_proveedor_id_proveedor' => $this->tbl_proveedor_id_proveedor,
            'tbl_compras_fechapedido' => $this->tbl_compras_fechapedido,
            'tbl_compras_fechaentrega' => $this->tbl_compras_fechaentrega,
            'tbl_user_id_user' => $this->tbl_user_id_user,
            'tbl_compras_impresion' => $this->tbl_compras_impresion,
        ]);

        $query->andFilterWhere(['like', 'tbl_compras_entrega', $this->tbl_compras_entrega])
            ->andFilterWhere(['like', 'tbl_compras_factura', $this->tbl_compras_factura]);

        return $dataProvider;
    }
}
