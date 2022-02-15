<?php

namespace app\models;

use Yii;

use yii\web\UploadedFile;

/**
 * This is the model class for table "cyber_topico".
 *
 * @property integer $idtopico
 * @property integer $cyber_idcyber
 * @property integer $usuario_id
 * @property string $titulo
 * @property string $tipo
 * @property string $descricao
 * @property string $palavraschaves
 * @property string $imagem
 * @property string $documento
 * @property string $datetime
 * @property integer $topico_pai
 *
 * @property CyberComentario[] $cyberComentarios
 * @property CyberTopico $topicoPai
 * @property CyberTopico[] $cyberTopicos
 * @property Cyber $cyberIdcyber
 * @property Usuario $usuario
 * @property TopicoMembros[] $topicoMembros
 * @property Usuario[] $usuarios
 */
class CyberTopico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $imageFile;
    public $buscatudo;

    public static function tableName()
    {
        return 'cyber_topico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cyber_idcyber', 'usuario_id', 'titulo', 'tipo'], 'required'],
            [['cyber_idcyber', 'usuario_id', 'topico_pai'], 'integer'],
            [['tipo', 'descricao'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
            [['datetime'], 'safe'],
            [['titulo'], 'string', 'max' => 45],
            [['imagem', 'documento'], 'string', 'max' => 255],
            [['topico_pai'], 'exist', 'skipOnError' => true, 'targetClass' => CyberTopico::className(), 'targetAttribute' => ['topico_pai' => 'idtopico']],
            [['cyber_idcyber'], 'exist', 'skipOnError' => true, 'targetClass' => Cyber::className(), 'targetAttribute' => ['cyber_idcyber' => 'idcyber']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtopico' => 'Idtopico',
            'cyber_idcyber' => 'Cyber Idcyber',
            'usuario_id' => 'Usuario ID',
            'titulo' => 'Título',
            'tipo' => 'Tipo de tópico',
            'descricao' => 'Descrição',
            'palavraschaves' => 'Palavras-chave',
            'imagem' => 'Imagem',
            'documento' => 'Documento',
            'datetime' => 'Datetime',
            'topico_pai' => 'Topico Pai',
            'imageFile' => 'Upload de Imagem'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberComentarios()
    {
        return $this->hasMany(CyberComentario::className(), ['cyber_topico_idtopico' => 'idtopico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicoPai()
    {
        return $this->hasOne(CyberTopico::className(), ['idtopico' => 'topico_pai']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberTopicos()
    {
        return $this->hasMany(CyberTopico::className(), ['topico_pai' => 'idtopico']);
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicoMembros()
    {
        return $this->hasMany(TopicoMembros::className(), ['topico_idtopico' => 'idtopico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'usuario_id'])->viaTable('topico_membros', ['topico_idtopico' => 'idtopico']);
    }


    //Para o Upload de Arquivos
     public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
