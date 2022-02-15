<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SloFiador;

/**
 * FiadorSearch represents the model behind the search form about `app\models\SloFiador`.
 */
class FiadorSearch extends SloFiador
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pretendente_id'], 'integer'],
            [['tipo_fiador', 'tipo_documento', 'numero', 'orgao_expedidor', 'data_expedicao', 'outras_infos'], 'safe'],
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
        $query = SloFiador::find();

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
            'pretendente_id' => $this->pretendente_id,
            'data_expedicao' => $this->data_expedicao,
        ]);

        $query->andFilterWhere(['like', 'tipo_fiador', $this->tipo_fiador])
            ->andFilterWhere(['like', 'tipo_documento', $this->tipo_documento])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'orgao_expedidor', $this->orgao_expedidor])
            ->andFilterWhere(['like', 'outras_infos', $this->outras_infos]);

        return $dataProvider;
    }
}
