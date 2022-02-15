<?php

namespace app\models;
use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id
 * @property string|null $setor
 * @property string|null $cargo
 * @property string|null $cpf
 * @property string $nome
 * @property string|null $email
 * @property string|null $proventos
 * @property string|null $fone1
 * @property string|null $fone2
 * @property string|null $clientescol
 * @property int|null $corretor
 *
 * @property Corretor $corretor0
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;
    public $status;
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['corretor', 'status'], 'integer'],
            [['setor', 'cargo', 'proventos'], 'string', 'max' => 245],
            [['cpf'], 'string', 'max' => 14],
            [['nome'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 200],
            [['fone1', 'fone2'], 'string', 'max' => 15],
            [['clientescol'], 'string', 'max' => 45],
            [['corretor'], 'exist', 'skipOnError' => true, 'targetClass' => Corretor::className(), 'targetAttribute' => ['corretor' => 'idcorretor']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx, csv'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setor' => 'Setor',
            'cargo' => 'Cargo',
            'cpf' => 'Cpf',
            'nome' => 'Nome',
            'email' => 'Email',
            'proventos' => 'Proventos',
            'fone1' => 'Fone1',
            'fone2' => 'Fone2',
            'clientescol' => 'Clientescol',
            'corretor' => 'Corretor',
        ];
    }

    /**
     * Gets query for [[Corretor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorretor0()
    {
        return $this->hasOne(Corretor::className(), ['idcorretor' => 'corretor']);
    }

    public function upload()
    {
        // print_r($this->imageFile);
        // echo '<hr>';

        // if ($this->validate()) {
        //     $this->imageFile->saveAs(Yii::$app->basePath.'/web/planilias/'. $this->imageFile->name);
        //     return true;
        // } else {
        //     return false;
        // }
        
        // $this->imageFile->saveAs(Yii::$app->basePath.'/web/planilias/'. $this->imageFile->name);
        $this->imageFile->saveAs(Yii::$app->basePath.'/web/planilias/'. 'excel.xlsx');
    }
}
