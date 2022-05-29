<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slocontrato".
 *
 * @property int $id
 * @property int $proposta_id
 * @property string|null $id_imovel_imo
 * @property string|null $id_tipo_con
 * @property string|null $dt_inicio_con
 * @property string|null $dt_fim_con
 * @property float|null $vl_aluguel_con
 * @property float|null $tx_adm_con
 * @property float|null $fl_txadmvalorfixo_con
 * @property int|null $nm_diavencimento_con
 * @property float|null $tx_locacao_con
 * @property float|null $id_indicereajuste_con
 * @property int|null $nm_mesreajuste_con
 * @property string|null $dt_ultimoreajuste_con
 * @property int|null $fl_mesfechado_con
 * @property string|null $id_contabanco_cb
 * @property int|null $fl_diafixorepasse_con
 * @property int|null $nm_diarepasse_con
 * @property int|null $fl_mesvencido_con
 * @property string|null $fl_dimob_con
 * @property int|null $id_filial_fil
 * @property string|null $st_observacao_con
 * @property int|null $nm_repassegarantido_con
 * @property int|null $fl_garantia_con
 * @property int|null $fl_seguroincendio_con
 * @property int|null $fl_endcobranca_con
 *
 * @property SloProposta $proposta
 */
class Slocontrato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slocontrato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proposta_id'], 'required'],
            [['proposta_id', 'nm_diavencimento_con', 'nm_mesreajuste_con', 'fl_mesfechado_con', 'fl_diafixorepasse_con', 'nm_diarepasse_con', 'fl_mesvencido_con', 'id_filial_fil', 'nm_repassegarantido_con', 'fl_garantia_con', 'fl_seguroincendio_con', 'fl_endcobranca_con'], 'integer'],
            [['dt_inicio_con', 'dt_fim_con', 'dt_ultimoreajuste_con'], 'safe'],
            [['vl_aluguel_con', 'tx_adm_con', 'fl_txadmvalorfixo_con', 'tx_locacao_con', 'id_indicereajuste_con'], 'number'],
            [['fl_dimob_con'], 'string'],
            [['id_imovel_imo'], 'string', 'max' => 10],
            [['id_tipo_con'], 'string', 'max' => 2],
            [['id_contabanco_cb'], 'string', 'max' => 45],
            [['st_observacao_con'], 'string', 'max' => 255],
            [['proposta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloProposta::className(), 'targetAttribute' => ['proposta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proposta_id' => 'Proposta ID',
            'id_imovel_imo' => 'Id Imovel Imo',
            'id_tipo_con' => 'Id Tipo Con',
            'dt_inicio_con' => 'Dt Inicio Con',
            'dt_fim_con' => 'Dt Fim Con',
            'vl_aluguel_con' => 'Vl Aluguel Con',
            'tx_adm_con' => 'Tx Adm Con',
            'fl_txadmvalorfixo_con' => 'Fl Txadmvalorfixo Con',
            'nm_diavencimento_con' => 'Nm Diavencimento Con',
            'tx_locacao_con' => 'Tx Locacao Con',
            'id_indicereajuste_con' => 'Id Indicereajuste Con',
            'nm_mesreajuste_con' => 'Nm Mesreajuste Con',
            'dt_ultimoreajuste_con' => 'Dt Ultimoreajuste Con',
            'fl_mesfechado_con' => 'Fl Mesfechado Con',
            'id_contabanco_cb' => 'Id Contabanco Cb',
            'fl_diafixorepasse_con' => 'Fl Diafixorepasse Con',
            'nm_diarepasse_con' => 'Nm Diarepasse Con',
            'fl_mesvencido_con' => 'Fl Mesvencido Con',
            'fl_dimob_con' => 'Fl Dimob Con',
            'id_filial_fil' => 'Id Filial Fil',
            'st_observacao_con' => 'St Observacao Con',
            'nm_repassegarantido_con' => 'Nm Repassegarantido Con',
            'fl_garantia_con' => 'Fl Garantia Con',
            'fl_seguroincendio_con' => 'Fl Seguroincendio Con',
            'fl_endcobranca_con' => 'Fl Endcobranca Con',
        ];
    }

    /**
     * Gets query for [[Proposta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProposta()
    {
        return $this->hasOne(SloProposta::className(), ['id' => 'proposta_id']);
    }
}
