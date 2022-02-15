<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Base;

/**
 * BaseSearch represents the model behind the search form about `app\models\Base`.
 */
class BaseSearch extends Base
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'proprietario_id'], 'integer'],
            [['codigo', 'nome', 'logradouro', 'numero_apartamento', 'numero_box'], 'safe'],
            [['valor'], 'number'],
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
        $query = Base::find();

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
            'valor' => $this->valor,
            'proprietario_id' => $this->proprietario_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'logradouro', $this->logradouro])
            ->andFilterWhere(['like', 'numero_apartamento', $this->numero_apartamento])
            ->andFilterWhere(['like', 'numero_box', $this->numero_box]);

        return $dataProvider;
    }
}
