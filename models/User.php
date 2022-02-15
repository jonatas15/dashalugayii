<?php

namespace app\models;
use app\models\Usuario as DBUser;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
// class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $idusuario;
    public $username;
    public $password;
    public $nome;
    public $email;
    public $foto;
    public $tipo;
    public $mais_informacoes;
    public $empresa;
    public $cargo;
    public $projeto_idprojeto;
    public $nivel_de_acesso_idnivel;
    public $data_cadastro;
    public $data_alteracao;
    public $authKey;
    public $accessToken;

    // private static $users = [
    //     '100' => [
    //         'id' => '100',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //     ],
    //     '101' => [
    //         'id' => '101',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //     ],
    // ];

    //Necessario para extender active record
    // public static function tableName()
    // {
    //     return 'usuario';
    // }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = DBUser::find()->where(['id'=>$id])->one();
        if ($user) {
            return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
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
