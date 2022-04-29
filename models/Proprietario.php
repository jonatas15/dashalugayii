<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proprietario".
 *
 * @property int $id
 * @property int|null $superlogica
 * @property string $nome Nome
 * @property string|null $documento_tipo
 * @property string|null $documento_numero
 * @property string|null $estado_civil
 * @property string|null $nome_fantasia
 * @property string|null $conta_deposito Conta - depósito
 * @property string|null $banco
 * @property string|null $agencia
 * @property string|null $operacao
 * @property string|null $nome_titular
 * @property string|null $cpf_titular
 * @property string|null $codigo_imovel Código do Imóvel
 * @property string|null $logradouro Logradouro
 * @property string|null $inicio_locacao Início da Locação
 * @property string|null $mais_informacoes Mais Informações
 * @property string|null $celular Contato
 * @property string|null $telefone Contato
 * @property string|null $email Recebe
 * @property string|null $cpf_cnpj CPF/CNPJ
 * @property string|null $cpf
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
 * @property string|null $iptu
 * @property string|null $condominio
 * @property string|null $foto_rg
 * @property string|null $foto_cpf
 * @property string|null $cnj_nome Conjuge
 * @property string|null $cnj_email
 * @property string|null $cnj_cpf
 * @property string|null $cnj_documento_numero
 * @property string|null $cnj_nacionalidade
 * @property string|null $cnj_data_nascimento
 * @property string|null $cnj_telefone_celular
 * @property string|null $cnj_profissao
 * @property string|null $cnj_num_dependentes
 * @property string|null $cnj_foto_rg
 * @property string|null $cnj_foto_cpf
 * @property string|null $cnj_documento_tipo
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
            [['superlogica', 'usuario_id', 'proposta_id'], 'integer'],
            [['nome'], 'required'],
            [['inicio_locacao', 'data_nascimento', 'cnj_data_nascimento'], 'safe'],
            [['mais_informacoes', 'sexo', 'condominio', 'foto_rg', 'foto_cpf', 'cnj_foto_rg', 'cnj_foto_cpf'], 'string'],
            [['nome'], 'string', 'max' => 145],
            [['documento_tipo', 'documento_numero', 'estado_civil', 'nome_titular', 'estado', 'cnj_profissao', 'cnj_documento_tipo'], 'string', 'max' => 100],
            [['nome_fantasia', 'endereco', 'bairro', 'iptu'], 'string', 'max' => 255],
            [['conta_deposito', 'banco', 'agencia', 'operacao', 'nacionalidade', 'cnj_documento_numero'], 'string', 'max' => 45],
            [['cpf_titular', 'cpf', 'orgao', 'numero'], 'string', 'max' => 15],
            [['codigo_imovel', 'cep'], 'string', 'max' => 10],
            [['logradouro', 'email', 'cnj_nome', 'cnj_email'], 'string', 'max' => 245],
            [['celular', 'telefone', 'cpf_cnpj', 'rg', 'complemento', 'cnj_cpf', 'cnj_nacionalidade', 'cnj_telefone_celular'], 'string', 'max' => 20],
            [['cidade'], 'string', 'max' => 200],
            [['cnj_num_dependentes'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'superlogica' => 'Superlogica',
            'nome' => 'Nome',
            'documento_tipo' => 'Documento Tipo',
            'documento_numero' => 'Documento Numero',
            'estado_civil' => 'Estado Civil',
            'nome_fantasia' => 'Nome Fantasia',
            'conta_deposito' => 'Conta Deposito',
            'banco' => 'Banco',
            'agencia' => 'Agencia',
            'operacao' => 'Operacao',
            'nome_titular' => 'Nome do Titular',
            'cpf_titular' => 'Cpf do Titular',
            'codigo_imovel' => 'Codigo Imovel',
            'logradouro' => 'Logradouro',
            'inicio_locacao' => 'Inicio Locacao',
            'mais_informacoes' => 'Mais Informacoes',
            'celular' => 'Celular',
            'telefone' => 'Telefone',
            'email' => 'Email',
            'cpf_cnpj' => 'Cpf Cnpj',
            'cpf' => 'Cpf',
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
            'iptu' => 'Iptu',
            'condominio' => 'Condominio',
            'foto_rg' => 'Frente do Documento',
            'foto_cpf' => 'Verso do Documento',
            'cnj_nome' => 'Cônjuge: Nome',
            'cnj_email' => 'Cônjuge: Email',
            'cnj_cpf' => 'Cônjuge: Cpf',
            'cnj_documento_numero' => 'Cônjuge: Documento Numero',
            'cnj_nacionalidade' => 'Cônjuge: Nacionalidade',
            'cnj_data_nascimento' => 'Cônjuge: Data Nascimento',
            'cnj_telefone_celular' => 'Cônjuge: Telefone Celular',
            'cnj_profissao' => 'Cônjuge: Profissao',
            'cnj_num_dependentes' => 'Cônjuge: Num Dependentes',
            'cnj_foto_rg' => 'Cônjuge: Frente do Documento',
            'cnj_foto_cpf' => 'Cônjuge: Verso do Documento',
        ];
    }
}
