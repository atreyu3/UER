<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ubicacionfisica;

/**
 * UbicacionfisicaSearch represents the model behind the search form about `\app\models\Ubicacionfisica`.
 */
class UbicacionfisicaSearch extends Ubicacionfisica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ubicacionfisica', 'tbl_ubicacionfisica_planta'], 'integer'],
            [['tbl_ubicacionfisica_nombre'], 'safe'],
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
        $query = Ubicacionfisica::find();

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
            'id_ubicacionfisica' => $this->id_ubicacionfisica,
            'tbl_ubicacionfisica_planta' => $this->tbl_ubicacionfisica_planta,
        ]);

        $query->andFilterWhere(['like', 'tbl_ubicacionfisica_nombre', $this->tbl_ubicacionfisica_nombre]);

        return $dataProvider;
    }
}
