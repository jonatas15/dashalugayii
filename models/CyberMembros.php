<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cyber_membros".
 *
 * @property integer $cyber_idcyber
 * @property integer $usuario_id
 * @property integer $favorito
 *
 * @property Cyber $cyberIdcyber
 * @property Usuario $usuario
 */
class CyberMembros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cyber_membros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cyber_idcyber', 'usuario_id'], 'required'],
            [['cyber_idcyber', 'usuario_id', 'favorito'], 'integer'],
            [['cyber_idcyber'], 'exist', 'skipOnError' => true, 'targetClass' => Cyber::className(), 'targetAttribute' => ['cyber_idcyber' => 'idcyber']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cyber_idcyber' => 'Cyber Idcyber',
            'usuario_id' => 'Usuario ID',
            'favorito' => 'Favorito',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberIdcyber()
    {
        return $this->hasOne(Cyber::className(), ['idcyber' => 'cyber_idcyber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
