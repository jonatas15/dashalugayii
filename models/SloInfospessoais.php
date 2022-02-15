<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_infospessoais".
 *
 * @property integer $id
 * @property integer $pretendente_id
 * @property integer $conjuje_id
 * @property string $nome
 * @property string $data_nascimento
 * @property string $cpf
 * @property integer $emancipado
 * @property string $fone_residencial
 * @property string $celular
 * @property integer $possui_renda
 * @property integer $vai_morar
 * @property string $estado_civil
 * @property string $genero
 * @property string $nacionalidade
 * @property string $extrangeiro_temponopais
 * @property integer $numero_dependentes
 * @property string $nome_pai
 * @property string $nome_mae
 * @property string $email
 * Novos Campos - Novo sistema de formulário
 * @property integer $slo_fiador_id 
 * @property integer $slo_fiadorconjuge_id 
 * @property string $tipo_documento 
 * @property string $numero_documento 
 * @property string $orgao_emissor 
 * @property string $data_emissao 
 * @property string $profissao 
 * @property string $renda_mensal 
 * @property string $cep 
 * @property string $endereco_atual 
 * @property string $numero 
 * @property string $complemento 
 * @property string $bairro 
 * @property string $cidade 
 * @property string $estado 
 * @property string $condicao_imovel
 *
 * @property SloConjuje $conjuje
 * @property SloPretendente $pretendente
 * @property SloFiador $sloFiador 
 * @property SloFiadorconjuge $sloFiadorconjuge 
 */
class SloInfospessoais extends \yii\db\ActiveRecord
{
    public $vai_morar_2;
    public $conj_fone_residencial;
    public $conj_celular;
    public $conj_genero;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_infospessoais';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pretendente_id', 'conjuje_id', 'emancipado', 'possui_renda', 'vai_morar', 'numero_dependentes', 'slo_fiador_id', 'slo_fiadorconjuge_id'], 'integer'],
            [['nome', 'data_nascimento', 'cpf'], 'required'],
            [['data_nascimento', 'data_emissao'], 'safe'],
            [['estado_civil', 'genero', 'nacionalidade', 'tipo_documento', 'endereco_atual'], 'string'],
            [['renda_mensal'], 'number'],
            [['nome'], 'string', 'max' => 245],
            [['cpf'], 'string', 'max' => 20],
            [['orgao_emissor'], 'string', 'max' => 15],
            [['fone_residencial', 'celular', 'conj_fone_residencial', 'conj_celular', 'conj_genero'], 'string', 'max' => 20],
            [['extrangeiro_temponopais'], 'string', 'max' => 20],
            [['nome_pai', 'nome_mae'], 'string', 'max' => 80],
            [['email'], 'string', 'max' => 120],
            [['numero_documento'], 'string', 'max' => 45], 
            [['profissao'], 'string', 'max' => 250], 
            [['cep'], 'string', 'max' => 8], 
            [['numero'], 'string', 'max' => 6], 
            [['complemento'], 'string', 'max' => 10], 
            [['bairro', 'cidade'], 'string', 'max' => 255], 
            [['estado'], 'string', 'max' => 2], 
            [['condicao_imovel'], 'string', 'max' => 25],
            [['conjuje_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloConjuje::className(), 'targetAttribute' => ['conjuje_id' => 'id']],
            [['slo_fiador_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloFiador::className(), 'targetAttribute' => ['slo_fiador_id' => 'id']],
            [['slo_fiadorconjuge_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloFiadorconjuge::className(), 'targetAttribute' => ['slo_fiadorconjuge_id' => 'id']],
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
            'pretendente_id' => 'Pretendente ID',
            'conjuje_id' => 'Conjuje ID',
            'nome' => 'Nome',
            'data_nascimento' => 'Data de Nascimento',
            'cpf' => 'CPF',
            'emancipado' => 'Emancipado',
            'fone_residencial' => 'Telefone Residencial',
            'celular' => 'Telefone Celular',
            'possui_renda' => 'Possui renda para arcar financeiramente com a Locação?',
            'vai_morar' => 'Irá residir no Imóvel?',
            'estado_civil' => 'Estado Civil:',
            'genero' => 'Sexo:',
            'nacionalidade' => 'Nacionalidade:',
            'extrangeiro_temponopais' => 'Se extrangeiro, há quanto tempo no país?',
            'numero_dependentes' => 'Número de Dependentes:',
            'nome_pai' => 'Nome do Pai:',
            'nome_mae' => 'Nome do Mãe:',
            'email' => 'Email',
            'tipo_documento' => 'Tipo de Documento',
            'numero_documento' => 'Número do Documento',
            'orgao_emissor' => 'Órgao Emissor',
            'data_emissao' => 'Data de Emissão',
            'profissao' => 'Profissão',
            'renda_mensal' => 'Renda Mensal',
            'cep' => 'Cep',
            'endereco_atual' => 'Endereço Atual',
            'numero' => 'Número',
            'complemento' => 'Complemento',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'condicao_imovel' => 'Condição do Imovel',
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
