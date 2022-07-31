<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_proposta".
 *
 * @property int $id
 * @property string $tipo Tipo de Proposta
 * @property string|null $prazo_responder Prazo para responder
 * @property string|null $proprietario Proprietário
 * @property string|null $proprietario_info Informações sobre o Proprietário
 * @property string|null $codigo_imovel
 * @property string|null $imovel_info Informações sobre o Imóvel
 * @property string|null $imovel_valores Valores do Imóvel
 * @property string|null $opcoes Opções
 * @property int|null $usuario_id
 * @property string|null $tipo_imovel
 * @property string|null $motivo_locacao
 * @property string|null $nome
 * @property string|null $endereco
 * @property string|null $complemento
 * @property string|null $bairro
 * @property string|null $cidade
 * @property string|null $estado
 * @property string|null $cep
 * @property int|null $dormitorios
 * @property int|null $aluguel
 * @property int|null $iptu
 * @property int|null $condominio
 * @property int|null $agua
 * @property int|null $luz
 * @property int|null $gas_encanado
 * @property int|null $total
 * @property int|null $numero
 * @property string|null $atvc_empresa
 * @property string|null $atvc_cnpj
 * @property string|null $atvc_nome_fantasia
 * @property string|null $atvc_atividade
 * @property string|null $atvc_data_constituicao
 * @property string|null $atvc_contato
 * @property string|null $atvc_telefone
 * @property string $data_inicio
 * @property string|null $id_slogica
 * @property int|null $etapa_andamento
 * @property string|null $codigo
 * @property string|null $data_nascimento
 * @property string|null $cpf
 * @property string|null $telefone
 * @property string|null $email
 * @property string|null $documento_tipo
 * @property string|null $documento_numero
 * @property string|null $documento_orgao_emissor
 * @property string|null $documento_data_emissao
 * @property string|null $nacionalidade
 * @property string|null $telefone_residencial
 * @property string|null $telefone_celular
 * @property string|null $profissao
 * @property string|null $vinculo_empregaticio
 * @property string|null $data_admissao
 * @property string|null $renda
 * @property string|null $naoLocalizado
 * @property string|null $estado_civil
 * @property string|null $condicao_do_imovel
 * @property string|null $conj_nome
 * @property string|null $conj_email
 * @property string|null $conj_cpf
 * @property string|null $conj_documento_tipo
 * @property string|null $conj_documento_numero
 * @property string|null $conj_nacionalidade
 * @property string|null $conj_data_nascimento
 * @property string|null $conj_telefone_celular
 * @property string|null $conj_profissao
 * @property string|null $conj_renda
 * @property int|null $conj_num_dependentes
 * @property string|null $conj_frente
 * @property string|null $conj_verso
 * @property string|null $frente
 * @property string|null $verso
 * @property string|null $proponentes
 *
 * @property Historicodedisparos[] $historicodedisparos
 * @property Usuario $usuario
 */
class SloProposta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

     /**
     * @var file1 file attribute
     */
    public $file1;
    public $file2;
    public $file3;
    public $imageFiles;
    public $ativo = false;
    public $imoveis_jet;

    public static function tableName()
    {
        return 'slo_proposta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo', 'data_inicio'], 'required'],
            [['tipo', 'proprietario_info', 'imovel_info', 'opcoes', 'motivo_locacao', 'conj_frente', 'conj_verso', 'frente', 'verso', 'proponentes', 'corresponsavel', 'sexo'], 'string'],
            [['usuario_id', 'dormitorios', 'aluguel', 'iptu', 'condominio', 'agua', 'luz', 'gas_encanado', 'total', 'numero', 'etapa_andamento', 'conj_num_dependentes', 'superlogica_cliente', 'superlogica_imovel', 'apibotsubs'], 'integer'],
            [['data_inicio', 'data_nascimento', 'documento_data_emissao', 'data_admissao', 'conj_data_nascimento'], 'safe'],
            [['prazo_responder', 'proprietario', 'atvc_data_constituicao', 'id_slogica'], 'string', 'max' => 45],
            [['codigo_imovel'], 'string', 'max' => 15],
            [['imovel_valores', 'nome', 'email', 'naoLocalizado', 'condicao_do_imovel', 'conj_nome', 'conj_email', 'conj_profissao'], 'string', 'max' => 245],
            [['tipo_imovel', 'endereco', 'bairro', 'cidade', 'estado', 'atvc_contato'], 'string', 'max' => 255],
            [['complemento', 'atvc_telefone', 'cnpj'], 'string', 'max' => 25],
            [['cep', 'documento_orgao_emissor'], 'string', 'max' => 10],
            [['atvc_empresa', 'codigo', 'renda', 'conj_renda'], 'string', 'max' => 100],
            [['atvc_cnpj', 'documento_numero', 'estado_civil', 'conj_documento_numero'], 'string', 'max' => 20],
            [['atvc_nome_fantasia'], 'string', 'max' => 150],
            [['atvc_atividade', 'profissao'], 'string', 'max' => 200],
            [['cpf', 'telefone', 'telefone_residencial', 'telefone_celular', 'conj_cpf', 'conj_telefone_celular'], 'string', 'max' => 15],
            [['documento_tipo', 'vinculo_empregaticio', 'conj_documento_tipo'], 'string', 'max' => 145],
            [['nacionalidade', 'conj_nacionalidade'], 'string', 'max' => 50],
            [['file1','file2'], 'file', 'skipOnEmpty' => !$this->ativo, 'extensions' => 'gif, png, jpg, jpeg, pdf'],
            [['file3'], 'file', 'skipOnEmpty' => true, 'extensions' => 'gif, png, jpg, jpeg, pdf'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'gif, png, jpg, jpeg, pdf', 'maxFiles' => 10],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_slogica' => 'Id - Super Lógica',
            'tipo' => 'Garantia',
            'prazo_responder' => 'Prazo p/ responder',
            'proprietario' => 'Proprietário',
            'proprietario_info' => 'Informações do Proprietário',
            'imovel_info' => 'Informações do Imóvel',
            'codigo_imovel' => 'Código do Imóvel',
            'imovel_valores' => 'Valores do Imóvel',
            'tipo_imovel' => 'Tipo de Imóvel',
            'motivo_locacao' => 'Motivo de Locação',
            'nome' => 'Nome',
            'endereco' => 'Endereço',
            'complemento' => 'Complemento',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'cep' => 'CEP',
            'dormitorios' => 'Dormitórios',
            'aluguel' => 'Aluguel',
            'iptu' => 'IPTU',
            'condominio' => 'Condomínio',
            'agua' => 'Água',
            'luz' => 'Luz',
            'gas_encanado' => 'Gás-Encanado',
            'total' => 'Total',
            'numero' => 'Número',
            'usuario_id' => 'Usuário ID',
            'atvc_empresa' => 'Empresa',
            'atvc_cnpj' => 'CNPJ',
            'atvc_nome_fantasia' => 'Nome Fantasia',
            'atvc_atividade' => 'Atividade',
            'atvc_data_constituicao' => 'Data da Constituição',
            'atvc_contato' => 'Contato',
            'atvc_telefone' => 'Telefone',
            'usuario_id' => 'Autor da proposta',
            'file1' => 'Frente do Documento:',
            'file2' => 'Verso do Documento:',
            'file3' => 'Selfie com o Documento:',
            'imageFiles' => 'Outros Comprovantes (máx. 3):',
            'codigo' => 'Código D4sign (Assinatura do Contrato)',
            'apibotsubs' => 'Código ID BotConversa'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorretores()
    {
        return $this->hasMany(Corretores::className(), ['slo_proposta_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorretorIdcorretors()
    {
        return $this->hasMany(Corretor::className(), ['idcorretor' => 'corretor_idcorretor'])->viaTable('corretores', ['slo_proposta_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloPretendentes()
    {
        return $this->hasMany(SloPretendente::className(), ['proposta_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProponente()
    {
        return $this->hasOne(SloPretendente::className(), [
            'proposta_id' => 'id',
        ])->where(['proponente_principal' => 1]);
    }

    public function getSloAgendas()
    {
        return $this->hasMany(SloAgenda::className(), ['slo_proposta_id' => 'id']);
    }

    public function upload($folder)
    {
        if ($this->validate()) {
            if(!empty($this->file1))
                $this->file1->saveAs('uploads/propostasdocs/'.$folder.'_frentdoc_' . $this->file1->baseName . '.' . $this->file1->extension);
            if(!empty($this->file2))
                $this->file2->saveAs('uploads/propostasdocs/'.$folder.'_versodoc_' . $this->file2->baseName . '.' . $this->file2->extension);
            if(!empty($this->file3))
                $this->file3->saveAs('uploads/propostasdocs/'.$folder.'_selfidoc_' . $this->file3->baseName . '.' . $this->file3->extension);
            if(!empty($this->imageFiles)){
                foreach ($this->imageFiles as $file) {
                    $file->saveAs('uploads/propostasdocs/'.$folder.'_outroscomprovantes_' . $file->baseName . '.' . $file->extension);
                }
            }
            return true;
        } else {
            return false;
        }
    }
    //Mais tabelas
    public function getMaisarquivos()
    {
        return $this->hasOne(SloExfiles::className(), ['proposta_id' => 'id'])->orderBy([
            'id' => SORT_DESC,
        ]);
    }
    //Rest API
    public function fields() {
        return [
            'id',
            'tipo',
            'opcoes',
            'nome',
            'email',
            'etapa_andamento',
            'motivo_locacao',
            'codigo',
            'codigo_imovel'
        ];
    }
}
