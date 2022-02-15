<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ImovelPermuta;

/**
 * ImovelpermutaSearch represents the model behind the search form about `app\models\ImovelPermuta`.
 */
class ImovelpermutaSearch extends ImovelPermuta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idimovel_permuta', 'dormitorios', 'garagens', 'elevador', 'sacada', 'tipo_imovel'], 'integer'],
            [['codigo', 'bairros', 'tipo', 'observacoes'], 'safe'],
            [['area_privativa', 'area_total', 'valor_maximo', 'valor_minimo'], 'number'],
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
        $query = ImovelPermuta::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
            'idimovel_permuta' => $this->idimovel_permuta,
            // 'dormitorios' => $this->dormitorios,
            // 'garagens' => $this->garagens,
            // 'area_privativa' => $this->area_privativa,
            // 'area_total' => $this->area_total,
            'elevador' => $this->elevador,
            'sacada' => $this->sacada,
            // 'valor_maximo' => $this->valor_maximo,
            // 'valor_minimo' => $this->valor_minimo,
            'tipo_imovel' => $this->tipo_imovel,
        ]);

        $bairros = $this->bairros;
        $ors = [
            'or',
            ['like', 'bairros', $this->bairros],
        ];
        if(!empty($bairros)):
            foreach ($bairros as $b):
                array_push($ors,['like', 'bairros', $b]);
            endforeach;
            $query->andFilterWhere($ors)->orWhere(['bairros' => '']);
        else:
            $query->andFilterWhere($ors);
        endif;

        // $query->andFilterWhere(['bairros' => '']);
        
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

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['>=', 'valor_minimo', $this->valor_minimo])
            ->andFilterWhere(['<=', 'valor_maximo', $this->valor_maximo])
            ->andFilterWhere(['>=', 'area_total', $this->area_total])
            ->andFilterWhere(['>=', 'area_privativa', $this->area_privativa])
            ->andFilterWhere(['>=', 'garagens', $this->garagens])
            ->andFilterWhere(['>=', 'dormitorios', $this->dormitorios])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);
            // ->andFilterWhere(['like', 'tipo', $this->tipo]);
            // ->andFilterWhere(['like', 'bairros', $this->bairros])
        // $query->orFilterWhere(['bairros' => '']);
        return $dataProvider;
    }
}
