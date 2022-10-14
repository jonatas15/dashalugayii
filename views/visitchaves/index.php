<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitchavesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas: Controle de Chaves';
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
<div class="visitchaves-index col-md-12">

    <p>
        <?php //Html::a('Create Visitchaves', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-md-12">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 

            Modal::begin([
                // 'header' => 'Nova Visita',
                'toggleButton' => [
                    'label' => '<i class="material-icons" style="font-size: 25px">key</i> | Nova Retirada',
                    'class'=>"btn btn-info",
                    'title'=>'Cadastrar Novo Registro de Visita',
                    'style'=>'float: left;margin-right: 5px;'
                ],
                'options' => [
                    'tabindex' => true
                ],
            ]);
            $model = new \app\models\visitChaves;
            echo '<div class="visitchaves-create">';
            echo $this->render('_form', [
                'model' => $model,
            ]) ;
            echo '</div>';
            echo '<div class="clearfix"></div>';
            Modal::end();
            ?>
    </div>
    <div class="clearfix">
    </div>
    <br/>
    <br/>
    <div class="col-md-12">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // 'id',
                // 'usuario_id',
                // 'nome',
                [
                    'attribute' => 'nome',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:15%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'nome', '', $data->nome, $data->id);
                    }
                ],
                [
                    'attribute' => 'nome_cliente',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:15%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'nome_cliente', '', $data->nome_cliente, $data->id);
                    }
                ],
                [
                    'attribute' => 'tipovisitante',
                    'format' => 'raw',
                    'filter' => [ 'Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente', ],
                    'headerOptions' => ['style' => 'width:13%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'tipovisitante', '', $data->tipovisitante, $data->id);
                    }
                ],
                [
                    'attribute' => 'codigo_imovel',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:5%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'codigo_imovel', '', $data->codigo_imovel, $data->id);
                    }
                ],
                [
                    'attribute' => 'data_visita',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:7%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'data_visita', '', $data->data_visita, $data->id);
                    }
                ],
                [
                    'attribute' => 'hora_visita',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:7%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'hora_visita', '', $data->hora_visita, $data->id);
                    }
                ],
                [
                    'attribute' => 'feedbacks',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:25%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'feedbacks', '', $data->feedbacks, $data->id);
                    }
                ],
                // 'tipovisitante',
                // 'codigo_imovel',
                //'dthr_retirada',
                //'dthr_entrega',
                // 'data_visita',
                // 'hora_visita',
                // 'feedbacks:ntext',
                //'mensagem:ntext',
                //'num_disparo',
                //'convertido_venda',

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
