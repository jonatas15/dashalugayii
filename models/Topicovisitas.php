<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topicovisitas".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $topico_id
 * @property string $datetime
 * @property string $tempo
 *
 * @property CyberTopico $topico
 * @property Usuario $usuario
 */
class Topicovisitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topicovisitas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'topico_id'], 'required'],
            [['usuario_id', 'topico_id'], 'integer'],
            [['datetime', 'tempo'], 'safe'],
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
            'tempo' => 'Tempo',
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
