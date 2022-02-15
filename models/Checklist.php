<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $subtitulo
 * @property integer $pretendente_id
 *
 * @property SloPretendente $pretendente
 * @property Chtopico[] $chtopicos
 */
class Checklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checklist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'pretendente_id'], 'required'],
            [['pretendente_id'], 'integer'],
            [['titulo'], 'string', 'max' => 100],
            [['subtitulo'], 'string', 'max' => 145],
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
            'titulo' => 'Titulo',
            'subtitulo' => 'Subtitulo',
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
    public function getChtopicos()
    {
        return $this->hasMany(Chtopico::className(), ['checklist_id' => 'id']);
    }
}
