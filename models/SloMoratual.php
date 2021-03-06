<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slo_moratual".
 *
 * @property integer $id
 * @property integer $slo_pretendente_id
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $cep
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $residencia_atual
 * @property string $em_nome_de
 * @property integer $paga_aluguel
 * @property string $gastoatual_agua
 * @property string $gastoatual_luz
 * @property string $gastoatual_gas
 * @property string $tempo_residencia
 * @property integer $outros_imoveis_alugados
 * @property string $outros_ia_aluguel_encargos
 * @property integer $bens_financiados_emprestimos
 * @property string $bens_fe_nome_valor
 * @property integer $dependente_com_doenca
 * @property string $dependente_doente_infos
 * @property integer $dependentes_estudantes
 * @property string $dependentes_estudantes_info
 * @property string $slo_moratualcol
 *
 * @property SloPretendente $sloPretendente
 */
class SloMoratual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slo_moratual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slo_pretendente_id'], 'required'],
            [['slo_pretendente_id', 'paga_aluguel', 'outros_imoveis_alugados', 'bens_financiados_emprestimos', 'dependente_com_doenca', 'dependentes_estudantes'], 'integer'],
            [['residencia_atual', 'em_nome_de', 'tempo_residencia','locador_nome','locador_fone'], 'string'],
            [['gastoatual_agua', 'gastoatual_luz', 'gastoatual_gas'], 'number'],
            [['endereco', 'bairro', 'outros_ia_aluguel_encargos', 'bens_fe_nome_valor', 'dependente_doente_infos', 'dependentes_estudantes_info'], 'string', 'max' => 255],
            [['numero', 'complemento', 'cidade', 'slo_moratualcol'], 'string', 'max' => 45],
            [['cep', 'uf'], 'string', 'max' => 10],
            [['slo_pretendente_id'], 'exist', 'skipOnError' => true, 'targetClass' => SloPretendente::className(), 'targetAttribute' => ['slo_pretendente_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slo_pretendente_id' => 'Pretendente',
            'endereco' => 'Endere??o',
            'numero' => 'N??mero',
            'complemento' => 'Complemento',
            'cep' => 'Cep',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Estado (UF)',
            'residencia_atual' => 'Resid??ncia Atual',
            'em_nome_de' => 'Resid??ncia atual em nome de',
            'paga_aluguel' => 'Paga aluguel?',
            'gastoatual_agua' => 'Gasto atual: ??gua',
            'gastoatual_luz' => 'Gasto atual: luz',
            'gastoatual_gas' => 'Gasto atual: G??s',
            'tempo_residencia' => 'Tempo na resid??ncia',
            'outros_imoveis_alugados' => 'Possui outros im??veis alugados?',
            'outros_ia_aluguel_encargos' => 'Informar valor do aluguel + encargos',
            'bens_financiados_emprestimos' => 'H?? bens financiados ou empr??stimos?',
            'bens_fe_nome_valor' => 'Informar o bem e a presta????o mensal',
            'dependente_com_doenca' => 'Possui dependentes com doen??as Cr??nicas?',
            'dependente_doente_infos' => 'Informar gastos com farm??cia/sa??de',
            'dependentes_estudantes' => 'H?? dependentes estudantes?',
            'dependentes_estudantes_info' => 'Informar gastos com educa????o',
            'slo_moratualcol' => 'Slo Moratualcol',
            'locador_nome' => 'Nome do Locador/Propriet??rio/Imobili??ria',
            'locador_fone' => 'Telefone do Locador'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloPretendente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'slo_pretendente_id']);
    }
}
