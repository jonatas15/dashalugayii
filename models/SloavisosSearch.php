<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sloavisos;

/**
 * SloavisosSearch represents the model behind the search form of `\app\models\Sloavisos`.
 */
class SloavisosSearch extends Sloavisos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'etapa', 'situacao'], 'integer'],
            [['whats', 'email', 'outro'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Sloavisos::find();

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
            'id' => $this->id,
            'etapa' => $this->etapa,
            'situacao' => $this->situacao,
        ]);

        $query->andFilterWhere(['like', 'whats', $this->whats])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'outro', $this->outro]);

        return $dataProvider;
    }
}
