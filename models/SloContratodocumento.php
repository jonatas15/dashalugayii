<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_contratodocumento".
 *
 * @property integer $id
 * @property integer $slo_pretendente_id
 * @property string $tipo_documento
 * @property string $numero
 * @property string $orgao_expedidor
 * @property string $data_expedicao
 * @property string $frente_documento
 * @property string $verso_documento
 * @property string $selfie_com_documento
 * @property string $endereco
 * @property string $outros_comprovantes
 * @property string $nacionalidade
 * @property string $fone_residencial
 * @property string $fone_celular
 * @property string $profissao
 * @property string $endereco_atual
 * @property string $end_numero
 * @property string $end_complemento
 * @property string $end_bairro
 * @property string $end_cep
 * @property string $end_cidade
 * @property string $end_estado
 * @property string $estado_civil
 * @property string $nome_conjuge
 * @property integer $id_conjuge_pretendente
 * @property string $conj_nome
 * @property string $conj_mail
 * @property string $conj_cpf
 *
 * @property SloPretendente $sloPretendente
 */
class SloContratodocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_contratodocumento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slo_pretendente_id'], 'required'],
            [['slo_pretendente_id', 'id_conjuge_pretendente'], 'integer'],
            [['tipo_documento', 'outros_comprovantes'], 'string'],
            [['data_expedicao'], 'safe'],
            [['numero'], 'string', 'max' => 20],
            [['orgao_emissor', 'nacionalidade', 'end_estado'], 'string', 'max' => 45],
            [['frente_documento', 'verso_documento', 'selfie_com_documento', 'end_bairro', 'conj_nome', 'conj_mail'], 'string', 'max' => 145],
            [['endereco', 'endereco_atual', 'nome_conjuge'], 'string', 'max' => 245],
            [['fone_residencial', 'fone_celular'], 'string', 'max' => 12],
            [['profissao'], 'string', 'max' => 75],
            [['end_numero', 'end_complemento', 'estado_civil', 'conj_cpf'], 'string', 'max' => 15],
            [['end_cep'], 'string', 'max' => 10],
            [['end_cidade'], 'string', 'max' => 100],
            [['slo_pretendente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloPretendente::className(), 'targetAttribute' => ['slo_pretendente_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slo_pretendente_id' => 'Pretendente',
            'tipo_documento' => 'Tipo de documento',
            'numero' => 'N??mero do documento',
            // 'orgao_expedidor' => '??rg??o expedidor',
            'data_expedicao' => 'Data de expedi????o',
            'frente_documento' => 'Frente do documento',
            'verso_documento' => 'Verso do documento',
            'selfie_com_documento' => 'Selfie com o documento',
            'endereco' => 'Endere??o',
            'outros_comprovantes' => 'Outros comprovantes',
            'nacionalidade' => 'Nacionalidade',
            'fone_residencial' => 'Telefone Residencial',
            'fone_celular' => 'Telefone Celular',
            'profissao' => 'Profiss??o',
            'endereco_atual' => 'Endere??o Atual',
            'end_numero' => 'Endere??o: N??mero',
            'end_complemento' => 'Endere??o: Complemento',
            'end_bairro' => 'Endere??o: Bairro',
            'end_cep' => 'Endere??o: CEP',
            'end_cidade' => 'Endere??o: Cidade',
            'end_estado' => 'Endere??o: Estado',
            'estado_civil' => 'Estado Civil',
            'nome_conjuge' => 'Nome do C??njuge',
            'id_conjuge_pretendente' => 'Id Conjuge Pretendente',
            'conj_nome' => 'C??njuge: Nome',
            'conj_mail' => 'C??njuge: Mail',
            'conj_cpf' => 'C??njuge: Cpf',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'slo_pretendente_id']);
    }
    public function getConjuge()
    {
        return $this->hasOne(SloContratodocumento::className(), ['id_conjuge_pretendente' => 'id']);
    }
}
