<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_fiador".
 *
 * @property integer $id
 * @property integer $pretendente_id
 * @property string $tipo_fiador
 * @property string $tipo_documento
 * @property string $numero
 * @property string $orgao_expedidor
 * @property string $data_expedicao
 * @property string $outras_infos
 *
 * @property SloPretendente $pretendente
 * @property SloFiadorconjuge[] $sloFiadorconjuges
 * @property SloInfospessoais $sloInfospessoais
 * @property SloInfosprofissionais[] $sloInfosprofissionais
 */
class SloFiador extends \yii\db\ActiveRecord
{

    # PESSOAIS
    public $nome;
    public $data_nascimento;
    public $cpf;
    public $emancipado;
    public $fone_residencial;
    public $celular;
    public $possui_renda;
    public $vai_morar;
    public $estado_civil;
    public $genero;
    public $nacionalidade;
    public $extrangeiro_temponopais;
    public $numero_dependentes;
    public $nome_pai;
    public $nome_mae;
    public $email;

    # PROFISSIONAIS
    public $empresa;
    public $fone;
    public $data_admissao;
    public $profissao;
    public $vinculo_empregaticio;
    public $salario;
    public $outros_rendimentos;
    public $total_rendimentos;

    # CÔNJUGE DO FIADOR - PESSOAIS
    public $cj_nome;
    public $cj_data_nascimento;
    public $cj_cpf;
    public $cj_emancipado;
    public $cj_fone_residencial;
    public $cj_celular;
    public $cj_possui_renda;
    public $cj_vai_morar;
    public $cj_estado_civil;
    public $cj_genero;
    public $cj_nacionalidade;
    public $cj_extrangeiro_temponopais;
    public $cj_numero_dependentes;
    public $cj_email;
    public $cj_nome_pai;
    public $cj_nome_mae;

    public static function tableName()
    {
        return 'slo_fiador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pretendente_id', 'tipo_fiador'], 'required'],
            [['pretendente_id'], 'integer'],
            [[
              'tipo_fiador', 'tipo_documento', 'outras_infos',
              'nome','data_nascimento','cpf','emancipado','fone_residencial','celular','possui_renda','vai_morar','estado_civil','genero','nacionalidade','extrangeiro_temponopais','numero_dependentes','nome_pai','nome_mae','email',
              'empresa', 'fone', 'data_admissao', 'profissao', 'vinculo_empregaticio', 'salario', 'outros_rendimentos', 'total_rendimentos',
              'cj_nome','cj_data_nascimento','cj_cpf','cj_emancipado','cj_fone_residencial','cj_celular','cj_possui_renda','cj_vai_morar','cj_estado_civil','cj_genero','cj_nacionalidade','cj_extrangeiro_temponopais','cj_numero_dependentes','cj_nome_pai','cj_nome_mae','cj_email',
            ], 'string'],
            [['data_expedicao'], 'safe'],
            [['numero'], 'string', 'max' => 20],
            [['orgao_expedidor'], 'string', 'max' => 45],
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
            'tipo_fiador' => 'Tipo de Fiador',
            'tipo_documento' => 'Tipo de Documento',
            'numero' => 'Número',
            'orgao_expedidor' => 'Órgao Expedidor',
            'data_expedicao' => 'Data de Expedição',
            'outras_infos' => 'Outras Infos',
            'nome' => 'Nome',
            'data_nascimento' => 'Data de Nascimento',
            'cpf' => 'CPF',
            'emancipado' => 'Emancipado',
            'fone_residencial' => 'Telefone Residencial',
            'celular' => 'Celular',
            'possui_renda' => 'Possui Renda',
            'vai_morar' => 'Vai Morar',
            'estado_civil' => 'Estado Civil',
            'genero' => 'Gênero',
            'nacionalidade' => 'Nacionalidade',
            'extrangeiro_temponopais' => 'Se extrangeiro, há quanto tempo no país',
            'numero_dependentes' => 'Número de Dependentes',
            'nome_pai' => 'Nome do Pai',
            'nome_mae' => 'Nome da Mae',
            'email' => 'Email',
            'slo_fiador_id' => 'Slo Fiador ID',
            'slo_fiadorconjuge_id' => 'Slo Fiadorconjuge ID',
            //empresa
            'empresa' => 'Empresa em que Trabalha',
            'fone' => 'Telefone',
            'data_admissao' => 'Data de Admissão',
            'profissao' => 'Profissão',
            'vinculo_empregaticio' => 'Vínculo Empregatício',
            'total_rendimentos' => 'Total dos rendimentos',
            //conjuge
            'cj_nome' => 'Nome',
            'cj_data_nascimento' => 'Data de Nascimento',
            'cj_cpf' => 'CPF',
            'cj_emancipado' => 'Emancipado',
            'cj_fone_residencial' => 'Telefone Residencial',
            'cj_celular' => 'Celular',
            'cj_possui_renda' => 'Possui Renda',
            'cj_vai_morar' => 'Vai Morar',
            'cj_estado_civil' => 'Estado Civil',
            'cj_genero' => 'Gênero',
            'cj_nacionalidade' => 'Nacionalidade',
            'cj_extrangeiro_temponopais' => 'Se extrangeiro, há quanto tempo no país',
            'cj_numero_dependentes' => 'Número de Dependentes',
            'cj_nome_pai' => 'Nome do Pai',
            'cj_nome_mae' => 'Nome da Mae',
            'cj_email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'pretendente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloFiadorconjuges()
    {
        return $this->hasOne(SloFiadorconjuge::className(), ['fiador_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfospessoais()
    {
        return $this->hasOne(SloInfospessoais::className(), ['slo_fiador_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfosprofissionais()
    {
        return $this->hasOne(SloInfosprofissionais::className(), ['slo_fiador_id' => 'id']);
    }
}
