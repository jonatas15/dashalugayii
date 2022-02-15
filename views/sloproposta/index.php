<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slo Propostas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slo-proposta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Slo Proposta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipo',
            'nome',
            'prazo_responder',
            'proprietario',
            'proprietario_info:ntext',
            //'codigo_imovel',
            //'imovel_info:ntext',
            //'imovel_valores',
            //'opcoes',
            //'usuario_id',
            //'tipo_imovel',
            //'motivo_locacao:ntext',
            //'endereco',
            //'complemento',
            //'bairro',
            //'cidade',
            //'estado',
            //'cep',
            //'dormitorios',
            //'aluguel',
            //'iptu',
            //'condominio',
            //'agua',
            //'luz',
            //'gas_encanado',
            //'total',
            //'numero',
            //'atvc_empresa',
            //'atvc_cnpj',
            //'atvc_nome_fantasia',
            //'atvc_atividade',
            //'atvc_data_constituicao',
            //'atvc_contato',
            //'atvc_telefone',
            //'data_inicio',
            //'id_slogica',
            //'etapa_andamento',
            //'codigo',
            //'nome',
            //'data_nascimento',
            //'cpf',
            //'telefone',
            //'email:email',
            //'documento_tipo',
            //'documento_numero',
            //'documento_orgao_emissor',
            //'documento_data_emissao',
            //'nacionalidade',
            //'telefone_residencial',
            //'telefone_celular',
            //'profissao',
            //'vinculo_empregaticio',
            //'data_admissao',
            //'renda',
            //'naoLocalizado',
            //'estado_civil',
            //'condicao_do_imovel',
            //'conj_nome',
            //'conj_email:email',
            //'conj_cpf',
            //'conj_documento_tipo',
            //'conj_documento_numero',
            //'conj_nacionalidade',
            //'conj_data_nascimento',
            //'conj_telefone_celular',
            //'conj_profissao',
            //'conj_renda',
            //'conj_num_dependentes',
            //'conj_frente:ntext',
            //'conj_verso:ntext',
            'frente:ntext',
            //'verso:ntext',
            //'proponentes:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
