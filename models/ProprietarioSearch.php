<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proprietario;

/**
 * ProprietarioSearch represents the model behind the search form of `\app\models\Proprietario`.
 */
class ProprietarioSearch extends Proprietario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'proposta_id'], 'integer'],
            [['nome', 'conta_deposito', 'codigo_imovel', 'logradouro', 'inicio_locacao', 'mais_informacoes', 'celular', 'telefone', 'email', 'cpf_cnpj', 'rg', 'orgao', 'sexo', 'data_nascimento', 'nacionalidade', 'cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'foto_rg', 'foto_cpf'], 'safe'],
            [['iptu', 'condominio'], 'number'],
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
        $query = Proprietario::find();

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
            'inicio_locacao' => $this->inicio_locacao,
            'usuario_id' => $this->usuario_id,
            'data_nascimento' => $this->data_nascimento,
            'proposta_id' => $this->proposta_id,
            'iptu' => $this->iptu,
            'condominio' => $this->condominio,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'conta_deposito', $this->conta_deposito])
            ->andFilterWhere(['like', 'codigo_imovel', $this->codigo_imovel])
            ->andFilterWhere(['like', 'logradouro', $this->logradouro])
            ->andFilterWhere(['like', 'mais_informacoes', $this->mais_informacoes])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'telefone', $this->telefone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'cpf_cnpj', $this->cpf_cnpj])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'orgao', $this->orgao])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'nacionalidade', $this->nacionalidade])
            ->andFilterWhere(['like', 'cep', $this->cep])
            ->andFilterWhere(['like', 'endereco', $this->endereco])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'complemento', $this->complemento])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'cidade', $this->cidade])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'foto_rg', $this->foto_rg])
            ->andFilterWhere(['like', 'foto_cpf', $this->foto_cpf]);

        return $dataProvider;
    }
}
