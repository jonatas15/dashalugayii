<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SloPretendente;

/**
 * PretendenteSearch represents the model behind the search form about `app\models\SloPretendente`.
 */
class PretendenteSearch extends SloPretendente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'proposta_id', 'animais_extimacao'], 'integer'],
            [['morar_com_quem', 'apresentacao','infopessoal', 'infoprofissional'], 'safe'],
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
        $query = SloPretendente::find()->joinWith('sloInfospessoais')->joinWith('sloInfosprofissionais')
        ->where(['not', ['nome' => null]])->groupby('slo_pretendente.id')->orderBy(['data' => SORT_DESC]);

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
            'animais_extimacao' => $this->animais_extimacao,
        ]);

        $query->andFilterWhere(['like', 'morar_com_quem', $this->morar_com_quem])
            ->andFilterWhere(['like', 'nome', $this->infopessoal])
            ->andFilterWhere(['like', 'empresa', $this->infoprofissional])
            ->andFilterWhere(['like', 'apresentacao', $this->apresentacao]);

        return $dataProvider;
    }
}
