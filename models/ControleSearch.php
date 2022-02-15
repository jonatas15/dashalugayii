<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Controle;

/**
 * ControleSearch represents the model behind the search form about `app\models\Controle`.
 */
class ControleSearch extends Controle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcontrole', 'permuta_id', 'cadastrador', 'atualizador'], 'integer'],
            [['acao_feita', 'detalhes_acao', 'data_cadastro', 'data_alteracao', 'mais_infos'], 'safe'],
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
        $query = Controle::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['idcontrole'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idcontrole' => $this->idcontrole,
            'permuta_id' => $this->permuta_id,
            'cadastrador' => $this->cadastrador,
            'data_cadastro' => $this->data_cadastro,
            'atualizador' => $this->atualizador,
            'data_alteracao' => $this->data_alteracao,
        ]);

        $query->andFilterWhere(['like', 'acao_feita', $this->acao_feita])
            ->andFilterWhere(['like', 'detalhes_acao', $this->detalhes_acao])
            ->andFilterWhere(['like', 'mais_infos', $this->mais_infos]);

        return $dataProvider;
    }
}
