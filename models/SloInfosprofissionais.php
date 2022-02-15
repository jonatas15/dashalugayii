<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_infosprofissionais".
 *
 * @property integer $id
 * @property integer $pretendente_id
 * @property integer $conjuje_id
 * @property string $empresa
 * @property string $fone
 * @property string $data_admissao
 * @property string $vinculo_empregaticio
 * @property string $profissao
 * @property string $salario
 * @property string $outros_rendimentos
 * @property string $total_rendimentos
 * @property string $possui_renda
 * @property string $compoe_renda
 *
 * @property SloConjuje $conjuje
 * @property SloPretendente $pretendente
 */
class SloInfosprofissionais extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_infosprofissionais';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pretendente_id', 'conjuje_id', 'possui_renda', 'compoe_renda'], 'integer'],
            [['data_admissao'], 'safe'],
            [['vinculo_empregaticio','cnpj',
                'empganterior_empresa',
                'empganterior_fone',
                'empganterior_periodo',
                'empganterior_endereco',
                'empganterior_end_numero',
                'empganterior_end_complemento',
                'empganterior_end_bairro',
                'empganterior_end_cidade',
                'empganterior_end_estado',
                'empganterior_end_cep',
            ], 'string'],
            [['empresa'], 'string', 'max' => 50],
            [['fone'], 'string', 'max' => 25],
            [['profissao', 'salario'], 'string', 'max' => 45],
            [['outros_rendimentos'], 'string', 'max' => 255],
            [['total_rendimentos'], 'string', 'max' => 100],
            [['conjuje_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloConjuje::className(), 'targetAttribute' => ['conjuje_id' => 'id']],
            [['pretendente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloPretendente::className(), 'targetAttribute' => ['pretendente_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pretendente_id' => 'Pretendente',
            'conjuje_id' => 'Cônjuje',
            'empresa' => 'Empresa',
            'fone' => 'Telefone',
            'data_admissao' => 'Data de admissão',
            'vinculo_empregaticio' => 'Vínculo empregatício',
            'profissao' => 'Profissão',
            'salario' => 'Salário',
            'outros_rendimentos' => 'Outros rendimentos',
            'total_rendimentos' => 'Total de rendimentos',
            'possui_renda' => 'Possui renda para arcar financeiramente com a Locação?',
            'compoe_renda' => 'Compõe Renda?',
            'cnpj' => 'CNPJ',
            'empganterior_empresa' => 'Empresa',
            'empganterior_fone' => 'Telefone',
            'empganterior_periodo' => 'Período trabalhado',
            'empganterior_endereco' => 'Endereço',
            'empganterior_end_numero' => 'Número',
            'empganterior_end_complemento' => 'Complemento',
            'empganterior_end_bairro' => 'Bairro',
            'empganterior_end_cidade' => 'Cidade',
            'empganterior_end_estado' => 'Estado',
            'empganterior_end_cep' => 'CEP',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConjuje()
    {
        return $this->hasOne(SloConjuje::className(), ['id' => 'conjuje_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'pretendente_id']);
    }
}
