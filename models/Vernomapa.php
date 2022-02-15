<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vernomapa".
 *
 * @property integer $id
 * @property string $thumb
 * @property string $codigo
 * @property string $logradouro
 * @property string $bairro
 * @property string $cidade
 * @property string $contrato
 * @property string $valor_venda
 * @property string $valor_locacao
 * @property string $data
 * @property string $ip
 */
class Vernomapa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vernomapa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumb', 'logradouro', 'bairro', 'ip'], 'string', 'max' => 245],
            [['codigo'], 'string', 'max' => 10],
            [['cidade', 'valor_venda', 'valor_locacao', 'data'], 'string', 'max' => 100],
            [['contrato'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb' => 'Imagem',
            'codigo' => 'Código',
            'logradouro' => 'Logradouro',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'contrato' => 'Contrato',
            'valor_venda' => 'Valor de Venda',
            'valor_locacao' => 'Valor de Locação',
            'data' => 'Data e Hora',
            'ip' => 'Endereço Ip',
        ];
    }
}
