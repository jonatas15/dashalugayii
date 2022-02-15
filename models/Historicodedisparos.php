<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historicodedisparos".
 *
 * @property int $id
 * @property string $data
 * @property string $mensagem
 * @property int $proposta_id
 * @property int $usuario_id
 * @property int|null $etapa
 * @property string|null $modo
 *
 * @property SloProposta $proposta
 * @property Usuario $usuario
 */
class Historicodedisparos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historicodedisparos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'mensagem', 'proposta_id', 'usuario_id'], 'required'],
            [['data'], 'safe'],
            [['mensagem', 'modo'], 'string'],
            [['proposta_id', 'usuario_id', 'etapa'], 'integer'],
            [['proposta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloProposta::className(), 'targetAttribute' => ['proposta_id' => 'id']],
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
            'data' => 'Data',
            'mensagem' => 'Mensagem',
            'proposta_id' => 'Proposta ID',
            'usuario_id' => 'Usuario ID',
            'etapa' => 'Etapa',
            'modo' => 'Modo',
        ];
    }

    /**
     * Gets query for [[Proposta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProposta()
    {
        return $this->hasOne(SloProposta::className(), ['id' => 'proposta_id']);
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
