<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proprietario".
 *
 * @property int $id
 * @property string $nome Nome
 * @property string|null $conta_deposito Conta - depósito
 * @property string|null $codigo_imovel Código do Imóvel
 * @property string|null $logradouro Logradouro
 * @property string|null $inicio_locacao Início da Locação
 * @property string|null $mais_informacoes Mais Informações
 * @property string|null $celular Contato
 * @property string|null $telefone Contato
 * @property string|null $email Recebe
 * @property string|null $cpf_cnpj CPF/CNPJ
 * @property int|null $usuario_id Usuário
 * @property string|null $rg
 * @property string|null $orgao
 * @property string|null $sexo
 * @property string|null $data_nascimento
 * @property string|null $nacionalidade
 * @property string|null $cep
 * @property string|null $endereco
 * @property string|null $numero
 * @property string|null $complemento
 * @property string|null $bairro
 * @property string|null $cidade
 * @property string|null $estado
 * @property int|null $proposta_id
 *
 * @property Base[] $bases
 * @property Extrato[] $extratos
 */
class Proprietario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proprietario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['inicio_locacao', 'data_nascimento'], 'safe'],
            [['mais_informacoes', 'sexo'], 'string'],
            [['usuario_id', 'proposta_id'], 'integer'],
            [['nome'], 'string', 'max' => 145],
            [['conta_deposito', 'nacionalidade'], 'string', 'max' => 45],
            [['codigo_imovel', 'cep'], 'string', 'max' => 10],
            [['logradouro', 'email'], 'string', 'max' => 245],
            [['celular', 'telefone', 'cpf_cnpj', 'rg', 'complemento'], 'string', 'max' => 20],
            [['orgao', 'numero'], 'string', 'max' => 15],
            [['endereco', 'bairro'], 'string', 'max' => 255],
            [['cidade'], 'string', 'max' => 200],
            [['estado'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'conta_deposito' => 'Conta Deposito',
            'codigo_imovel' => 'Codigo Imovel',
            'logradouro' => 'Logradouro',
            'inicio_locacao' => 'Inicio Locacao',
            'mais_informacoes' => 'Mais Informacoes',
            'celular' => 'Celular',
            'telefone' => 'Telefone',
            'email' => 'Email',
            'cpf_cnpj' => 'Cpf Cnpj',
            'usuario_id' => 'Usuario ID',
            'rg' => 'Rg',
            'orgao' => 'Orgao',
            'sexo' => 'Sexo',
            'data_nascimento' => 'Data Nascimento',
            'nacionalidade' => 'Nacionalidade',
            'cep' => 'Cep',
            'endereco' => 'Endereco',
            'numero' => 'Numero',
            'complemento' => 'Complemento',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'proposta_id' => 'Proposta ID',
        ];
    }

    /**
     * Gets query for [[Bases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBases()
    {
        return $this->hasMany(Base::className(), ['proprietario_id' => 'id']);
    }

    /**
     * Gets query for [[Extratos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExtratos()
    {
        return $this->hasMany(Extrato::className(), ['proprietario_id' => 'id']);
    }
}
