<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registrocampanhas;

/**
 * RegistrocampanhasSearch represents the model behind the search form of `\app\models\Registrocampanhas`.
 */
class RegistrocampanhasSearch extends Registrocampanhas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fonte', 'utm_medium', 'utm_source', 'utm_campaign', 'data', 'ip', 'obs', 'formulario'], 'safe'],
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
        $query = Registrocampanhas::find();

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
            'data' => $this->data,
        ]);

        $query->andFilterWhere(['like', 'fonte', $this->fonte])
            ->andFilterWhere(['like', 'utm_medium', $this->utm_medium])
            ->andFilterWhere(['like', 'utm_source', $this->utm_source])
            ->andFilterWhere(['like', 'utm_campaign', $this->utm_campaign])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'obs', $this->obs])
            ->andFilterWhere(['like', 'formulario', $this->formulario]);

        return $dataProvider;
    }
}
