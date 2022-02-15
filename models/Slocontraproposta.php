<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_contraproposta".
 *
 * @property integer $id
 * @property integer $pretendente_id
 * @property string $valor_proposto
 * @property string $observacoes
 *
 * @property SloPretendente $pretendente
 */
class Slocontraproposta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_contraproposta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pretendente_id', 'valor_proposto'], 'required'],
            [['pretendente_id'], 'integer'],
            [['valor_proposto'], 'number'],
            [['observacoes'], 'string'],
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
            'valor_proposto' => 'Valor Proposto',
            'observacoes' => 'Observacoes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'pretendente_id']);
    }
}
