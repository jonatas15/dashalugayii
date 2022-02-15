<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slo Propostas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="slo-proposta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tipo',
            'prazo_responder',
            'proprietario',
            'proprietario_info:ntext',
            'codigo_imovel',
            'imovel_info:ntext',
            'imovel_valores',
            'opcoes',
            'usuario_id',
            'tipo_imovel',
            'motivo_locacao:ntext',
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
            'atvc_empresa',
            'atvc_cnpj',
            'atvc_nome_fantasia',
            'atvc_atividade',
            'atvc_data_constituicao',
            'atvc_contato',
            'atvc_telefone',
            'data_inicio',
            'id_slogica',
            'etapa_andamento',
            'codigo',
            'nome',
            'data_nascimento',
            'cpf',
            'telefone',
            'email:email',
            'documento_tipo',
            'documento_numero',
            'documento_orgao_emissor',
            'documento_data_emissao',
            'nacionalidade',
            'telefone_residencial',
            'telefone_celular',
            'profissao',
            'vinculo_empregaticio',
            'data_admissao',
            'renda',
            'naoLocalizado',
            'estado_civil',
            'condicao_do_imovel',
            'conj_nome',
            'conj_email:email',
            'conj_cpf',
            'conj_documento_tipo',
            'conj_documento_numero',
            'conj_nacionalidade',
            'conj_data_nascimento',
            'conj_telefone_celular',
            'conj_profissao',
            'conj_renda',
            'conj_num_dependentes',
            'conj_frente:ntext',
            'conj_verso:ntext',
            'frente:ntext',
            'verso:ntext',
            'proponentes:ntext',
        ],
    ]) ?>

</div>
