<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "base".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nome
 * @property double $valor
 * @property string $logradouro
 * @property string $numero_apartamento
 * @property string $numero_box
 * @property integer $proprietario_id
 *
 * @property Proprietario $proprietario
 * @property Extrato[] $extratos
 */
class Base extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nome', 'valor'], 'required'],
            [['valor'], 'number'],
            [['proprietario_id'], 'integer'],
            [['codigo', 'numero_apartamento', 'numero_box'], 'string', 'max' => 10],
            [['nome', 'logradouro'], 'string', 'max' => 245],
            [['proprietario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proprietario::className(), 'targetAttribute' => ['proprietario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código do Imóvel',
            'nome' => 'Nome',
            'valor' => 'Valor',
            'logradouro' => 'Logradouro',
            'numero_apartamento' => 'Nº do Apartamento',
            'numero_box' => 'Nº do Box',
            'proprietario_id' => 'Proprietário',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProprietario()
    {
        return $this->hasOne(Proprietario::className(), ['id' => 'proprietario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtratos()
    {
        return $this->hasMany(Extrato::className(), ['base_id' => 'id']);
    }
}
