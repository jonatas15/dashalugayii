<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chtopico;

/**
 * ChtopicoSearch represents the model behind the search form about `app\models\Chtopico`.
 */
class ChtopicoSearch extends Chtopico
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'checked', 'checklist_id', 'topico_pai'], 'integer'],
            [['conteudo'], 'safe'],
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
        $query = Chtopico::find();

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
            'checked' => $this->checked,
            'checklist_id' => $this->checklist_id,
            'topico_pai' => $this->topico_pai,
        ]);

        $query->andFilterWhere(['like', 'conteudo', $this->conteudo]);

        return $dataProvider;
    }
}
