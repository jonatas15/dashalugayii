<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pessoasjet".
 *
 * @property int $id
 * @property string|null $person_id
 * @property string|null $nome
 * @property string|null $telefones
 * @property string|null $emails
 */
class Pessoasjet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pessoasjet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefones', 'emails'], 'string'],
            [['person_id'], 'string', 'max' => 20],
            [['nome'], 'string', 'max' => 245],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'nome' => 'Nome',
            'telefones' => 'Telefones',
            'emails' => 'Emails',
        ];
    }
}
