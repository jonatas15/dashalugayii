<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Extrato;
use app\models\Proprietario;
use app\models\Locatario;

/**
 * ExtratoSearch represents the model behind the search form about `app\models\Extrato`.
 */
class ExtratoSearch extends Extrato
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'locatario_id', 'proprietario_id', 'base_id'], 'integer'],
            [['mes', 'data_aplicacao', 'data_vencimento', 'nosso_numero', 'numero_nota', 'descricao_descontos', 'data_pagamento'], 'safe'],
            [['receita_locacao', 'receitas_subtotal', 'iptu', 'iptu_apt_garag', 'condominio', 'taxa_condominio', 'outros', 'total', 'honorarios_porcentagem', 'honorarios_valor', 'honorarios_admin', 'descontos_subtotal', 'total_depositado', 'valor_pago_ao_proprietario'], 'number'],
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
        if(Yii::$app->user->can('proprietario')):
            $Proprietario = Proprietario::find()->where(['usuario_id'=>Yii::$app->user->identity->id])->one();
            $query = Extrato::find()->where(['proprietario_id'=>$Proprietario->id]);
        elseif (Yii::$app->user->can('locatario')):
            $Locatario = Locatario::find()->where(['usuario_id'=>Yii::$app->user->identity->id])->one();
            $query = Extrato::find()->where(['locatario_id'=>$Locatario->id]);
        else:
            $query = Extrato::find();
        endif;
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
            'data_aplicacao' => $this->data_aplicacao,
            'data_vencimento' => $this->data_vencimento,
            'receita_locacao' => $this->receita_locacao,
            'receitas_subtotal' => $this->receitas_subtotal,
            'iptu' => $this->iptu,
            'iptu_apt_garag' => $this->iptu_apt_garag,
            'condominio' => $this->condominio,
            'taxa_condominio' => $this->taxa_condominio,
            'outros' => $this->outros,
            'total' => $this->total,
            'honorarios_porcentagem' => $this->honorarios_porcentagem,
            'honorarios_valor' => $this->honorarios_valor,
            'honorarios_admin' => $this->honorarios_admin,
            'descontos_subtotal' => $this->descontos_subtotal,
            'total_depositado' => $this->total_depositado,
            'valor_pago_ao_proprietario' => $this->valor_pago_ao_proprietario,
            'data_pagamento' => $this->data_pagamento,
            'locatario_id' => $this->locatario_id,
            'proprietario_id' => $this->proprietario_id,
            'base_id' => $this->base_id,
        ]);

        $query->andFilterWhere(['like', 'mes', $this->mes])
            ->andFilterWhere(['like', 'nosso_numero', $this->nosso_numero])
            ->andFilterWhere(['like', 'numero_nota', $this->numero_nota])
            ->andFilterWhere(['like', 'descricao_descontos', $this->descricao_descontos]);

        return $dataProvider;
    }
}
