<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_agenda".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $slo_cliente_id
 * @property integer $corretor_idcorretor
 * @property integer $slo_proposta_id
 * @property string $data
 * @property string $turno
 * @property string $hora
 * @property string $imovel
 * @property string $mais_informacoes
 *
 * @property Corretor $corretorIdcorretor
 * @property SloCliente $sloCliente
 * @property Usuario $usuario
 */
class SloAgenda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $data_intervalo;

    public static function tableName()
    {
        return 'slo_agenda';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'corretor_idcorretor', 'data'], 'required'],
            [['usuario_id', 'slo_cliente_id', 'corretor_idcorretor', 'slo_proposta_id'], 'integer'],
            [['data', 'hora', 'data_intervalo'], 'safe'],
            [['imovel'], 'string', 'max' => 245], 
            [['turno', 'mais_informacoes'], 'string'],
            [['corretor_idcorretor'], 'exist', 'skipOnError' => true, 'targetClass' => Corretor::className(), 'targetAttribute' => ['corretor_idcorretor' => 'idcorretor']],
            [['slo_cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloCliente::className(), 'targetAttribute' => ['slo_cliente_id' => 'id']],
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
            'usuario_id' => 'Usuário',
            'slo_cliente_id' => 'Cliente',
            'corretor_idcorretor' => 'Corretor',
            'data' => 'Data',
            'turno' => 'Turno',
            'hora' => 'Hora',
            'imovel' => 'Imóvel',
            'mais_informacoes' => 'Mais Informações',
            'sloCliente.nome' => 'Cliente',
            'corretorIdcorretor.nome' => 'Corretor',
            'slo_proposta_id' => 'Propostas: ',
            'sloProposta.codigo_imovel' => 'Imóvel Proposta',
            'usuario.nome' => 'Cadastrador',
            'sloCliente.nome' => 'Cliente'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorretorIdcorretor()
    {
        return $this->hasOne(Corretor::className(), ['idcorretor' => 'corretor_idcorretor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloCliente()
    {
        return $this->hasOne(SloCliente::className(), ['id' => 'slo_cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloProposta()
    {
        return $this->hasOne(SloProposta::className(), ['id' => 'slo_proposta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
