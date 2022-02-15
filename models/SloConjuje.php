<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_conjuje".
 *
 * @property integer $id
 * @property integer $pretendente_id
 *
 * @property SloPretendente $pretendente
 * @property SloInfospessoais[] $sloInfospessoais
 * @property SloInfosprofissionais[] $sloInfosprofissionais
 */
class SloConjuje extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_conjuje';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pretendente_id'], 'required'],
            [['pretendente_id'], 'integer'],
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
    public function getSloInfospessoais()
    {
        return $this->hasMany(SloInfospessoais::className(), ['conjuje_id' => 'id']);
    }
    public function getPessoa()
    {
        return $this->hasOne(SloInfospessoais::className(), ['conjuje_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloInfosprofissionais()
    {
        return $this->hasMany(SloInfosprofissionais::className(), ['conjuje_id' => 'id']);
    }
}
