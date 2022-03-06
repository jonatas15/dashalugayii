<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_exfiles".
 *
 * @property integer $id
 * @property integer $proposta_id
 * @property string $cpf
 * @property string $rg_frente
 * @property string $rg_verso
 * @property string $extrato_bancario
 * @property string $imposto_de_renda
 * @property string $comprovante_de_endereco
 * @property string $carteira_de_trabalho
 * @property string $extrato_inss
 */
class SloExfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_exfiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proposta_id'], 'required'],
            [['proposta_id'], 'integer'],
            [['cpf', 'rg_frente', 'rg_verso', 'extrato_bancario', 'imposto_de_renda', 'comprovante_de_endereco', 'carteira_de_trabalho', 'extrato_inss'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proposta_id' => 'Pretendente ID',
            'cpf' => 'Cpf',
            'rg_frente' => 'Rg Frente',
            'rg_verso' => 'Rg Verso',
            'extrato_bancario' => 'Extrato Bancario',
            'imposto_de_renda' => 'Imposto De Renda',
            'comprovante_de_endereco' => 'Comprovante De Endereco',
            'carteira_de_trabalho' => 'Carteira De Trabalho',
            'extrato_inss' => 'Extrato Inss',
        ];
    }
    // Para a API
    public function fields() {
        return [
            'id',
            'proposta_id'
        ];
    }
}
