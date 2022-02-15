<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topicoupdates".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $topico_id
 * @property string $datetime
 * @property string $antigo_campo
 * @property string $antigo
 *
 * @property CyberTopico $topico
 * @property Usuario $usuario
 */
class Topicoupdates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topicoupdates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'topico_id', 'datetime'], 'required'],
            [['usuario_id', 'topico_id'], 'integer'],
            [['datetime'], 'safe'],
            [['antigo'], 'string'],
            [['antigo_campo'], 'string', 'max' => 10],
            [['topico_id'], 'exist', 'skipOnError' => true, 'targetClass' => CyberTopico::className(), 'targetAttribute' => ['topico_id' => 'idtopico']],
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
            'usuario_id' => 'Usuario ID',
            'topico_id' => 'Topico ID',
            'datetime' => 'Datetime',
            'antigo_campo' => 'Antigo Campo',
            'antigo' => 'Antigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopico()
    {
        return $this->hasOne(CyberTopico::className(), ['idtopico' => 'topico_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
