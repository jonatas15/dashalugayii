<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensagem".
 *
 * @property int $id
 * @property string $texto
 * @property string $data
 * @property string $ip
 * @property int|null $slo_pretendente_id
 * @property int|null $usuario_id
 * @property string|null $imagem
 * @property int|null $proposta_id
 *
 * @property SloPretendente $sloPretendente
 * @property Usuario $usuario
 */
class Mensagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['texto', 'data', 'ip'], 'required'],
            [['texto'], 'string'],
            [['data'], 'safe'],
            [['slo_pretendente_id', 'usuario_id', 'proposta_id'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['imagem'], 'string', 'max' => 100],
            [['slo_pretendente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloPretendente::className(), 'targetAttribute' => ['slo_pretendente_id' => 'id']],
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
            'texto' => 'Texto',
            'data' => 'Data',
            'ip' => 'Ip',
            'slo_pretendente_id' => 'Slo Pretendente ID',
            'usuario_id' => 'Usuario ID',
            'imagem' => 'Imagem',
            'proposta_id' => 'Proposta ID',
        ];
    }

    /**
     * Gets query for [[SloPretendente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSloPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'slo_pretendente_id']);
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
    // Para a API
    public function fields() {
        return [
            'id',
            'proposta_id',
            'texto',
            'author' => function(Mensagem $model) {
                return($model->usuario_id ? 'user1' : 'me');
            }
        ];
    }
}
