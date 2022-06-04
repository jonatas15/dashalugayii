<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "superlogica".
 *
 * @property int $id
 * @property int|null $id_proposta
 * @property int|null $id_sl_proprietario
 * @property int|null $id_sl_imovel
 * @property int|null $id_sl_locatario
 * @property int|null $id_sl_contrato
 * @property string|null $sl_proprietario
 * @property string|null $sl_imovel
 * @property string|null $sl_locatario
 * @property string|null $sl_contrato
 * @property string|null $registro
 */
class Superlogica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'superlogica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_proposta', 'id_sl_proprietario', 'id_sl_imovel', 'id_sl_locatario', 'id_sl_contrato'], 'integer'],
            [['sl_proprietario', 'sl_imovel', 'sl_locatario', 'sl_contrato'], 'string'],
            [['registro'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_proposta' => 'Id Proposta',
            'id_sl_proprietario' => 'Id Sl Proprietario',
            'id_sl_imovel' => 'Id Sl Imovel',
            'id_sl_locatario' => 'Id Sl Locatario',
            'id_sl_contrato' => 'Id Sl Contrato',
            'sl_proprietario' => 'Sl Proprietario',
            'sl_imovel' => 'Sl Imovel',
            'sl_locatario' => 'Sl Locatario',
            'sl_contrato' => 'Sl Contrato',
            'registro' => 'Registro',
        ];
    }
}
