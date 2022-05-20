<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sloavisos".
 *
 * @property int $id
 * @property int $etapa
 * @property int $situacao
 * @property string|null $whats
 * @property string|null $email
 * @property string|null $outro
 */
class Sloavisos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sloavisos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['etapa', 'situacao'], 'required'],
            [['etapa', 'situacao'], 'integer'],
            [['whats', 'email', 'outro'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'etapa' => 'Etapa',
            'situacao' => 'Situacao',
            'whats' => 'Whats',
            'email' => 'Email',
            'outro' => 'Outro',
        ];
    }
}
