<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_cliente".
 *
 * @property integer $id
 * @property string $nome
 * @property string $observacoes
 * @property string $data_nascimento
 * @property string $slo_clientecol
 * @property integer $usuario_id
 * @property integer $slo_pretendente_id
 * @property integer $proposta_aceita
 * @property integer $contra_proposta_aceita
 *
 * @property PropostaPersonas[] $propostaPersonas
 * @property SloAgenda[] $sloAgendas
 * @property SloPretendente $sloPretendente
 * @property Usuario $usuario
 */
class Slocliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'usuario_id'], 'required'],
            [['observacoes'], 'string'],
            [['data_nascimento'], 'safe'],
            [['usuario_id', 'slo_pretendente_id', 'proposta_aceita', 'contra_proposta_aceita'], 'integer'],
            [['nome'], 'string', 'max' => 245],
            [['slo_clientecol'], 'string', 'max' => 45],
            [['slo_pretendente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloPretendente::className(), 'targetAttribute' => ['slo_pretendente_id' => 'id']],
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
            'nome' => 'Nome',
            'observacoes' => 'Observacoes',
            'data_nascimento' => 'Data Nascimento',
            'slo_clientecol' => 'Slo Clientecol',
            'usuario_id' => 'Usuario ID',
            'slo_pretendente_id' => 'Slo Pretendente ID',
            'proposta_aceita' => 'Proposta Aceita',
            'contra_proposta_aceita' => 'Contra Proposta Aceita',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropostaPersonas()
    {
        return $this->hasMany(PropostaPersonas::className(), ['slo_cliente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloAgendas()
    {
        return $this->hasMany(SloAgenda::className(), ['slo_cliente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'slo_pretendente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
