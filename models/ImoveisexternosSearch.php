<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Imoveisexternos;
use app\models\Condominio;
use yii\helpers\ArrayHelper;

/**
 * ImoveisexternosSearch represents the model behind the search form about `app\models\Imoveisexternos`.
 */
class ImoveisexternosSearch extends Imoveisexternos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'imobiliarias_id', 'dormitorios', 'banheiros', 'garagens', 'elevador', 'sacada', 'financiavel', 'negociavel', 'aceita_permuta'], 'integer'],
            [['url_imovel', 'codigo', 'contrato', 'tipo', 'endereco_estado', 'endereco_cidade', 'endereco_bairro', 'endereco_logradouro', 'comodidades', 'condominio', 'observacoes', 'data_cadastro', 'data_alteracao','valoresdevenda','valoresdelocacao','arr_dormitorios'], 'safe'],
            [['valor_venda', 'valor_locacao', 'area_privativa', 'area_total'], 'number'],
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
        $query = Imoveisexternos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 
                'pageSize' => 100, 
            ], 
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //Comodidades
        $comodidades = $this->comodidades;
        $ors5 = [
            'or',
            ['like', 'comodidades', $this->comodidades],
        ];
        if(!empty($comodidades)):
            foreach ($comodidades as $b):
                array_push($ors5,['like', 'comodidades', $b]);
            endforeach;
            $query->andFilterWhere($ors5)->orWhere(['comodidades' => '']);
        else:
            $query->andFilterWhere($ors5);
        endif;
        //Bairros
        $bairros = $this->endereco_bairro;
        $ors = [
            'or',
            ['like', 'endereco_bairro', $this->endereco_bairro],
        ];
        if(!empty($bairros)):
            foreach ($bairros as $b):
                array_push($ors,['like', 'endereco_bairro', $b]);
            endforeach;
            $query->andFilterWhere($ors)->orWhere(['endereco_bairro' => '']);
        else:
            $query->andFilterWhere($ors);
        endif;
        //Tipos
        $tipos = $this->tipo;
        $ors2 = [
            'or',
            ['like', 'tipo', $this->tipo],
        ];
        if(!empty($tipos))
        foreach ($tipos as $t):
            array_push($ors2,['like', 'tipo', $t]);
        endforeach;

        $query->andFilterWhere($ors2);
        //Condomínios
        $all_condominios = $this->condominio;
        
        $ors3 = [
            'or',
            ['like', 'condominio', $this->condominio],
        ];
        if(!empty($all_condominios)):
            foreach ($all_condominios as $t):
                array_push($ors3,['like', 'condominio', $t]);
            endforeach;
        else:
            $query->andFilterWhere($ors3);
        endif;
        $query->andFilterWhere($ors3);

        //Dormitórios
        $dormitorios = $this->arr_dormitorios;
        $ors4 = [
            'or',
            ['dormitorios'=> $this->arr_dormitorios],
        ];
        if(!empty($dormitorios)):
            foreach ($dormitorios as $t):
                if($t>10){
                    array_push($ors4,['>', 'dormitorios', (int)$t]);
                }else{
                    array_push($ors4,['dormitorios' => (int)$t]);
                }
            endforeach;
        endif;
        $query->andFilterWhere($ors4);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'imobiliarias_id' => $this->imobiliarias_id,
            // 'valor_venda' => $this->valor_venda,
            'valor_locacao' => $this->valor_locacao,
            // 'dormitorios' => $this->dormitorios,
            // 'banheiros' => $this->banheiros,
            // 'garagens' => $this->garagens,
            'elevador' => $this->elevador,
            'sacada' => $this->sacada,
            // 'area_privativa' => $this->area_privativa,
            'area_total' => $this->area_total,
            'financiavel' => $this->financiavel,
            'negociavel' => $this->negociavel,
            'aceita_permuta' => $this->aceita_permuta,
            'data_cadastro' => $this->data_cadastro,
            'data_alteracao' => $this->data_alteracao,
            'contrato' => $this->contrato,
        ]);
        
        //Gambiarra pra área privativa = 5; devido a erro do plugin de sliderange
        if($this->area_privativa == 5 or is_null($this->area_privativa)){
            $this->area_privativa = 0;
        }

        $valoresdevenda = ['0','1000000'];
        if(!empty($this->valoresdevenda) or !empty($this->valoresdelocacao)){
            if($this->contrato == 'Locação'){
                $valoresdevenda = explode(',',$this->valoresdelocacao);
            }else{
                $valoresdevenda = explode(',',$this->valoresdevenda);
            }
        }
        $valor_venda_min = $valoresdevenda[0];
        $valor_venda_max = $valoresdevenda[1];

        if($this->contrato == 'Locação'){
            if ($valor_venda_max == 20000) {
                $valor_venda_max = 1000000;
            }
        }else{
            if ($valor_venda_max == 1000000) {
                $valor_venda_max = 99999999;
            }
        }
        //Gambiarra pra valor de venda mínima = 5; devido a erro do plugin de sliderange
        if ($valor_venda_min == 5){
            $valor_venda_min = 0;
        }
        if (is_null($this->valor_venda)){
            $this->valor_venda = 0;
        }
        
        // if ($valor_venda_min == 0) {
        //     $valor_venda_min =  -1;
        // }

        // echo '<pre>';
        // echo 'teste aqui<br>';
        // echo 'teste aqui<br>';
        // echo 'teste aqui<br>';
        // echo 'teste aqui<br>';
        // echo 'teste aqui<br>';
        // echo 'teste aqui<br>';
        // echo $valor_venda_max;
        // echo $valor_venda_min;
        // echo '</pre>';

        $query->andFilterWhere(['like', 'url_imovel', $this->url_imovel])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['<', 'valor_venda', $valor_venda_max])
            ->andFilterWhere(['>=', 'garagens', $this->garagens])
            ->andFilterWhere(['>=', 'banheiros', $this->banheiros])
            ->andFilterWhere(['>=', 'valor_venda', $valor_venda_min])
            ->andFilterWhere(['>=', 'area_privativa', $this->area_privativa]);
            // ->andFilterWhere(['like', 'observacoes', $this->observacoes]);
            // ->andFilterWhere(['like', 'contrato', $this->contrato])
            // ->andFilterWhere(['like', 'tipo', $this->tipo])
            // ->andFilterWhere(['like', 'endereco_estado', $this->endereco_estado])
            // ->andFilterWhere(['like', 'endereco_cidade', $this->endereco_cidade])
            // ->andFilterWhere(['like', 'endereco_bairro', $this->endereco_bairro])
            // ->andFilterWhere(['like', 'endereco_logradouro', $this->endereco_logradouro])
            // ->andFilterWhere(['like', 'comodidades', $this->comodidades])
            // ->andFilterWhere(['like', 'condominio', $this->condominio])

        return $dataProvider;
    }
}
