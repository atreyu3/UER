<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Precio;

/**
 * PrecioSearch represents the model behind the search form about `\app\models\Precio`.
 */
class PrecioSearch extends Precio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_precios', 'tbl_item_id_item', 'tbl_moneda_id_moneda', 'tbl_proveedor_id_proveedor'], 'integer'],
            [['tbl_precio_precio', 'tbl_precio_cambio', 'tbl_precio_unidadmedida', 'tbl_precio_unidadcompra', 'tbl_precio_opcion'], 'safe'],
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
        $query = Precio::find();

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
            'id_precios' => $this->id_precios,
            'tbl_precio_cambio' => $this->tbl_precio_cambio,
            'tbl_item_id_item' => $this->tbl_item_id_item,
            'tbl_moneda_id_moneda' => $this->tbl_moneda_id_moneda,
            'tbl_proveedor_id_proveedor' => $this->tbl_proveedor_id_proveedor,
        ]);

        $query->andFilterWhere(['like', 'tbl_precio_precio', $this->tbl_precio_precio])
            ->andFilterWhere(['like', 'tbl_precio_unidadmedida', $this->tbl_precio_unidadmedida])
            ->andFilterWhere(['like', 'tbl_precio_unidadcompra', $this->tbl_precio_unidadcompra])
            ->andFilterWhere(['like', 'tbl_precio_opcion', $this->tbl_precio_opcion]);

        return $dataProvider;
    }
}
