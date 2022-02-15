<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userhistvisto".
 *
 * @property int $historico_id
 * @property int $usuario_id
 * @property string $data
 * @property int $visto
 *
 * @property Historico $historico
 * @property Usuario $usuario
 */
class Userhistvisto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userhistvisto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['historico_id', 'usuario_id', 'data'], 'required'],
            [['historico_id', 'usuario_id', 'visto'], 'integer'],
            [['data'], 'safe'],
            [['historico_id', 'usuario_id'], 'unique', 'targetAttribute' => ['historico_id', 'usuario_id']],
            [['historico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Historico::className(), 'targetAttribute' => ['historico_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'historico_id' => 'Historico ID',
            'usuario_id' => 'Usuario ID',
            'data' => 'Data',
            'visto' => 'Visto',
        ];
    }

    /**
     * Gets query for [[Historico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistorico()
    {
        return $this->hasOne(Historico::className(), ['id' => 'historico_id']);
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
