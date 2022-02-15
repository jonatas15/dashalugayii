<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disparoswh".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $numeros
 * @property int $usuario_id
 * @property string|null $disparos_feitos
 *
 * @property Usuario $usuario
 */
class Disparoswh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disparoswh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'usuario_id'], 'required'],
            [['disparos_feitos'], 'string'],
            [['usuario_id'], 'integer'],
            [['titulo'], 'string', 'max' => 245],
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
            'titulo' => 'Titulo',
            'numeros' => 'Numeros',
            'usuario_id' => 'Usuario ID',
            'disparos_feitos' => 'Disparos Feitos',
        ];
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
