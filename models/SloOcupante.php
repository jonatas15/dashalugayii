<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_ocupante".
 *
 * @property integer $id
 * @property integer $slo_pretendente_id
 * @property string $nome
 * @property string $sexo
 * @property string $cpf
 * @property string $tipo_documento
 * @property string $numero_documento
 * @property string $data_expedicao
 * @property string $orgao_expedidor
 * @property string $data_nascimento
 *
 * @property SloPretendente $sloPretendente
 */
class SloOcupante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_ocupante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slo_pretendente_id'], 'required'],
            [['slo_pretendente_id'], 'integer'],
            [['sexo', 'tipo_documento'], 'string'],
            [['data_expedicao', 'data_nascimento'], 'safe'],
            [['nome'], 'string', 'max' => 120],
            [['cpf'], 'string', 'max' => 15],
            [['numero_documento'], 'string', 'max' => 20],
            [['orgao_expedidor'], 'string', 'max' => 45],
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
            'slo_pretendente_id' => 'Pretendente',
            'nome' => 'Nome',
            'sexo' => 'Sexo',
            'cpf' => 'Cpf',
            'tipo_documento' => 'Tipo de Documento',
            'numero_documento' => 'Número do Documento',
            'data_expedicao' => 'Data de Expedição',
            'orgao_expedidor' => 'Órgão Expedidor',
            'data_nascimento' => 'Data de Nascimento',
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
