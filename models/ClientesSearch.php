<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Clientes;

/**
 * ClientesSearch represents the model behind the search form of `app\models\Clientes`.
 */
class ClientesSearch extends Clientes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'corretor', 'status'], 'integer'],
            [['setor', 'cargo', 'cpf', 'nome', 'email', 'proventos', 'fone1', 'fone2', 'clientescol'], 'safe'],
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
        $query = Clientes::find();

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

        if($this->corretor != null) {
            $this->status = 1;
        }
        $this->status = 1;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'corretor' => $this->corretor,
        ]);

        $query->andFilterWhere(['like', 'setor', $this->setor])
            ->andFilterWhere(['like', 'cargo', $this->cargo])
            ->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'proventos', $this->proventos])
            ->andFilterWhere(['like', 'fone1', $this->fone1])
            ->andFilterWhere(['like', 'fone2', $this->fone2])
            ->andFilterWhere(['like', 'clientescol', $this->clientescol]);

        return $dataProvider;
    }
}
