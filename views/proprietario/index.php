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

    <?php Pjax::begin(); ?>
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
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'nome', '', $data->nome, $data->id);
                }
            ],
            [
                'attribute' => 'codigo_imovel',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'codigo_imovel', '', $data->codigo_imovel, $data->id);
                }
            ],
            [
                'attribute' => 'conta_deposito',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'conta_deposito', '', $data->conta_deposito, $data->id);
                }
            ],
            [
                'attribute' => 'celular',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'celular', 'Celular', $data->celular, $data->id).'<br>'.
                    $this->context->imprime_campo_editavel('12', 'Proprietario', 'email', 'Email', $data->email, $data->id);
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
                    return $this->context->imprime_campo_editavel('12', 'Proprietario', 'condominio', '', $data->condominio, $data->id).'<br>'.
                    $this->context->imprime_campo_editavel('12', 'Proprietario', 'iptu', 'IPTU', $data->iptu, $data->id);
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
                'value' => function($data) {
                    $proprietario = \app\models\Proprietario::find()->where([
                        'id' => $data->id
                    ])->one();
                    return $this->render('/proprietario/_modalverfiles', [
                        'model' => $proprietario,
                        'proposta' => $data->id,
                        'action' => 'update'
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
