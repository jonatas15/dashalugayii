<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Condominio;

/**
 * CondominioSearch represents the model behind the search form about `app\models\Condominio`.
 */
class CondominioSearch extends Condominio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_imobiliarias'], 'integer'],
            [['nome', 'slug', 'url', 'observacoes'], 'safe'],
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
        $query = Condominio::find();

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
            'id_imobiliarias' => $this->id_imobiliarias,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
