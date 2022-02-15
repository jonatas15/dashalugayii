<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "histdispmulti".
 *
 * @property int $id
 * @property int $disparos_id
 * @property int $usuario_id
 * @property string|null $data
 * @property string|null $numeros
 * @property string|null $mensagem
 *
 * @property Disparoswh $disparos
 * @property Usuario $usuario
 */
class Histdispmulti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'histdispmulti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disparos_id', 'usuario_id'], 'required'],
            [['disparos_id', 'usuario_id'], 'integer'],
            [['data'], 'safe'],
            [['numeros', 'mensagem'], 'string'],
            [['disparos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Disparoswh::className(), 'targetAttribute' => ['disparos_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'disparos_id' => 'Disparos ID',
            'usuario_id' => 'Usuario ID',
            'data' => 'Data',
            'numeros' => 'Numeros',
            'mensagem' => 'Mensagem',
        ];
    }

    /**
     * Gets query for [[Disparos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisparos()
    {
        return $this->hasOne(Disparoswh::className(), ['id' => 'disparos_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
