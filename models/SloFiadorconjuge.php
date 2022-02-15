<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_fiadorconjuge".
 *
 * @property integer $id
 * @property integer $fiador_id
 * @property string $tipo_documento
 * @property string $numero
 * @property string $orgao_expedidor
 * @property string $data_expedicao
 *
 * @property SloFiador $fiador
 * @property SloInfospessoais[] $sloInfospessoais
 * @property SloInfosprofissionais[] $sloInfosprofissionais
 */
class SloFiadorconjuge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_fiadorconjuge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fiador_id'], 'required'],
            [['fiador_id'], 'integer'],
            [['tipo_documento'], 'string'],
            [['data_expedicao'], 'safe'],
            [['numero'], 'string', 'max' => 20],
            [['orgao_expedidor'], 'string', 'max' => 45],
            [['fiador_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloFiador::className(), 'targetAttribute' => ['fiador_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fiador_id' => 'Fiador ID',
            'tipo_documento' => 'Tipo Documento',
            'numero' => 'Numero',
            'orgao_expedidor' => 'Orgao Expedidor',
            'data_expedicao' => 'Data Expedicao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiador()
    {
        return $this->hasOne(SloFiador::className(), ['id' => 'fiador_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfospessoais()
    {
        return $this->hasOne(SloInfospessoais::className(), ['slo_fiadorconjuge_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfosprofissionais()
    {
        return $this->hasMany(SloInfosprofissionais::className(), ['slo_fiadorconjuge_id' => 'id']);
    }
}
