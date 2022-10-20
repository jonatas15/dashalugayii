<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
    select {
        background-color: white !important;
    }
    .bmd-form-group input {
        background-color: white !important;
    }
    select, select.form-control {
        -moz-appearance: auto !important;
        -webkit-appearance: auto !important;
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
        <?php //Pjax::begin(); ?>
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
                    'headerOptions' => ['style' => 'width:20%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'nome', '', $data->nome, $data->id);
                    }
                ],
                [
                    'attribute' => 'nome_cliente',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:20%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'nome_cliente', '', $data->nome_cliente, $data->id);
                    }
                ],
                [
                    'attribute' => 'tipovisitante',
                    'format' => 'raw',
                    'filter' => ['Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente'],
                    'headerOptions' => ['style' => 'width:15%'],
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
                    'headerOptions' => ['style' => 'width:3%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'data_visita', '', $data->data_visita, $data->id);
                    }
                ],
                [
                    'attribute' => 'hora_visita',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:3%'],
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
                [
                    'attribute' => 'num_disparo',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:3%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'num_disparo', '', $data->num_disparo, $data->id);
                    }
                ],
                'botconversaid',
                [
                    'attribute' => 'id',
                    'filter' => '',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:5%'],
                    'value' => function ($data) {
                        // $retorno = '<a href=""><i class="material-icons">telegram</i></a>';
                        $retorno = Html::button('<i class="material-icons">telegram</i></a>', ['onclick' => '
                            $.ajax({
                                type: "PUT",
                                url: "'.Yii::$app->homeUrl.'/api/visitakeys/update?id='.$data->id.'",
                                data: {
                                    id: '.$data->id.',
                                    acaobotconversa: "add_subscrito",
                                    nome: "'.$data->nome_cliente.'",
                                    tipo: "add_subscrito",
                                    telefone: "'.$data->num_disparo.'",
                                    mensagem: "add_subscrito"
                                }, success: function(result) {
                                    $.ajax({
                                        type: "GET",
                                        url: "'.Yii::$app->homeUrl.'/visitchaves/retornabot?id='.$data->id.'",
                                        data: {
                                            id: '.$data->id.',
                                            telefone: "'.$data->num_disparo.'"
                                        }, success: function(result) {
                                            console.log("sucesso, subscrito: ");
                                            console.log(result);
                                        }
                                    });
                                }
                            });
                        ']);
                        return $retorno;
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
                // 'num_disparo',
                //'convertido_venda',

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php //Pjax::end(); ?>
        <?php
            // $js = <<<JS
            // $(".doajax").on('click', function () {
            //     $.ajax({
            //         url: "{$url}",
            //         data: {id: 8},
            //         type: "get",
            //         success: function(){
            //             alert('SUCCESS');
            //         },
            //         error: function () {
            //             alert('ERROR');
            //         }
            //     });
            // });
            // JS;
            
            // $this->registerJs($js);
        ?>
    </div>
</div>
