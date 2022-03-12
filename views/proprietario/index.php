<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProprietarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proprietarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proprietario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Proprietario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'conta_deposito',
            'codigo_imovel',
            'logradouro',
            //'inicio_locacao',
            //'mais_informacoes:ntext',
            //'celular',
            //'telefone',
            //'email:email',
            //'cpf_cnpj',
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
            //'iptu',
            //'condominio',
            //'foto_rg',
            //'foto_cpf',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
