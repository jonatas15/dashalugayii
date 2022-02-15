<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sa_pendenciausuarios".
 *
 * @property integer $sa_pendencia_id
 * @property integer $usuario_id
 * @property string $prazo
 * @property string $entregue
 * @property string $tempo
 *
 * @property SaPendencia $saPendencia
 * @property Usuario $usuario
 */
class SaPendenciausuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sa_pendenciausuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sa_pendencia_id', 'usuario_id'], 'required'],
            [['sa_pendencia_id', 'usuario_id'], 'integer'],
            [['prazo', 'entregue', 'tempo'], 'safe'],
            [['sa_pendencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaPendencia::className(), 'targetAttribute' => ['sa_pendencia_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sa_pendencia_id' => 'Sa Pendencia ID',
            'usuario_id' => 'Usuario ID',
            'prazo' => 'Prazo',
            'entregue' => 'Entregue',
            'tempo' => 'Tempo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaPendencia()
    {
        return $this->hasOne(SaPendencia::className(), ['id' => 'sa_pendencia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
