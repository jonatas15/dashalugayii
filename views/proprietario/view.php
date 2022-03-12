<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Proprietario */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proprietarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="proprietario-view">

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
            'nome',
            'conta_deposito',
            'codigo_imovel',
            'logradouro',
            'inicio_locacao',
            'mais_informacoes:ntext',
            'celular',
            'telefone',
            'email:email',
            'cpf_cnpj',
            'usuario_id',
            'rg',
            'orgao',
            'sexo',
            'data_nascimento',
            'nacionalidade',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'proposta_id',
            'iptu',
            'condominio',
            'foto_rg',
            'foto_cpf',
        ],
    ]) ?>

</div>
