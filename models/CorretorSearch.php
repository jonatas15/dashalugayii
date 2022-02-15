<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Corretor;

/**
 * CorretorSearch represents the model behind the search form about `app\models\Corretor`.
 */
class CorretorSearch extends Corretor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcorretor'], 'integer'],
            [['nome', 'observacoes', 'foto', 'cor'], 'safe'],
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
        $query = Corretor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idcorretor' => $this->idcorretor,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'cor', $this->cor]);

        return $dataProvider;
    }
}
