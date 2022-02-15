<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CyberTopico;

/**
 * CybertopicoSearch represents the model behind the search form about `app\models\CyberTopico`.
 */
class CybertopicoSearch extends CyberTopico
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtopico', 'cyber_idcyber', 'usuario_id', 'topico_pai'], 'integer'],
            [['titulo', 'tipo', 'descricao', 'palavraschaves', 'imagem', 'documento', 'datetime', 'buscatudo'], 'safe'],
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
        $query = CyberTopico::find()->select([
            'cyber_topico.*',
            'count(case topico_membros.favorito when 1 then 1 else null end) as contaisso',
            'count(case topico_membros.ajudou when 1 then 1 else null end) as ajudas',
            'count(case topico_membros.nao_ajudou when 1 then 1 else null end) as nao_ajudas',
        ])
        ->join('LEFT JOIN', 'topico_membros', 'topico_membros.topico_idtopico = cyber_topico.idtopico')
        ->joinWith(['cyberIdcyber'])
        ->groupBy('cyber_topico.idtopico')
        ->orderBy([
            'contaisso' => SORT_DESC,
            'ajudas' => SORT_DESC,
            'nao_ajudas' => SORT_ASC,
            'titulo' => SORT_ASC,
        ]);
        
        if($_REQUEST['cyber_idcyber']){
            $this->cyber_idcyber = $_REQUEST['cyber_idcyber'];    
        }
        
        $thiscybercol = '';
        if (Yii::$app->user->can('corretor')) {
            $thiscybercol = 'corretor,publico';
        }
        if (Yii::$app->user->can('vendas')) {
            $thiscybercol = 'vendas,publico';
        }
        if (Yii::$app->user->can('locacao')) {
            $thiscybercol = 'locacao,publico';
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 
                'pageSize' => 100, 
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
            'idtopico' => $this->idtopico,
            'cyber_idcyber' => $this->cyber_idcyber,
            'usuario_id' => $this->usuario_id,
            'datetime' => $this->datetime,
            'topico_pai' => $this->topico_pai,
            // 'cyber.cybercol' => $thiscybercol,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'cyber_topico.descricao', $this->descricao])
            ->andFilterWhere(['like', 'cyber_topico.palavraschaves', $this->palavraschaves])
            ->andFilterWhere(['like', 'imagem', $this->imagem])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        $ors = [
            'or',
            ['like', 'titulo', $this->buscatudo],
            ['like', 'cyber_topico.descricao', $this->buscatudo],
            ['like', 'cyber_topico.palavraschaves', $this->buscatudo]
        ];

        $palavras = explode(' ',$this->buscatudo);

        foreach ($palavras as $b) {
            array_push($ors, ['like', 'titulo', $b]);
            array_push($ors, ['like', 'cyber_topico.descricao', $b]);
            array_push($ors, ['like', 'cyber_topico.palavraschaves', $b]);
        }

        //Especificação de Usuários
        $thiscybercol = explode(',',$thiscybercol);
        foreach ($thiscybercol as $row) {
            array_push($ors, ['like', 'cyber.cybercol', $row]);
        }

        $query->andFilterWhere($ors);

        return $dataProvider;
    }
}
