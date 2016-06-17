<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Item;

/**
 * ItemSearch represents the model behind the search form about `\app\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'tbl_item_stock', 'tbl_item_costo', 'tbl_familia_id_familia', 'tbl_item_folio','tbl_categoriaitem_id_categoriaitem', 'tbl_marca_id_marca'], 'integer'],
            [['tbl_item_bim', 'tbl_item_almacen', 'tbl_item_noParte', 'tbl_item_nombre', 'tbl_item_precio', 'tbl_item_unidadmedida'], 'safe'],
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
	public function setPerPage($recordPerPage)
    {
        Yii::$app->session->set(self::tableName().'Pagination', $recordPerPage);
    }

    public function getPerPage()
    {
        return Yii::$app->session->get(self::tableName().'Pagination', 25);
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
        $query = Item::find();

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
            'id_item' => $this->id_item,
            'tbl_item_stock' => $this->tbl_item_stock,
            'tbl_item_costo' => $this->tbl_item_costo,
            'tbl_familia_id_familia' => $this->tbl_familia_id_familia,
            'tbl_categoriaitem_id_categoriaitem' => $this->tbl_categoriaitem_id_categoriaitem,
            'tbl_marca_id_marca' => $this->tbl_marca_id_marca,
            'tbl_item_folio' => $this->tbl_item_folio,
        ]);

        $query->andFilterWhere(['like', 'tbl_item_bim', $this->tbl_item_bim])
            ->andFilterWhere(['like', 'tbl_item_almacen', $this->tbl_item_almacen])
            ->andFilterWhere(['like', 'tbl_item_noParte', $this->tbl_item_noParte])
            ->andFilterWhere(['like', 'tbl_item_nombre', $this->tbl_item_nombre])
            ->andFilterWhere(['like', 'tbl_item_precio', $this->tbl_item_precio])
            ->andFilterWhere(['like', 'tbl_item_unidadmedida', $this->tbl_item_unidadmedida]);

        return $dataProvider;
    }
}
