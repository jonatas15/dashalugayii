<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sa_alerta".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descricao
 * @property string $envio
 * @property integer $usuario_id
 * @property integer $sa_pendencia_id
 * @property string $data_criacao
 * @property string $data_inicio
 * @property string $data_limite
 *
 * @property SaPendencia $saPendencia
 * @property Usuario $usuario
 * @property SaAlertausuarios[] $saAlertausuarios
 * @property Usuario[] $usuarios
 * @property SloPretendente[] $slopretendente
 */
class SaAlerta extends \yii\db\ActiveRecord
{
    public $alertaopovo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sa_alerta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'usuario_id'], 'required'],
            [['descricao','categoria'], 'string'],
            [['usuario_id', 'sa_pendencia_id', 'pretendente'], 'integer'],
            [['data_criacao', 'data_inicio', 'data_limite'], 'safe'],
            [['titulo', 'envio'], 'string', 'max' => 255],
            // [['sa_pendencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaPendencia::className(), 'targetAttribute' => ['sa_pendencia_id' => 'id']],
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
            'envio' => 'Envio',
            'usuario_id' => 'Usuario ID',
            'sa_pendencia_id' => 'Sa Pendencia ID',
            'data_criacao' => 'Data Criacao',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlopretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'pretendente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaAlertausuarios()
    {
        return $this->hasMany(SaAlertausuarios::className(), ['sa_alerta_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'usuario_id'])->viaTable('sa_alertausuarios', ['sa_alerta_id' => 'id']);
    }
}
