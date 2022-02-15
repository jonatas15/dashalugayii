<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuariopermutas;

/**
 * UsuariopermutasSearch represents the model behind the search form about `app\models\Usuariopermutas`.
 */
class UsuariopermutasSearch extends Usuariopermutas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permuta', 'usuario'], 'integer'],
            [['observacoes'], 'safe'],
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
        $query = Usuariopermutas::find();

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
            'permuta' => $this->permuta,
            'usuario' => $this->usuario,
        ]);

        $query->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
