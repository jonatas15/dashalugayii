<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuariopermutas".
 *
 * @property integer $permuta
 * @property integer $usuario
 * @property string $observacoes
 *
 * @property ImovelPermuta $permuta0
 * @property Usuario $usuario0
 */
class Usuariopermutas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuariopermutas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permuta', 'usuario'], 'required'],
            [['permuta', 'usuario'], 'integer'],
            [['observacoes'], 'string'],
            [['permuta'], 'exist', 'skipOnError' => true, 'targetClass' => ImovelPermuta::className(), 'targetAttribute' => ['permuta' => 'idimovel_permuta']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'permuta' => 'Permuta',
            'usuario' => 'Usuario',
            'observacoes' => '	',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermuta0()
    {
        return $this->hasOne(ImovelPermuta::className(), ['idimovel_permuta' => 'permuta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario']);
    }
}
