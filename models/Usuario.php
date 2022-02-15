<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\web\IdentityInterface;
use app\models\User;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $nome
 * @property string $tipo
 * @property string $username
 * @property string $password
 * @property string $mais_informacoes
 * @property string $foto
 * @property Corretor[] $corretors
 *
 * @property BaseCalculosLocacoes[] $baseCalculosLocacoes
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */

    public $arquivoimagem;

    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'tipo', 'username', 'password'], 'required'],
            [['tipo', 'mais_informacoes', 'email'], 'string'],
            [['nome'], 'string', 'max' => 145],
            [['username', 'password'], 'string', 'max' => 45],
            [['foto'], 'string', 'max' => 245],
            [['arquivoimagem'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'username' => 'Login',
            'password' => 'Senha',
            'email' => 'Email',
            'mais_informacoes' => 'Mais Informações',
            'foto' => 'Foto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseCalculosLocacoes()
    {
        return $this->hasMany(BaseCalculosLocacoes::className(), ['usuario_id' => 'id']);
    }
    /*
    * Jonatas: upload de imagens
    */
    public function upload()
    {
        if ($this->validate()) {
            $this->arquivoimagem->saveAs(Yii::$app->basePath.'/web/usuarios/' . $this->arquivoimagem->baseName . '.' . $this->arquivoimagem->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorretors()
    {
        return $this->hasMany(Corretor::className(), ['usuario_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        $user = DBUser::find()->where(['id'=>$id])->one();
        if ($user) {
            return new static($user);
        }
        return null;
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    public static function findByUsername($username)
    {
        $user = DBUser::find()->where(['username'=>$username])->one();
        if ($user) {
            return new static($user);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null; // $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return null; // $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }
}
