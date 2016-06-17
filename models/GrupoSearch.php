<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grupo;

/**
 * GrupoSearch represents the model behind the search form about `\app\models\Grupo`.
 */
class GrupoSearch extends Grupo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grupo'], 'integer'],
            [['tbl_grupo_nombre'], 'safe'],
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
        $query = Grupo::find();

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
            'id_grupo' => $this->id_grupo,
        ]);

        $query->andFilterWhere(['like', 'tbl_grupo_nombre', $this->tbl_grupo_nombre]);

        return $dataProvider;
    }
}
