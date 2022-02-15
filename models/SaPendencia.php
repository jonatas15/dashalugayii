<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sa_pendencia".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descricao
 * @property integer $usuario_id
 *
 * @property SaAlerta[] $saAlertas
 * @property Usuario $usuario
 * @property SaPendenciausuarios[] $saPendenciausuarios
 * @property Usuario[] $usuarios
 */
class SaPendencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sa_pendencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'usuario_id'], 'required'],
            [['descricao'], 'string'],
            [['usuario_id'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
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
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaAlertas()
    {
        return $this->hasMany(SaAlerta::className(), ['sa_pendencia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaPendenciausuarios()
    {
        return $this->hasMany(SaPendenciausuarios::className(), ['sa_pendencia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'usuario_id'])->viaTable('sa_pendenciausuarios', ['sa_pendencia_id' => 'id']);
    }
}
