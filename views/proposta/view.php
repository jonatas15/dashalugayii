<?php

// PARA a contraproposta
/*
- valor do imóvel anunciado (aluguel) vs valor proposto pelo locatário (mostrar diferença, sistema calcular)
- campo descritivo (ou desejar via chat conversar diretamente)
- Obs.: (separar bem as etapas, visualmente, evitar poluição visual)
- Chat pra depois de haver aceitação das propostas (pra proposta e contraproposta)
*/
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */

$this->title = 'Proposta pelo Imóvel PIN-'.$model->codigo_imovel;
$this->params['breadcrumbs'][] = ['label' => 'Propostas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slo-proposta-view">

    <h3 style="text-align:center"><?= Html::encode($this->title) ?></h3>
    <hr>
    <div class="col-md-6" style="background-color: ghostwhite">
        <h4 style="background-color: lightgray; text-align: center; padding: 1%; font-weight: bolder">Dados da Proposta</h4>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                'tipo',
                //'prazo_responder',
                [
                    'attribute' => 'prazo_responder',
                    'value' => function ($data) {
                        return date('d/m/Y', strtotime($data->prazo_responder));
                    }
                ],
                'proprietario',
                'proprietario_info:ntext',
                'imovel_info:ntext',
                'imovel_valores',
                'opcoes',
                // 'usuario.nome',
                [
                    'attribute'=>'usuario_id',
                    'value'=>$model->usuario->nome
                ],
            ],
        ]) ?>
        <h4 style="background-color: lightgray; text-align: center; padding: 1%; font-weight: bolder">Dados do Imóvel</h4>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'tipo_imovel',
                'motivo_locacao',
                'endereco',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'cep',
                'dormitorios',
                'aluguel',
                'iptu',
                'condominio',
                'agua',
                'luz',
                'gas_encanado',
                'total',
                'numero',
                'opcoes',
                'usuario_id',
                'atvc_empresa',
                'atvc_cnpj',
                'atvc_nome_fantasia',
                'atvc_atividade',
                'atvc_data_constituicao',
                'atvc_contato',
                'atvc_telefone',
            ],
        ]) ?>
    </div>
</div>