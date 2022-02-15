<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cyber;

/**
 * CyberSearch represents the model behind the search form about `app\models\Cyber`.
 */
class CyberSearch extends Cyber
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcyber', 'usuario_id'], 'integer'],
            [['nome', 'descricao', 'cor', 'palavraschaves', 'cybercol', 'datetime', 'buscatudo'], 'safe'],
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
        
        
        $query = Cyber::find()->joinWith(['cyberTopicos']);

        // echo "<pre>";
        // echo $query->createCommand()->getRawSql();
        // echo "</pre>";

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 
                'pageSize' => 300, 
            ],
        ]);

        $this->load($params);

        if (Yii::$app->user->can('corretor')) {
            $this->cybercol = 'corretor,publico';
        }
        if (Yii::$app->user->can('vendas')) {
            $this->cybercol = 'vendas,publico';
        }
        if (Yii::$app->user->can('locacao')) {
            $this->cybercol = 'locacao,publico';
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idcyber' => $this->idcyber,
            'usuario_id' => $this->usuario_id,
            'datetime' => $this->datetime,
            // 'cybercol'=> $this->cybercol,
        ]);
        
        
        //     ->andFilterWhere(['like', 'descricao', $this->descricao])
        //     ->andFilterWhere(['like', 'cor', $this->cor])
        //     ->andFilterWhere(['like', 'palavraschaves', $this->palavraschaves])
        //     ->andFilterWhere(['like', 'cybercol', $this->cybercol]);

        $ors = [
            'or',
            ['like', 'cyber.nome', $this->buscatudo],
            ['like', 'cyber.descricao', $this->buscatudo],
            ['like', 'cyber.palavraschaves', $this->buscatudo],
            ['like', 'cyber_topico.titulo', $this->buscatudo],
            ['like', 'cyber_topico.descricao', $this->buscatudo],
            ['like', 'cyber_topico.palavraschaves', $this->buscatudo],
        ];

        $palavras = explode(' ',$this->buscatudo);

        foreach ($palavras as $b) {
            array_push($ors, ['like', 'cyber.nome', $b]);
            array_push($ors, ['like', 'cyber.descricao', $b]);
            array_push($ors, ['like', 'cyber.palavraschaves', $b]);
            array_push($ors, ['like', 'cyber_topico.titulo', $b]);
            array_push($ors, ['like', 'cyber_topico.descricao', $b]);
            array_push($ors, ['like', 'cyber_topico.palavraschaves', $b]);
        }

        //Especificação de Usuários
        $thiscybercol = explode(',',$this->cybercol);
        foreach ($thiscybercol as $row) {
            array_push($ors, ['like', 'cybercol', $row]);
        }

        $query->andFilterWhere($ors);

        return $dataProvider;
    }
}
