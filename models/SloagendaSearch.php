<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SloAgenda;

/**
 * SloagendaSearch represents the model behind the search form about `app\models\SloAgenda`.
 */
class SloagendaSearch extends SloAgenda
{
    /**
     * @inheritdoc
     */
    public $user_cliente_logado;
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'slo_cliente_id', 'slo_proposta_id', 'corretor_idcorretor'], 'integer'],
            [['data', 'turno', 'hora', 'mais_informacoes', 'data_intervalo'], 'safe'],
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
        $query = SloAgenda::find();

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
            'usuario_id' => $this->user_cliente_logado,
            'slo_cliente_id' => $this->slo_cliente_id,
            'slo_proposta_id' => $this->slo_proposta_id,
            // 'slo_proposta_id' => '2',
            'corretor_idcorretor' => $this->corretor_idcorretor,
            'data' => $this->data,
            'hora' => $this->hora,
        ]);

        $query->andFilterWhere(['like', 'turno', $this->turno])
            ->andFilterWhere(['like', 'turno', $this->turno])
            // ->andFilterWhere(['slo_proposta_id' => ['1','2']])
            ->andFilterWhere(['like', 'data_intervalo', $this->data_intervalo]);

        return $dataProvider;
    }
}
