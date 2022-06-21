<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visita;

/**
 * VisitaSearch represents the model behind the search form about `app\models\Visita`.
 */
class VisitaSearch extends Visita
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idvisita', 'usuario_id', 'id_corretor', 'convertido'], 'integer'],
            [['data_registro', 'data_visita', 'hora_visita', 'codigo_imovel', 'nome_cliente', 'imobiliaria_parceria', 'observacoes', 'mes', 'convertido', 'contrato', 'ano'], 'safe'],
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
        $query = Visita::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 400,
            ],
            'sort' => [
                'defaultOrder' => [
                    'data_visita' => SORT_DESC,
                ]
            ],
        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(!empty($this->data_visita)){
            $data = explode(' - ', $this->data_visita);
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // $this->data_visita = date("Y-m-d", strtotime($this->data_visita));
            $data1 = $data[0];
            $data2 = $data[1];
        }

        $ano_recebido = filter_input(INPUT_GET, 'ano', FILTER_SANITIZE_STRING);
        $this->ano = ($ano_recebido !='' ? $ano_recebido : '2022');


        // grid filtering conditions
        $query->andFilterWhere([
            'idvisita' => $this->idvisita,
            'usuario_id' => $this->usuario_id,
            'data_registro' => $this->data_registro,
            'MONTH(data_visita)' => $this->mes,
            'YEAR(data_visita)' => $this->ano,
            'hora_visita' => $this->hora_visita,
            'id_corretor' => $this->id_corretor,
            'contrato' => 'locação',
            'convertido' => $this->convertido,
        ]);

        $query->andFilterWhere(['like', 'codigo_imovel', $this->codigo_imovel])
            ->andFilterWhere(['like', 'nome_cliente', $this->nome_cliente])
            ->andFilterWhere(['like', 'data_visita', $this->ano])
            ->andFilterWhere(['between', 'data_visita', $data1, $data2])
            ->andFilterWhere(['like', 'imobiliaria_parceria', $this->imobiliaria_parceria])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);

            // ->andFilterWhere(['like', 'MONTH(data_visita)', $this->mes])

        return $dataProvider;
    }
}
