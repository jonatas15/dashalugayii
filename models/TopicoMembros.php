<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topico_membros".
 *
 * @property integer $topico_idtopico
 * @property integer $usuario_id
 * @property integer $favorito
 * @property integer $ajudou
 * @property integer $nao_ajudou
 *
 * @property CyberTopico $topicoIdtopico
 * @property Usuario $usuario
 */
class TopicoMembros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topico_membros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topico_idtopico', 'usuario_id'], 'required'],
            [['topico_idtopico', 'usuario_id', 'favorito', 'ajudou', 'nao_ajudou'], 'integer'],
            [['topico_idtopico'], 'exist', 'skipOnError' => true, 'targetClass' => CyberTopico::className(), 'targetAttribute' => ['topico_idtopico' => 'idtopico']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'topico_idtopico' => 'Topico Idtopico',
            'usuario_id' => 'Usuario ID',
            'favorito' => 'Favorito',
            'ajudou' => 'Ajudou',
            'nao_ajudou' => 'Nao Ajudou',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicoIdtopico()
    {
        return $this->hasOne(CyberTopico::className(), ['idtopico' => 'topico_idtopico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
