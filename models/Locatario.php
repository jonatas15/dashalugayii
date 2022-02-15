<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "locatario".
 *
 * @property integer $id
 * @property string $nome
 * @property string $contato
 * @property string $codigo_do_imovel
 * @property string $logradouro
 * @property string $numero_do_apartamento
 * @property string $numero_do_box
 * @property string $inicio_da_locacao
 * @property string $mais_informacoes
 * @property integer $usuario_id
 * @property string $cpf
 *
 * @property Extrato[] $extratos
 * @property Usuario $usuario
 */
class Locatario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locatario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['inicio_da_locacao'], 'safe'],
            [['mais_informacoes'], 'string'],
            [['usuario_id'], 'integer'],
            [['nome'], 'string', 'max' => 145],
            [['contato'], 'string', 'max' => 100],
            [['codigo_do_imovel'], 'string', 'max' => 11],
            [['logradouro'], 'string', 'max' => 245],
            [['numero_do_apartamento', 'numero_do_box'], 'string', 'max' => 10],
            [['cpf'], 'string', 'max' => 20],
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
            'nome' => 'Locatário',
            'contato' => 'Contato',
            'codigo_do_imovel' => 'Código do Imóvel',
            'logradouro' => 'Logradouro',
            'numero_do_apartamento' => 'Nº do Apartamento',
            'numero_do_box' => 'Nº do Box',
            'inicio_da_locacao' => 'Início da Locação',
            'mais_informacoes' => 'Mais Informações',
            'usuario_id' => 'Usuário',
            'cpf' => 'CPF/CNPJ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtratos()
    {
        return $this->hasMany(Extrato::className(), ['locatario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}
