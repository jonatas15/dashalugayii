<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProprietarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proprietarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .kv-editable-value {
        color: darkblue !important;
    }
    .btn-ativa-docs {
        padding: 8% 43% !important;
        /* border-radius: 15% !important; */
        font-size: 15px !important;
        text-transform: capitalize !important;
    }
    th {
        /* font-weight: bold !important; */
        font-size: 13px !important;
    }
</style>
<div class="proprietario-index">

    <h1><?php //= Html::encode($this->title) ?></h1>

    <p>
        <?php //= Html::a('Create Proprietario', ['create'], ['class' => 'btn btn-success']) ?>
        <br />
        <br />
        <br />
        <!-- <br /> -->
        <!-- <br /> -->
    </p>

    <?php Pjax::begin(['id' => 'samle2424243333', 'linkSelector' => 'a:not(.target-blank)']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            // 'id',
            // 'nome',
            [
                'attribute' => 'nome',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:15%'],
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'nome', '', $data->nome, $data->id);
                }
            ],
            [
                'attribute' => 'codigo_imovel',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:8%'],
                'value' => function ($data) {
                    return '<strong style="font-size: 15px;text-align:center">'.$this->context->imprime_campo_editavel('12', 'Proprietario', 'codigo_imovel', '', $data->codigo_imovel, $data->id).'</strong>';
                }
            ],
            // [
            //     'attribute' => 'conta_deposito',
            //     'format' => 'raw',
            //     'value' => function ($data) {
            //         return $this->context->imprime_campo_editavel('6', 'Proprietario', 'banco', 'Banco', $data->banco, $data->id).
            //         $this->context->imprime_campo_editavel('6', 'Proprietario', 'agencia', 'Agência', $data->agencia, $data->id).
            //         $this->context->imprime_campo_editavel('6', 'Proprietario', 'operacao', 'Operação', $data->operacao, $data->id).
            //         $this->context->imprime_campo_editavel('6', 'Proprietario', 'conta_deposito', 'Nº Conta', $data->conta_deposito, $data->id);
            //     }
            // ],
            [
                'attribute' => 'email',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'email', '', $data->email, $data->id);
                }
            ],
            [
                'attribute' => 'celular',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'celular', '', $data->celular, $data->id);
                }
            ],
            // [
            //     'attribute' => 'email',
            //     'format' => 'raw',
            //     'value' => function ($data) {
            //         return $this->context->imprime_campo_editavel('12', 'Proprietario', 'email', '', $data->email, $data->id);
            //     }
            // ],
            [
                'attribute' => 'cpf_cnpj',
                'headerOptions' => ['style' => 'width:12%'],
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'cpf_cnpj', '', $data->cpf_cnpj, $data->id);
                }
            ],
            // [
            //     'attribute' => 'iptu',
            //     'format' => 'raw',
            //     'value' => function ($data) {
            //         return $this->context->imprime_campo_editavel('12', 'Proprietario', 'iptu', '', $data->iptu, $data->id);
            //     }
            // ],
            [
                'attribute' => 'condominio',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'condominio', '', $data->condominio, $data->id);
                }
            ],
            // 'logradouro',
            //'inicio_locacao',
            //'mais_informacoes:ntext',
            // 'telefone',
            //'usuario_id',
            //'rg',
            //'orgao',
            //'sexo',
            //'data_nascimento',
            //'nacionalidade',
            //'cep',
            //'endereco',
            //'numero',
            //'complemento',
            //'bairro',
            //'cidade',
            //'estado',
            //'proposta_id',
            [
                // 'title' => 'Editar',
                'header'=>'Docs',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width: 5%'],
                'value' => function($data) {
                    $proprietario = \app\models\Proprietario::find()->where([
                        'id' => $data->id
                    ])->one();
                    return $this->render('/proprietario/_modalverfiles', [
                        'model' => $proprietario,
                        'proposta' => $data->id,
                        'action' => 'update',
                        'classe' => ' btn-ativa-docs'
                    ]);
                }
            ],
            [
                // 'title' => 'Editar',
                'header'=>'PDF',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width: 5%'],
                'value' => function($data) {
                    $proprietario = \app\models\Proprietario::find()->where([
                        'id' => $data->id
                    ])->one();
                    return Html::a("<i class='fa fa-print'></i>", ['report', 'id' => $data->id], [
                        'class' => 'btn btn-info target-blank btn-ativa-docs',
                        'target'=>'_blank'
                    ]);
                }
            ]
            //'foto_rg',
            //'foto_cpf',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
