<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chtopico".
 *
 * @property integer $id
 * @property string $conteudo
 * @property string $etapa
 * @property integer $checked
 * @property integer $checklist_id
 * @property integer $topico_pai
 * @property integer $alerta_id
 *
 * @property Checklist $checklist
 * @property Chtopico $topicoPai
 * @property Chtopico[] $chtopicos
 */
class Chtopico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chtopico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conteudo', 'checklist_id', 'etapa'], 'required'],
            [['conteudo','etapa'], 'string'],
            [['checked', 'checklist_id', 'topico_pai','alerta_id'], 'integer'],
            [['checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Checklist::className(), 'targetAttribute' => ['checklist_id' => 'id']],
            [['topico_pai'], 'exist', 'skipOnError' => true, 'targetClass' => Chtopico::className(), 'targetAttribute' => ['topico_pai' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conteudo' => 'Conteudo',
            'checked' => 'Checked',
            'checklist_id' => 'Checklist ID',
            'topico_pai' => 'Topico Pai',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklist()
    {
        return $this->hasOne(Checklist::className(), ['id' => 'checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicoPai()
    {
        return $this->hasOne(Chtopico::className(), ['id' => 'topico_pai']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChtopicos()
    {
        return $this->hasMany(Chtopico::className(), ['topico_pai' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlerta()
    {
        return $this->hasOne(SaAlerta::className(), ['id' => 'alerta_id']);
    }
}
