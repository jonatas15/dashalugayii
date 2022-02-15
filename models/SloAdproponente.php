<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_adproponente".
 *
 * @property integer $id
 * @property integer $pretendente_id
 * @property string $nome
 * @property string $cpf
 * @property string $telefone_fixo
 * @property string $telefone_celular
 * @property string $email
 * @property string $renda
 * @property string $estado_civil
 * @property string $vinculo_empregaticio
 * @property string $telefone_residencial
 */
class SloAdproponente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_adproponente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pretendente_id'], 'required'],
            [['pretendente_id'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['cpf'], 'string', 'max' => 12],
            [['telefone_fixo', 'telefone_celular', 'estado_civil', 'telefone_residencial'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 30],
            [['renda'], 'string', 'max' => 10],
            [['vinculo_empregaticio'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pretendente_id' => 'Pretendente ID',
            'nome' => 'Nome',
            'cpf' => 'Cpf',
            'telefone_fixo' => 'Telefone Fixo',
            'telefone_celular' => 'Telefone Celular',
            'email' => 'Email',
            'renda' => 'Renda',
            'estado_civil' => 'Estado Civil',
            'vinculo_empregaticio' => 'Vinculo Empregaticio',
            'telefone_residencial' => 'Telefone Residencial',
        ];
    }
}
