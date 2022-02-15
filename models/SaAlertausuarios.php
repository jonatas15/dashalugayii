<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sa_alertausuarios".
 *
 * @property integer $sa_alerta_id
 * @property integer $usuario_id
 * @property string $disparo
 *
 * @property SaAlerta $saAlerta
 * @property Usuario $usuario
 */
class SaAlertausuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sa_alertausuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sa_alerta_id', 'usuario_id'], 'required'],
            [['sa_alerta_id', 'usuario_id'], 'integer'],
            [['disparo'], 'safe'],
            [['sa_alerta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaAlerta::className(), 'targetAttribute' => ['sa_alerta_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sa_alerta_id' => 'Sa Alerta ID',
            'usuario_id' => 'Usuario ID',
            'disparo' => 'Disparo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaAlerta()
    {
        return $this->hasOne(SaAlerta::className(), ['id' => 'sa_alerta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
