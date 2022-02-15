<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_pretendente".
 *
 * @property integer $id
 * @property integer $proposta_id
 * @property string $morar_com_quem
 * @property integer $animais_extimacao
 * @property integer $user_cliente
 * @property string $apresentacao
 *
 * @property SloConjuje[] $sloConjujes
 * @property SloContratodocumento[] $sloContratodocumentos
 * @property SloInfospessoais[] $sloInfospessoais
 * @property SloInfosprofissionais[] $sloInfosprofissionais
 * @property SloMoratual[] $sloMoratuals
 * @property SloOcupante[] $sloOcupantes
 * @property SloProposta $proposta
 * @property SloRefbancaria[] $sloRefbancarias
 */
class SloPretendente extends \yii\db\ActiveRecord
{
    public $infopessoal;
    public $infoprofissional;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_pretendente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proposta_id'], 'required'],
            [['proposta_id', 'animais_extimacao', 'pret_user'], 'integer'],
            [['morar_com_quem', 'apresentacao', 'data', 'tipo_fiador'], 'string'],
            [['proposta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloProposta::className(), 'targetAttribute' => ['proposta_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proposta_id' => 'Proposta',
            'morar_com_quem' => 'Vai morar com quem',
            'animais_extimacao' => 'Tem animais de Extimação?',
            'apresentacao' => 'Apresentação (opção)',
            'infopessoal' => 'Nome',
            'infoprofissional' => 'Empresa em que trabalha',
            'data' => 'Data do Registro'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloConjujes()
    {
        return $this->hasMany(SloConjuje::className(), ['pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloContratodocumentos()
    {
        return $this->hasOne(SloContratodocumento::className(), ['slo_pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfospessoais()
    {
        return $this->hasOne(SloInfospessoais::className(), ['pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfosprofissionais()
    {
        return $this->hasOne(SloInfosprofissionais::className(), ['pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloMoratuals()
    {
        return $this->hasOne(SloMoratual::className(), ['slo_pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloOcupantes()
    {
        return $this->hasMany(SloOcupante::className(), ['slo_pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProposta()
    {
        return $this->hasOne(SloProposta::className(), ['id' => 'proposta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloRefbancarias()
    {
        return $this->hasOne(SloRefbancaria::className(), ['slo_pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloFiadors()
    {
        return $this->hasMany(SloFiador::className(), ['pretendente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists()
    {
        return $this->hasMany(Checklist::className(), ['pretendente_id' => 'id']);
    }
    //Mais tabelas
    public function getMaisproponentes()
    {
        return $this->hasMany(SloAdproponente::className(), ['pretendente_id' => 'id']);
    }
    //Mais tabelas
    public function getMaisarquivos()
    {
        return $this->hasOne(SloExfiles::className(), ['pretendente_id' => 'id']);
    }
}
