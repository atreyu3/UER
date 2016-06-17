<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parcialidades;

/**
 * ParcialidadesSearch represents the model behind the search form about `\app\models\Parcialidades`.
 */
class ParcialidadesSearch extends Parcialidades
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parcialidades', 'tbl_parcialidades_suma', 'tbl_item_id_item'], 'integer'],
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
        $query = Parcialidades::find();

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
            'id_parcialidades' => $this->id_parcialidades,
            'tbl_parcialidades_suma' => $this->tbl_parcialidades_suma,
            'tbl_item_id_item' => $this->tbl_item_id_item,
        ]);

        return $dataProvider;
    }
}
