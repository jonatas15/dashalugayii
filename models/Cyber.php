<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cyber".
 *
 * @property integer $idcyber
 * @property integer $usuario_id
 * @property string $nome
 * @property string $descricao
 * @property string $cor
 * @property string $palavraschaves
 * @property string $cybercol
 * @property string $datetime
 *
 * @property Usuario $usuario
 * @property CyberComentario[] $cyberComentarios
 * @property CyberMembros[] $cyberMembros
 * @property Usuario[] $usuarios
 * @property CyberTopico[] $cyberTopicos
 */
class Cyber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $buscatudo;

    public static function tableName()
    {
        return 'cyber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'nome'], 'required'],
            [['usuario_id'], 'integer'],
            [['descricao'], 'string'],
            [['datetime'], 'safe'],
            [['nome', 'cybercol'], 'string', 'max' => 45],
            [['cor'], 'string', 'max' => 7],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcyber' => 'Id',
            'usuario_id' => 'Autor',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'cor' => 'Cor',
            'palavraschaves' => 'Palavras-Chave',
            'cybercol' => 'Nível de usuários',
            'datetime' => 'Registro em',
        ];
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
    public function getCyberComentarios()
    {
        return $this->hasMany(CyberComentario::className(), ['cyber_idcyber' => 'idcyber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberMembros()
    {
        return $this->hasMany(CyberMembros::className(), ['cyber_idcyber' => 'idcyber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'usuario_id'])->viaTable('cyber_membros', ['cyber_idcyber' => 'idcyber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyberTopicos()
    {
        return $this->hasMany(CyberTopico::className(), ['cyber_idcyber' => 'idcyber']);
    }
}
