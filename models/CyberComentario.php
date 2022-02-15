<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cyber_comentario".
 *
 * @property integer $idcyber_comentario
 * @property integer $usuario_id
 * @property integer $cyber_topico_idtopico
 * @property integer $cyber_idcyber
 * @property string $comentario
 * @property string $datetime
 * @property string $imagem
 * @property string $documento
 *
 * @property Cyber $cyberIdcyber
 * @property CyberTopico $cyberTopicoIdtopico
 * @property Usuario $usuario
 */
class CyberComentario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cyber_comentario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'cyber_topico_idtopico', 'cyber_idcyber', 'comentario'], 'required'],
            [['usuario_id', 'cyber_topico_idtopico', 'cyber_idcyber'], 'integer'],
            [['comentario'], 'string'],
            [['datetime'], 'safe'],
            [['imagem', 'documento'], 'string', 'max' => 255],
            [['cyber_idcyber'], 'exist', 'skipOnError' => true, 'targetClass' => Cyber::className(), 'targetAttribute' => ['cyber_idcyber' => 'idcyber']],
            [['cyber_topico_idtopico'], 'exist', 'skipOnError' => true, 'targetClass' => CyberTopico::className(), 'targetAttribute' => ['cyber_topico_idtopico' => 'idtopico']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcyber_comentario' => 'Idcyber Comentario',
            'usuario_id' => 'Usuario ID',
            'cyber_topico_idtopico' => 'Cyber Topico Idtopico',
            'cyber_idcyber' => 'Cyber Idcyber',
            'comentario' => 'Comentario',
            'datetime' => 'Datetime',
            'imagem' => 'Imagem',
            'documento' => 'Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberIdcyber()
    {
        return $this->hasOne(Cyber::className(), ['idcyber' => 'cyber_idcyber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberTopicoIdtopico()
    {
        return $this->hasOne(CyberTopico::className(), ['idtopico' => 'cyber_topico_idtopico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
