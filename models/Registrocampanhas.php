<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registrocampanhas".
 *
 * @property int $id
 * @property string $fonte
 * @property string|null $utm_medium
 * @property string|null $utm_source
 * @property string|null $utm_campaign
 * @property string|null $data
 * @property string|null $ip
 * @property string|null $obs
 * @property string|null $formulario
 */
class Registrocampanhas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registrocampanhas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fonte'], 'required'],
            [['fonte', 'obs'], 'string'],
            [['data'], 'safe'],
            [['utm_medium', 'utm_source', 'utm_campaign'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 25],
            [['formulario'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fonte' => 'Fonte',
            'utm_medium' => 'Utm Medium',
            'utm_source' => 'Utm Source',
            'utm_campaign' => 'Utm Campaign',
            'data' => 'Data',
            'ip' => 'Ip',
            'obs' => 'Obs',
            'formulario' => 'Formulario',
        ];
    }
}
