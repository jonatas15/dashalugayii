<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SloProposta;

/**
 * PropostaSearch represents the model behind the search form about `app\models\SloProposta`.
 */
class PropostaSearch extends SloProposta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id'], 'integer'],
            [['tipo', 'prazo_responder', 'proprietario', 'proprietario_info', 'imovel_info', 'imovel_valores','codigo_imovel'], 'safe'],
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
        $query = SloProposta::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'data_inicio' => SORT_DESC 
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $data1 = '';
        $data2 = '';
        if(!empty($this->prazo_responder)){
            $data = explode(' - ', $this->prazo_responder);
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // $this->data_visita = date("Y-m-d", strtotime($this->data_visita));
            $data1 = $data[0];
            $data2 = $data[1];
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            // ->andFilterWhere(['like', 'prazo_responder', $this->prazo_responder])
            ->andFilterWhere(['between', 'prazo_responder', $data1, $data2])
            ->andFilterWhere(['like', 'proprietario', $this->proprietario])
            ->andFilterWhere(['like', 'proprietario_info', $this->proprietario_info])
            ->andFilterWhere(['like', 'imovel_info', $this->imovel_info])
            ->andFilterWhere(['like', 'codigo_imovel', $this->codigo_imovel])
            ->andFilterWhere(['like', 'imovel_valores', $this->imovel_valores]);

        return $dataProvider;
    }
}
