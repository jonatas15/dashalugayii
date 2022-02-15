<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CyberComentario;

/**
 * CybercomentarioSearch represents the model behind the search form about `app\models\CyberComentario`.
 */
class CybercomentarioSearch extends CyberComentario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcyber_comentario', 'usuario_id', 'cyber_topico_idtopico', 'cyber_idcyber'], 'integer'],
            [['comentario', 'datetime', 'imagem', 'documento'], 'safe'],
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
        $query = CyberComentario::find();

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
            'idcyber_comentario' => $this->idcyber_comentario,
            'usuario_id' => $this->usuario_id,
            'cyber_topico_idtopico' => $this->cyber_topico_idtopico,
            'cyber_idcyber' => $this->cyber_idcyber,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'comentario', $this->comentario])
            ->andFilterWhere(['like', 'imagem', $this->imagem])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
    }
}
