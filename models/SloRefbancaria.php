<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_refbancaria".
 *
 * @property integer $id
 * @property integer $slo_pretendente_id
 * @property string $nome_banco
 * @property string $agencia
 * @property string $conta_corrente
 * @property string $cliente_desde
 * @property string $gerente
 * @property string $telefone
 *
 * @property SloPretendente $sloPretendente
 */
class SloRefbancaria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_refbancaria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slo_pretendente_id'], 'required'],
            [['slo_pretendente_id'], 'integer'],
            [['cliente_desde'], 'safe'],
            [['nome_banco', 'conta_corrente'], 'string', 'max' => 25],
            [['agencia'], 'string', 'max' => 5],
            [['gerente'], 'string', 'max' => 145],
            [['telefone'], 'string', 'max' => 45],
            [['slo_pretendente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloPretendente::className(), 'targetAttribute' => ['slo_pretendente_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slo_pretendente_id' => 'Slo Pretendente ID',
            'nome_banco' => 'Nome do Banco:',
            'agencia' => 'Agência:',
            'conta_corrente' => 'Conta Corrente:',
            'cliente_desde' => 'Cliente desde:',
            'gerente' => 'Nome do Gerente:',
            'telefone' => 'Telefone do Gerente:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'slo_pretendente_id']);
    }
}
