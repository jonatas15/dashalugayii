<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visitchaves;

/**
 * VisitchavesSearch represents the model behind the search form of `\app\models\Visitchaves`.
 */
class VisitchavesSearch extends Visitchaves
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'convertido_venda'], 'integer'],
            [['nome', 'nome_cliente', 'tipovisitante', 'codigo_imovel', 'dthr_retirada', 'dthr_entrega', 'data_visita', 'hora_visita', 'feedbacks', 'mensagem', 'num_disparo'], 'safe'],
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
        $query = Visitchaves::find();

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
            'usuario_id' => $this->usuario_id,
            'dthr_retirada' => $this->dthr_retirada,
            'dthr_entrega' => $this->dthr_entrega,
            'data_visita' => $this->data_visita,
            'hora_visita' => $this->hora_visita,
            'convertido_venda' => $this->convertido_venda,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'nome_cliente', $this->nome_cliente])
            ->andFilterWhere(['like', 'tipovisitante', $this->tipovisitante])
            ->andFilterWhere(['like', 'codigo_imovel', $this->codigo_imovel])
            ->andFilterWhere(['like', 'feedbacks', $this->feedbacks])
            ->andFilterWhere(['like', 'mensagem', $this->mensagem])
            ->andFilterWhere(['like', 'num_disparo', $this->num_disparo]);

        return $dataProvider;
    }
}
