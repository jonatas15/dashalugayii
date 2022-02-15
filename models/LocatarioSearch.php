<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Locatario;

/**
 * LocatarioSearch represents the model behind the search form about `app\models\Locatario`.
 */
class LocatarioSearch extends Locatario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id'], 'integer'],
            [['nome', 'contato', 'codigo_do_imovel', 'logradouro', 'numero_do_apartamento', 'numero_do_box', 'inicio_da_locacao', 'mais_informacoes','cpf'], 'safe'],
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
        $query = Locatario::find();

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
            'inicio_da_locacao' => $this->inicio_da_locacao,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'contato', $this->contato])
            ->andFilterWhere(['like', 'codigo_do_imovel', $this->codigo_do_imovel])
            ->andFilterWhere(['like', 'logradouro', $this->logradouro])
            ->andFilterWhere(['like', 'numero_do_apartamento', $this->numero_do_apartamento])
            ->andFilterWhere(['like', 'numero_do_box', $this->numero_do_box])
            ->andFilterWhere(['like', 'mais_informacoes', $this->mais_informacoes])
            ->andFilterWhere(['like', 'cpf', $this->cpf]);

        return $dataProvider;
    }
}
