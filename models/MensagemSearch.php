<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mensagem;

/**
 * MensagemSearch represents the model behind the search form about `app\models\Mensagem`.
 */
class MensagemSearch extends Mensagem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'slo_pretendente_id', 'usuario_id'], 'integer'],
            [['texto', 'data', 'ip', 'imagem'], 'safe'],
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
        $query = Mensagem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC 
                ]
            ],
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
            'slo_pretendente_id' => $this->slo_pretendente_id,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'imagem', $this->imagem]);

        return $dataProvider;
    }
}
