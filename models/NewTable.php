<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "new_table".
 *
 * @property int $id
 * @property string|null $pessoa_responsavel
 * @property string|null $pessoa_agenciou
 * @property string|null $id_proprietarios
 * @property string|null $proprietarios
 * @property string|null $codigo
 */
class NewTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'new_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pessoa_responsavel', 'pessoa_agenciou', 'proprietarios'], 'string', 'max' => 245],
            [['id_proprietarios'], 'string', 'max' => 15],
            [['codigo'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pessoa_responsavel' => 'Pessoa Responsavel',
            'pessoa_agenciou' => 'Pessoa Agenciou',
            'id_proprietarios' => 'Id Proprietarios',
            'proprietarios' => 'Proprietarios',
            'codigo' => 'Codigo',
        ];
    }
}
