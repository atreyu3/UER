<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usorefaccion;

/**
 * UsorefaccionSearch represents the model behind the search form about `\app\models\Usorefaccion`.
 */
class UsorefaccionSearch extends Usorefaccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usorefaccion', 'tbl_usorefaccion_orden', 'tbl_usorefaccion_visible'], 'integer'],
            [['tbl_usorefaccion_nombre','tbl_usorefaccion_color'], 'safe'],
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
        $query = Usorefaccion::find();

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
            'id_usorefaccion' => $this->id_usorefaccion,
            'tbl_usorefaccion_orden' => $this->tbl_usorefaccion_orden,
            'tbl_usorefaccion_visible' => $this->tbl_usorefaccion_visible,
        ]);

        $query->andFilterWhere(['like', 'tbl_usorefaccion_nombre', $this->tbl_usorefaccion_nombre]);
		$query->andFilterWhere(['like', 'tbl_usorefaccion_color', $this->tbl_usorefaccion_color]);

        return $dataProvider;
    }
}
