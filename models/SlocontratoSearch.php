<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Slocontrato;

/**
 * SlocontratoSearch represents the model behind the search form of `\app\models\Slocontrato`.
 */
class SlocontratoSearch extends Slocontrato
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'proposta_id', 'nm_diavencimento_con', 'nm_mesreajuste_con', 'fl_mesfechado_con', 'fl_diafixorepasse_con', 'nm_diarepasse_con', 'fl_mesvencido_con', 'id_filial_fil', 'nm_repassegarantido_con', 'fl_garantia_con', 'fl_seguroincendio_con', 'fl_endcobranca_con'], 'integer'],
            [['id_imovel_imo', 'id_tipo_con', 'dt_inicio_con', 'dt_fim_con', 'dt_ultimoreajuste_con', 'id_contabanco_cb', 'fl_dimob_con', 'st_observacao_con'], 'safe'],
            [['vl_aluguel_con', 'tx_adm_con', 'fl_txadmvalorfixo_con', 'tx_locacao_con', 'id_indicereajuste_con'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Slocontrato::find();

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
            'proposta_id' => $this->proposta_id,
            'dt_inicio_con' => $this->dt_inicio_con,
            'dt_fim_con' => $this->dt_fim_con,
            'vl_aluguel_con' => $this->vl_aluguel_con,
            'tx_adm_con' => $this->tx_adm_con,
            'fl_txadmvalorfixo_con' => $this->fl_txadmvalorfixo_con,
            'nm_diavencimento_con' => $this->nm_diavencimento_con,
            'tx_locacao_con' => $this->tx_locacao_con,
            'id_indicereajuste_con' => $this->id_indicereajuste_con,
            'nm_mesreajuste_con' => $this->nm_mesreajuste_con,
            'dt_ultimoreajuste_con' => $this->dt_ultimoreajuste_con,
            'fl_mesfechado_con' => $this->fl_mesfechado_con,
            'fl_diafixorepasse_con' => $this->fl_diafixorepasse_con,
            'nm_diarepasse_con' => $this->nm_diarepasse_con,
            'fl_mesvencido_con' => $this->fl_mesvencido_con,
            'id_filial_fil' => $this->id_filial_fil,
            'nm_repassegarantido_con' => $this->nm_repassegarantido_con,
            'fl_garantia_con' => $this->fl_garantia_con,
            'fl_seguroincendio_con' => $this->fl_seguroincendio_con,
            'fl_endcobranca_con' => $this->fl_endcobranca_con,
        ]);

        $query->andFilterWhere(['like', 'id_imovel_imo', $this->id_imovel_imo])
            ->andFilterWhere(['like', 'id_tipo_con', $this->id_tipo_con])
            ->andFilterWhere(['like', 'id_contabanco_cb', $this->id_contabanco_cb])
            ->andFilterWhere(['like', 'fl_dimob_con', $this->fl_dimob_con])
            ->andFilterWhere(['like', 'st_observacao_con', $this->st_observacao_con]);

        return $dataProvider;
    }
}
