<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imoveisexternos".
 *
 * @property integer $id
 * @property integer $imobiliarias_id
 * @property string $url_imovel
 * @property string $url_imagem 
 * @property string $codigo
 * @property string $contrato
 * @property string $tipo
 * @property string $valor_venda
 * @property string $valor_locacao
 * @property string $endereco_estado
 * @property string $endereco_cidade
 * @property string $endereco_bairro
 * @property string $endereco_logradouro
 * @property integer $dormitorios
 * @property integer $banheiros
 * @property integer $garagens
 * @property integer $elevador
 * @property integer $sacada
 * @property string $area_privativa
 * @property string $area_total
 * @property string $comodidades
 * @property string $condominio
 * @property integer $financiavel
 * @property integer $negociavel
 * @property integer $aceita_permuta
 * @property string $observacoes
 * @property string $data_cadastro
 * @property string $data_alteracao
 *
 * @property Imobiliarias $imobiliarias
 */
class Imoveisexternos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $bairros = [
        "Agroindustrial"=>"Agroindustrial",
        "Arroio Grande"=>"Arroio Grande",
        "Boi Morto"=>"Boi Morto",
        "Boca do Monte"=>"Boca do Monte",
        "Bonfim"=>"Bonfim",
        "Camobi"=>"Camobi",
        "Campestre do Menino Deus"=>"Campestre do Menino Deus",
        "Caramelo"=>"Caramelo",
        "Carolina"=>"Carolina",
        "Caturrita"=>"Caturrita",
        "Cauduro"=>"Cauduro",
        "Centro"=>"Centro",
        "Cerrito"=>"Cerrito",
        "Chácara das Flores"=>"Chácara das Flores",
        "Cohab F Ferrari"=>"Cohab F Ferrari",
        "Cohab Passo Ferreira"=>"Cohab Passo Ferreira",
        "Cohab Santa Marta"=>"Cohab Santa Marta",
        "Cohab Tancredo Neves"=>"Cohab Tancredo Neves",
        "Diácono João Luiz Pozzobon"=>"Diácono João Luiz Pozzobon",
        "Distrito Industrial"=>"Distrito Industrial",
        "Divina Providência"=>"Divina Providência",
        "Dom Antônio Reis"=>"Dom Antônio Reis",
        "Duque de Caxias"=>"Duque de Caxias",
        "Faixa Soo Pedro"=>"Faixa Soo Pedro",
        "Formosa"=>"Formosa",
        "Industrial"=>"Industrial",
        "Itararé"=>"Itararé",
        "Itararu"=>"Itararu",
        "Juscelino Kubitschek"=>"Juscelino Kubitschek",
        "João Luiz Pozzobon"=>"João Luiz Pozzobon",
        "Jardim Berleze"=>"Jardim Berleze",
        "Km 3"=>"Km 3",
        "Lorenzi"=>"Lorenzi",
        "Maringá"=>"Maringá",
        "Medianeira"=>"Medianeira",
        "Menino Jesus"=>"Menino Jesus",
        "Noal"=>"Noal",
        "Nonoai"=>"Nonoai",
        "Nossa Senhora das Dores"=>"Nossa Senhora das Dores",
        "Nossa Senhora de Fátima"=>"Nossa Senhora de Fátima",
        "Nossa Senhora de Lourdes"=>"Nossa Senhora de Lourdes",
        "Nossa Senhora do Perpétuo Socorro"=>"Nossa Senhora do Perpétuo Socorro",
        "Nossa Senhora do Rosário"=>"Nossa Senhora do Rosário",
        "Nossa Senhora Dores"=>"Nossa Senhora Dores",
        "Nossa Senhora Medianeira"=>"Nossa Senhora Medianeira",
        "Nova Santa Marta"=>"Nova Santa Marta",
        "Novo Horizonte"=>"Novo Horizonte",
        "Padre de Platano"=>"Padre de Platano",
        "Passo D'areia"=>"Passo D'areia",
        "Passo das Tropas"=>"Passo das Tropas",
        "Patronato"=>"Patronato",
        "Pé de Plátano"=>"Pé de Plátano",
        "Pinheiro Machado"=>"Pinheiro Machado",
        "Presidente João Goulart"=>"Presidente João Goulart",
        "Renascença"=>"Renascença",
        "Retiro Padres"=>"Retiro Padres",
        "Ruralcel"=>"Ruralcel",
        "Salgado Filho"=>"Salgado Filho",
        "São João"=>"São João",
        "São José"=>"São José",
        "Subúrbios"=>"Subúrbios",
        "Switch"=>"Switch",
        "Tancredo Neves"=>"Tancredo Neves",
        "Tomazetti"=>"Tomazetti",
        "Uglione"=>"Uglione",
        "Urlandia"=>"Urlandia",
        "Vila Arco-íris"=>"Vila Arco-íris",
        "Vila Bilibio"=>"Vila Bilibio",
        "Vila Fighera"=>"Vila Fighera",
        "Vila Formosa"=>"Vila Formosa",
        "Zona Rural"=>"Zona Rural",
        "Área Rural"=>"Área Rural",
    ];
    public $tipos = [
        'Casa'=>'Casa',
        'Sobrado'=>'Sobrado',
        'Apartamento'=>'Apartamento',
        'Kitnet'=>'Kitnet',
        'Cobertura'=>'Cobertura',
        'Duplex'=>'Duplex',
        'Triplex'=>'Triplex',
        'Loft'=>'Loft',
        'Sala'=>'Sala',
        'Loja'=>'Loja',
        'Pavilhão'=>'Pavilhão',
        'Prédio'=>'Prédio',
        'Casa'=>'Casa',
        'Terreno'=>'Terreno',
        'Chácara'=>'Chácara',
        'Campo'=>'Campo',
        'Fazenda'=>'Fazenda',
        'Sítio'=>'Sítio',
    ];
    public $arr_dormitorios = [];

    public $valoresdevenda;
    public $valoresdelocacao;

    public static function tableName()
    {
        return 'imoveisexternos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imobiliarias_id', 'codigo', 'contrato', 'tipo'], 'required'],
            [['imobiliarias_id', 'dormitorios', 'banheiros', 'garagens', 'elevador', 'sacada', 'financiavel', 'negociavel', 'aceita_permuta'], 'integer'],
            [['valor_venda', 'valor_locacao', 'area_privativa', 'area_total'], 'number'],
            [['comodidades', 'observacoes'], 'string'],
            [['data_cadastro', 'data_alteracao'], 'safe'],
            [['url_imovel', 'url_imagem', 'endereco_logradouro'], 'string', 'max' => 255],
            [['codigo'], 'string', 'max' => 15],
            [['contrato'], 'string', 'max' => 20],
            [['tipo', 'endereco_cidade'], 'string', 'max' => 45],
            [['endereco_estado'], 'string', 'max' => 25],
            [['endereco_bairro'], 'string', 'max' => 200],
            [['condominio'], 'string', 'max' => 245],
            [['imobiliarias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imobiliarias::className(), 'targetAttribute' => ['imobiliarias_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imobiliarias_id' => 'Imobiliária',
            'url_imovel' => 'Url Imovel',
            'url_imagem' => 'Imagem Destacada',
            'codigo' => 'Código',
            'contrato' => 'Contrato',
            'tipo' => 'Tipo',
            'valor_venda' => 'Investimento',
            'valor_locacao' => 'Valor de Locação',
            'endereco_estado' => 'Estado',
            'endereco_cidade' => 'Cidade',
            'endereco_bairro' => 'Bairro',
            'endereco_logradouro' => 'Logradouro',
            'dormitorios' => 'Dorm.',
            'banheiros' => 'Banheiros',
            'garagens' => 'Vagas',
            'elevador' => 'Elevador',
            'sacada' => 'Sacada',
            'area_privativa' => 'Área Útil',
            'area_total' => 'Área Total',
            'comodidades' => 'Comodidades',
            'condominio' => 'Condomínio',
            'financiavel' => 'Financiável',
            'negociavel' => 'Negociável',
            'aceita_permuta' => 'Aceita Permuta',
            'observacoes' => 'Observações',
            'data_cadastro' => 'Data de Cadastro',
            'data_alteracao' => 'Data de Alteração',
            'valoresdevenda' => 'Intervalo de Valores de Venda',
            'valoresdelocacao' => 'Intervalo de Valores de Locação',
            'arr_dormitorios' => 'Dormitórios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImobiliarias()
    {
        return $this->hasOne(Imobiliarias::className(), ['id' => 'imobiliarias_id']);
    }
}
