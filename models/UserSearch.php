<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `\app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'tbl_categoriauser_id_categoriauser','id_jefemecanico'], 'integer'],
            [['tbl_user_nombre', 'tbl_user_apellidomaterno', 'tbl_user_apellidopaterno',  'tbl_user_password', 'tbl_user_numeroempleado', 'tbl_user_siglas'], 'safe'],
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
        $query = User::find();
		$query->joinWith(['tblUserHasTblUsers']);
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
            'id_user' => $this->id_user,
            'tbl_categoriauser_id_categoriauser' => $this->tbl_categoriauser_id_categoriauser,
            'tbl_user_has_tbl_user.tbl_user_id1'=>$this->id_jefemecanico
        ]);

        $query->andFilterWhere(['like', 'tbl_user_nombre', $this->tbl_user_nombre])
            ->andFilterWhere(['like', 'tbl_user_apellidomaterno', $this->tbl_user_apellidomaterno])
            ->andFilterWhere(['like', 'tbl_user_apellidopaterno', $this->tbl_user_apellidopaterno])
            ->andFilterWhere(['like', 'tbl_user_password', $this->tbl_user_password])
            ->andFilterWhere(['like', 'tbl_user_numeroempleado', $this->tbl_user_numeroempleado])
            ->andFilterWhere(['like', 'tbl_user_siglas', $this->tbl_user_siglas]);

        return $dataProvider;
    }
}
