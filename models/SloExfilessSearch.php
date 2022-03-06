<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SloExfiles;

/**
 * SloExfilessSearch represents the model behind the search form of `\app\models\SloExfiles`.
 */
class SloExfilessSearch extends SloExfiles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'proposta_id'], 'integer'],
            [['cpf', 'rg_frente', 'rg_verso', 'extrato_bancario', 'imposto_de_renda', 'comprovante_de_endereco', 'carteira_de_trabalho', 'extrato_inss'], 'safe'],
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
        $query = SloExfiles::find();

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
            'proposta_id' => $this->proposta_id,
        ]);

        $query->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'rg_frente', $this->rg_frente])
            ->andFilterWhere(['like', 'rg_verso', $this->rg_verso])
            ->andFilterWhere(['like', 'extrato_bancario', $this->extrato_bancario])
            ->andFilterWhere(['like', 'imposto_de_renda', $this->imposto_de_renda])
            ->andFilterWhere(['like', 'comprovante_de_endereco', $this->comprovante_de_endereco])
            ->andFilterWhere(['like', 'carteira_de_trabalho', $this->carteira_de_trabalho])
            ->andFilterWhere(['like', 'extrato_inss', $this->extrato_inss]);

        return $dataProvider;
    }
}
