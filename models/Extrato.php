<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "extrato".
 *
 * @property integer $id
 * @property string $mes
 * @property string $data_aplicacao
 * @property string $data_vencimento
 * @property string $receita_locacao
 * @property string $receitas_subtotal
 * @property string $iptu
 * @property string $iptu_apt_garag
 * @property string $condominio
 * @property string $taxa_condominio
 * @property string $outros
 * @property string $total
 * @property string $nosso_numero
 * @property string $numero_nota
 * @property string $honorarios_porcentagem
 * @property string $honorarios_valor
 * @property string $honorarios_admin
 * @property string $descontos_subtotal
 * @property string $total_depositado
 * @property string $descricao_descontos
 * @property string $valor_pago_ao_proprietario
 * @property string $data_pagamento
 * @property integer $locatario_id
 * @property integer $proprietario_id
 * @property integer $base_id
 *
 * @property Base $base
 * @property Proprietario $proprietario
 * @property Locatario $locatario
 */
class Extrato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extrato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mes', 'data_aplicacao', 'data_vencimento', 'locatario_id', 'proprietario_id', 'base_id'], 'required'],
            [['data_aplicacao', 'data_vencimento', 'data_pagamento'], 'safe'],
            [['receita_locacao', 'receitas_subtotal', 'iptu', 'iptu_apt_garag', 'condominio', 'taxa_condominio', 'outros', 'total', 'honorarios_porcentagem', 'honorarios_valor', 'honorarios_admin', 'descontos_subtotal', 'total_depositado', 'valor_pago_ao_proprietario'], 'number'],
            [['descricao_descontos'], 'string'],
            [['locatario_id', 'proprietario_id', 'base_id'], 'integer'],
            [['mes'], 'string', 'max' => 12],
            [['nosso_numero', 'numero_nota'], 'string', 'max' => 45],
            [['base_id'], 'exist', 'skipOnError' => true, 'targetClass' => Base::className(), 'targetAttribute' => ['base_id' => 'id']],
            [['proprietario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proprietario::className(), 'targetAttribute' => ['proprietario_id' => 'id']],
            [['locatario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Locatario::className(), 'targetAttribute' => ['locatario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mes' => 'Mês Referência',
            'data_aplicacao' => 'Data de Aplicação',
            'data_vencimento' => 'Data de Vencimento',
            'receita_locacao' => 'Receita: Locação',
            'receitas_subtotal' => 'Receitas: subtotal',
            'iptu' => 'IPTU',
            'iptu_apt_garag' => 'IPTU Apt. Garagem',
            'condominio' => 'Condomínio',
            'taxa_condominio' => 'Taxa de Condomínio',
            'outros' => 'Outros',
            'total' => 'Total',
            'nosso_numero' => 'Nosso Número',
            'numero_nota' => 'Nº Nota',
            'honorarios_porcentagem' => 'Honorários: Porcentagem',
            'honorarios_valor' => 'Honorários: valor',
            'honorarios_admin' => 'Honorários: Admin',
            'descontos_subtotal' => 'Descontos: Subtotal',
            'total_depositado' => 'Total depositado',
            'descricao_descontos' => 'Descrição dos Descontos',
            'valor_pago_ao_proprietario' => 'Valor pago ao Proprietário',
            'data_pagamento' => 'Data de Pagamento',
            'locatario_id' => 'Locatário',
            'proprietario_id' => 'Proprietário',
            'base_id' => 'Base ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBase()
    {
        return $this->hasOne(Base::className(), ['id' => 'base_id']);
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
    public function getLocatario()
    {
        return $this->hasOne(Locatario::className(), ['id' => 'locatario_id']);
    }
}
