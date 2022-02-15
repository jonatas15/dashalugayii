<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visita".
 *
 * @property integer $idvisita
 * @property integer $usuario_id
 * @property string $data_registro
 * @property string $data_visita
 * @property string $hora_visita
 * @property integer $id_corretor
 * @property string $codigo_imovel
 * @property string $nome_cliente
 * @property string $imobiliaria_parceria
 * @property integer $convertido
 * @property string $observacoes
 * @property string $contrato
 *
 * @property Corretor $idCorretor
 * @property Usuario $usuario
 */
class Visita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $o_corretor;
    public $o_corretor_1;
    public $o_corretor_2;
    public $mes;
    // public $ano_recebido = filter_input(INPUT_GET, 'ano', FILTER_SANITIZE_STRING);
    public $ano;

    public static function tableName()
    {
        return 'visita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'required'],
            [['usuario_id', 'id_corretor', 'convertido'], 'integer'],
            [['data_registro', 'data_visita', 'hora_visita','mes','ano'], 'safe'],
            [['observacoes','o_corretor','o_corretor_1','o_corretor_2','contrato'], 'string'],
            [['codigo_imovel'], 'string', 'max' => 45],
            [['nome_cliente', 'imobiliaria_parceria'], 'string', 'max' => 245],
            [['id_corretor'], 'exist', 'skipOnError' => true, 'targetClass' => Corretor::className(), 'targetAttribute' => ['id_corretor' => 'idcorretor']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idvisita' => 'Id',
            'usuario_id' => 'Usuário',
            'data_registro' => 'Data do Registro',
            'data_visita' => 'Data da Visita',
            'hora_visita' => 'Hora da Visita',
            'id_corretor' => 'Corretor',
            'codigo_imovel' => 'Cód. Imóvel',
            'nome_cliente' => 'Cliente',
            'imobiliaria_parceria' => 'Imobiliária Parceria',
            'convertido' => 'Convertido',
            'observacoes' => 'Observações',
            'o_corretor' => 'Corretor',
            'o_corretor_1' => 'Corretor',
            'o_corretor_2' => 'Corretor',
            'mes' => 'Mês',
            'contrato' => 'Contrato'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCorretor()
    {
        return $this->hasOne(Corretor::className(), ['idcorretor' => 'id_corretor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
